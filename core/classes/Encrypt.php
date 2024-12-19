<?php

namespace Core\Classes;

/**
 * Class for encrypting and decrypting strings
 *
 * @package Core
 * @author  Amir Zuhdi Wibowo, Muhammad Dimas Mulyono, Rinda Kusuma Dewi
 * @license MIT
 */
class Encrypt
{
  /**
   * Encrypts a plaintext string using Vigenere, Caesar, and AES algorithms
   *
   * @param string $content The input string to encrypt
   *
   * @return string The encrypted string
   */
  public static function encrypt(string $content): bool|string {
    $output = Cipher::encryptVigenere($content);
    $output = Cipher::encryptCaesar($output);
    $output = Cipher::encryptAes($output);
    return $output;
  }

  /**
   * Decrypts a ciphertext string using AES, Caesar, and Vigenere algorithms
   *
   * @param string $content The input string to decrypt
   *
   * @return string The decrypted string
   */
  public static function decrypt(string $content, string $iv): bool|string {
    $decrypt = Cipher::decryptAes($content, $iv);
    $decrypt = Cipher::decryptCaesar($decrypt);
    $decrypt = Cipher::decryptVigenere($decrypt);
    return $decrypt;
  }
}

