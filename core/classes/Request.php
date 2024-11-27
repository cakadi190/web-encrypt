<?php

namespace Core\Classes;

/**
 * Class untuk memudahkan mengakses variabel input request
 *
 * @package Core
 */
class Request
{
  /**
   * Mendapatkan nilai input berdasar key yang diberikan
   *
   * @param string $key Nama key dari input yang ingin diambil
   * @param mixed $default Nilai default jika key tidak ditemukan
   *
   * @return mixed Nilai input yang diambil
   */
  public static function input(string $key, $default = null)
  {
    if (isset($_POST[$key])) {
      return $_POST[$key];
    } elseif (isset($_GET[$key])) {
      return $_GET[$key];
    } elseif (isset($_REQUEST[$key])) {
      return $_REQUEST[$key];
    } elseif (
      strtolower($_SERVER['REQUEST_METHOD']) === 'put' ||
      strtolower($_SERVER['REQUEST_METHOD']) === 'patch' ||
      strtolower($_SERVER['REQUEST_METHOD']) === 'delete'
    ) {
      $input = json_decode(file_get_contents('php://input'), true);
      if (is_array($input) && array_key_exists($key, $input)) {
        return $input[$key];
      } else {
        return $default;
      }
    }

    return $default;
  }

  /**
   * Memeriksa apakah request dibuat dengan menggunakan method yang sesuai
   *
   * @param string $method Nama method yang ingin di-periksa
   *
   * @return bool True jika method sesuai, false jika tidak
   */
  public static function isMethod(string $method): bool
  {
    return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
  }

  /**
   * Mendapatkan semua input yang dikirimkan dalam bentuk array
   *
   * @return array Informasi input yang dikirimkan
   */
  public static function all(): array
  {
    $input = array_merge($_GET, $_POST, $_FILES);

    if (
      strtolower($_SERVER['REQUEST_METHOD']) === 'put' ||
      strtolower($_SERVER['REQUEST_METHOD']) === 'patch' ||
      strtolower($_SERVER['REQUEST_METHOD']) === 'delete'
    ) {
      $inputBody = json_decode(file_get_contents(
        'php://input',
        false,
        stream_context_get_default(),
        0,
        $_SERVER['CONTENT_LENGTH']
      ), true);
      $input = array_merge($input, $inputBody);
    }

    return $input;
  }

  /**
   * Mendapatkan file yang diupload berdasarkan key yang diberikan
   *
   * @param string $key Nama key dari file yang ingin diambil
   *
   * @return array|null Informasi file yang diupload atau null jika tidak ditemukan
   */
  public static function file(string $key): ?array
  {
    return $_FILES[$key] ?? null;
  }
}
