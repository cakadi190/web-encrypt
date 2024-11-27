<?php

namespace Core\Classes;

class File
{
  /**
   * Create a directory
   *
   * @param string $path Path to the directory
   * @param int $permissions Permissions for the directory
   * @return bool True on success, false on failure
   */
  public function mkDir(string $path, int $permissions = 0755): bool
  {
    return mkdir($path, $permissions, true);
  }

  /**
   * Remove a directory
   *
   * @param string $path Path to the directory
   * @return bool True on success, false on failure
   */
  public function rmDir(string $path): bool
  {
    return rmdir($path);
  }

  /**
   * Get the contents of a file
   *
   * @param string $file Path to the file
   * @return string|false File contents on success, false on failure
   */
  public function getFile(string $file)
  {
    return file_get_contents($file);
  }

  /**
   * Write data to a file
   *
   * @param string $file Path to the file
   * @param string $data Data to write
   * @return bool True on success, false on failure
   */
  public function putFile(string $file, string $data): bool
  {
    return file_put_contents($file, $data) !== false;
  }

  /**
   * Check if a path exists and determine if it's a directory or a file
   *
   * @param string $path Path to check
   * @return string|null 'd' if directory, 'f' if file, null if not exists
   */
  public function isExists(string $path): ?string
  {
    if (is_dir($path)) {
      return 'd';
    } elseif (is_file($path)) {
      return 'f';
    }
    return null;
  }
}
