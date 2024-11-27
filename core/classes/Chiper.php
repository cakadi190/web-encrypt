<?php

namespace Core\Classes;

/**
 * Class Cipher
 * Provides methods for encrypting and decrypting strings using Vigenere, Caesar, and AES algorithms.
 *
 * @package Core
 */
class Cipher
{
  private static $keyCaesar = 86;
  private static $key = [];
  private static $keySize = 1;
  private static $initializationVector;
  private static $initialized = false;
  private static $keyString;

  /**
   * Initialize the class cipher with a key.
   * @param string $keyString
   */
  public function __construct(string $keyString = "test")
  {
    self::$keyString = $keyString;
  }

  /**
   * Ensures encryption keys are initialized before any operation
   */
  private static function initialize()
  {
    if (!self::$initialized) {
      self::$key = unpack('C*', self::$keyString);
      self::$keySize = max(1, count(self::$key));
      self::$initialized = true;
    }
  }

  /**
   * Get the last used initialization vector
   * 
   * @return string|null The initialization vector or null if not set
   */
  public static function getIV()
  {
    return self::$initializationVector;
  }

  /**
   * Encrypts a plaintext string using the Vigenere cipher.
   *
   * @param string $plaintext The input string to encrypt.
   * @return string The encrypted string.
   */
  public static function encryptVigenere(string $plaintext)
  {
    self::initialize();

    $bytes = unpack('C*', $plaintext);
    if (!$bytes) {
      return '';
    }

    $result = array_map(function ($i, $val) {
      $keyIndex = (($i - 1) % self::$keySize) + 1;
      return ($val + self::$key[$keyIndex]) % 256;
    }, array_keys($bytes), $bytes);

    return pack('C*', ...$result);
  }

  /**
   * Decrypts a ciphertext string using the Vigenere cipher.
   *
   * @param string $ciphertext The input string to decrypt.
   * @return string The decrypted string.
   */
  public static function decryptVigenere(string $ciphertext)
  {
    self::initialize();

    $bytes = unpack('C*', $ciphertext);
    if (!$bytes) {
      return '';
    }

    $result = array_map(function ($i, $val) {
      $keyIndex = (($i - 1) % self::$keySize) + 1;
      return ($val + 256 - self::$key[$keyIndex]) % 256;
    }, array_keys($bytes), $bytes);

    return pack('C*', ...$result);
  }

  /**
   * Encrypts a plaintext string using the Caesar cipher.
   *
   * @param string $plaintext The input string to encrypt.
   * @return string The encrypted string.
   */
  public static function encryptCaesar(string $plaintext)
  {
    $bytes = unpack('C*', $plaintext);
    if (!$bytes) {
      return '';
    }

    $result = array_map(function ($val) {
      return ($val + self::$keyCaesar) % 256;
    }, $bytes);

    return pack('C*', ...$result);
  }

  /**
   * Decrypts a ciphertext string using the Caesar cipher.
   *
   * @param string $ciphertext The input string to decrypt.
   * @return string The decrypted string.
   */
  public static function decryptCaesar(string $ciphertext)
  {
    $bytes = unpack('C*', $ciphertext);
    if (!$bytes) {
      return '';
    }

    $result = array_map(function ($val) {
      return ($val + 256 - self::$keyCaesar) % 256;
    }, $bytes);

    return pack('C*', ...$result);
  }

  /**
   * Encrypts a plaintext string using the AES cipher.
   *
   * @param string $plaintext The input string to encrypt.
   * @return string The encrypted string
   */
  public static function encryptAes($plaintext)
  {
    $mkey = hash('sha256', self::$keyString, true);
    self::$initializationVector = openssl_random_pseudo_bytes(16);
    return openssl_encrypt($plaintext, "AES-256-CBC", $mkey, OPENSSL_RAW_DATA, self::$initializationVector);
  }

  /**
   * Decrypts a ciphertext string using the AES cipher.
   *
   * @param string $ciphertext The input string to decrypt.
   * @param string $iv Optional IV to use for decryption. If not provided, uses the stored IV.
   * @return string|false The decrypted string or false on failure.
   */
  public static function decryptAes($ciphertext, $iv = null)
  {
    $mkey = hash('sha256', self::$keyString, true);
    $useIV = $iv ?? self::$initializationVector;
    return openssl_decrypt($ciphertext, "AES-256-CBC", $mkey, OPENSSL_RAW_DATA, $useIV);
  }
}

