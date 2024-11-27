<?php

namespace Core\Classes;

/**
 * Class Response
 * @package Core\Classes
 * @author  Rully Anggara <rullyanggara@gmail.com>
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
    echo json_encode($data);
    exit;
  }

  /**
   * @param string $file
   * @param string $name
   * @param string $type
   */
  public static function download(string $file, string $name, string $type = 'application/octet-stream')
  {
    $size = filesize($file);
    header("Content-Type: $type");
    header("Content-Disposition: attachment; filename=\"$name\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: $size");
    readfile($file);
    exit;
  }
}
