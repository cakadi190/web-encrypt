<?php

use Core\Classes\Encrypt;
use Core\Classes\Cipher;
use Core\Classes\File;
use Core\Classes\Request;
use Core\Classes\Response;

include_once __DIR__ . "/core/autoload.php";

/**
 * Class FileEncryptionHandler
 * 
 * Menangani proses enkripsi dan dekripsi file dengan berbagai validasi keamanan
 * 
 * @package FileEncryption
 * @author [Nama Anda]
 * @version 1.0.0
 */
class FileEncryptionHandler
{
  /**
   * Daftar ekstensi file yang diizinkan untuk enkripsi
   * 
   * @var string[]
   */
  private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

  /**
   * Ukuran maksimum file yang diizinkan (5MB)
   * 
   * @var int
   */
  private const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

  /**
   * Direktori penyimpanan sementara file terenkripsi
   * 
   * @var string
   */
  private const TMP_DIRECTORY = './tmp';

  /**
   * Layanan request
   * 
   * @var Request
   */
  private Request $requestService;

  /**
   * Layanan cipher untuk enkripsi
   * 
   * @var Cipher
   */
  private Cipher $cipherService;

  /**
   * Layanan enkripsi
   * 
   * @var Encrypt
   */
  private Encrypt $encryptService;

  /**
   * Layanan response
   * 
   * @var Response
   */
  private Response $responseService;

  /**
   * Layanan file
   * 
   * @var File
   */
  private File $fileService;

  /**
   * Konstruktor untuk inisialisasi layanan-layanan yang diperlukan
   * 
   * @param Request $requestService Layanan untuk menangani request
   * @param Cipher $cipherService Layanan cipher untuk enkripsi
   * @param Encrypt $encryptService Layanan enkripsi
   * @param Response $responseService Layanan untuk mengirim response
   * @param File $fileService Layanan untuk manipulasi file
   */
  public function __construct(
    Request $requestService,
    Cipher $cipherService,
    Encrypt $encryptService,
    Response $responseService,
    File $fileService
  ) {
    $this->requestService = $requestService;
    $this->cipherService = $cipherService;
    $this->encryptService = $encryptService;
    $this->responseService = $responseService;
    $this->fileService = $fileService;
  }

  /**
   * Validasi file sebelum proses enkripsi
   * 
   * @param array $file Data file yang akan divalidasi
   * @return bool Mengembalikan true jika file valid
   * @throws \Exception Jika file tidak valid dengan pesan kesalahan yang spesifik
   */
  private function validateFile(array $file): bool
  {
    // Periksa apakah file diunggah
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
      throw new \Exception("No file uploaded", 400);
    }

    // Validasi ukuran file
    if ($file['size'] > self::MAX_FILE_SIZE) {
      throw new \Exception("File too large. Maximum size is " . (self::MAX_FILE_SIZE / 1024 / 1024) . "MB", 413);
    }

    // Validasi ekstensi
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
      throw new \Exception("Unsupported file type", 415);
    }

    return true;
  }

  /**
   * Proses enkripsi file
   * 
   * @param array $file File yang akan dienkripsi
   * @return array Informasi file terenkripsi
   * @throws \Exception Jika terjadi kesalahan selama proses enkripsi
   */
  private function encryptFile(array $file): array
  {
    $this->validateFile($file);

    $fileContent = $this->fileService->getFile($file["tmp_name"]);
    $encryptedContent = $this->encryptService->encrypt($fileContent);
    $iv = $this->cipherService->getIv();

    // Buat direktori tmp jika belum ada
    if (!$this->fileService->isExists(self::TMP_DIRECTORY)) {
      $this->fileService->mkDir(self::TMP_DIRECTORY);
    }

    // Gunakan random_bytes untuk nama file yang lebih aman
    $filename = bin2hex(random_bytes(16)) . '.enc';
    $this->fileService->putFile(self::TMP_DIRECTORY . '/' . $filename, $encryptedContent);

    return [
      "status" => "success",
      "message" => "File encrypted successfully",
      "code" => 200,
      "error" => false,
      "success" => true,
      "data" => [
        "fileName" => $filename,
        "iv" => bin2hex($iv),
      ],
    ];
  }

  /**
   * Menangani request enkripsi/dekripsi
   * 
   * Metode ini memeriksa tipe request dan menjalankan proses yang sesuai
   * Menangani error dan mengirimkan response dalam format JSON
   * 
   * @return void
   */
  public function handleRequest(): void
  {
    try {
      // Early return untuk metode yang tidak diizinkan
      if (!$this->requestService->isMethod("POST")) {
        throw new \Exception("Access denied", 403);
      }

      $type = $this->requestService->input("type");

      switch ($type) {
        case "encrypt":
          $file = $this->requestService->file('file');
          $responseData = $this->encryptFile($file);
          echo $this->responseService->json($responseData, 200);
          break;
        case "decrypt":
          // Implementasi dekripsi nanti
          echo $this->responseService->json(["message" => "Decryption not implemented"], 200);
          break;
        default:
          throw new \Exception("Resource not found", 404);
      }
    } catch (\Throwable $th) {
      echo $this->responseService->json([
        "message" => $th->getMessage(),
        "code" => $th->getCode(),
        "error" => true,
        "success" => false,
      ], $th->getCode() ?: 500);
    }
  }
}

// Inisialisasi layanan
$requestService = new Request();
$cipherService = new Cipher("alololo");
$encryptService = new Encrypt();
$responseService = new Response();
$fileService = new File();

// Jalankan handler
$handler = new FileEncryptionHandler(
  $requestService,
  $cipherService,
  $encryptService,
  $responseService,
  $fileService
);
$handler->handleRequest();