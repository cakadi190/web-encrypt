<?php

namespace Core\Classes;

/**
 * Class Response
 * @package Core\Classes
 * @author  Amir Zuhdi Wibowo, Muhammad Dimas Mulyono, Rinda Kusuma Wardani
 * @version 1.0
 */
class Response
{
  /**
   * @param array $data
   * @param int $status
   * @param array $header
   */
  public static function json(array $data, int $status = 200, array $header = [])
  {
    http_response_code($status);
    header('Content-Type: application/json');
    foreach ($header as $key => $value) {
      header($key . ': ' . $value);
    }

    // Convert all strings in the array to UTF-8
    array_walk_recursive($data, function (&$item) {
      if (is_string($item)) {
        // Convert to UTF-8 if not already
        $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
      }
    });

    // Encode data to JSON
    $jsonData = json_encode($data);

    // Check for JSON encoding errors
    if ($jsonData === false) {
      // Handle the error, e.g., log it or return an error response
      var_dump(json_last_error_msg());
      echo json_encode(['error' => 'Failed to encode data to JSON']);
      return;
    }

    // Output the JSON data
    echo $jsonData;
  }

  /**
   * @param string $file
   * @param string $name
   * @param string $type
   */
  public static function download(string $file, string $name, string $type = 'application/octet-stream')
  {
    // Set headers
    header("Content-Type: $type");
    header("Content-Disposition: attachment; filename=\"" . basename($name) . "\"");
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");

    echo $file;

    exit;
  }
}

