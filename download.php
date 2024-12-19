<?php

use Core\Classes\File;
use Core\Classes\Request;
use Core\Classes\Response;

include_once __DIR__ . "/core/autoload.php";

/**
 * Class DownloadHandler
 * 
 * Handles file download operations.
 * 
 * @package FileDownload
 * @version 1.0.0
 * 
 * @property File $file Service for file manipulation
 * @property Request $request Service for handling requests
 * @property Response $response Service for sending responses
 * 
 * @method void handle() Processes the download request
 * 
 * @author
 * Amir Zuhdi Wibowo
 * Muhammad Dimas Mulyono
 * Rinda Kusuma Dewi
 */
class DownloadHandler
{
  /**
   * Constructor to initialize necessary services
   * 
   * @param File $file Service for file manipulation
   * @param Request $request Service for handling requests
   * @param Response $response Service for sending responses
   */
  public function __construct(
    protected readonly File $file,
    protected readonly Request $request,
    protected readonly Response $response
  ) {
  }

  /**
   * Handles the download request by retrieving the file and sending it as a response
   * 
   * @return void
   * @throws \Exception If the file cannot be retrieved or sent
   */
  public function handleRequest()
  {
    $fileName = $this->request->input("filename");

    if (!$this->file->isExists("./tmp/$fileName")) {
      return $this->response->json([
        "error" => "File tidak ditemukan",
        "message" => "Silakan periksa kembali nama file yang Anda masukkan.",
      ], 404);
    }

    $getFile = $this->file->getFile(__DIR__ . "/tmp/" . $fileName);

    $this->response->download($getFile, $fileName, 'text/plain');
  }
}

$file = new File();
$request = new Request();
$response = new Response();

$instance = new DownloadHandler($file, $request, $response);
$instance->handleRequest();

