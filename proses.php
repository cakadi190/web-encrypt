<?php
$key_str = "test";
$key_caesar = 86;

$key = unpack('C*', $key_str);
$key_size = count($key);
$iv = '';

function enkripsi_vigenere(string $plaintext)
{
  global $key, $key_size;
  $plaintext = unpack('C*', $plaintext);
  $result = [];
  foreach ($plaintext as $i => $val) {
    $result[$i] = ($val + $key[($i - 1) % $key_size + 1]) % 256;
  }
  return pack('C*', ...$result);
}

function dekripsi_vigenere(string $ciphertext)
{
  global $key, $key_size;
  $ciphertext = unpack('C*', $ciphertext);
  $result = [];
  foreach ($ciphertext as $i => $val) {
    $result[$i] = ($val + 256 - $key[($i - 1) % $key_size + 1]) % 256;
  }
  return pack('C*', ...$result);
}

function enkripsi_caesar(string $plaintext)
{
  global $key_caesar;
  $plaintext = unpack('C*', $plaintext);
  $result = [];
  foreach ($plaintext as $i => $val) {
    $result[$i] = ($val + $key_caesar) % 256;
  }
  return pack('C*', ...$result);
}

function dekripsi_caesar(string $ciphertext)
{
  global $key_caesar;
  $ciphertext = unpack('C*', $ciphertext);
  $result = [];
  foreach ($ciphertext as $i => $val) {
    $result[$i] = ($val + 256 - $key_caesar) % 256;
  }
  return pack('C*', ...$result);
}

function enkripsi_aes($plaintext)
{
  global $iv, $key_str;
  $mkey = hash('sha256', $key_str, true);
  $iv = openssl_random_pseudo_bytes(16);

  $ciphertext = openssl_encrypt($plaintext, "AES-256-CBC", $mkey, OPENSSL_RAW_DATA, $iv);

  return $ciphertext;
}

function dekripsi_aes($ciphertext)
{
  global $iv, $key_str;
  $mkey = hash('sha256', $key_str, true);

  $plaintext = openssl_decrypt($ciphertext, "AES-256-CBC", $mkey, OPENSSL_RAW_DATA, $iv);

  return $plaintext;
}

function enkripsi(string $plaintext)
{
  $plaintext = enkripsi_vigenere($plaintext);
  $plaintext = enkripsi_caesar($plaintext);
  $plaintext = enkripsi_aes($plaintext);
  return $plaintext;
}

function dekripsi(string $ciphertext)
{
  $ciphertext = dekripsi_aes($ciphertext);
  $ciphertext = dekripsi_caesar($ciphertext);
  $ciphertext = dekripsi_vigenere($ciphertext);
  return $ciphertext;
}
