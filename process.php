<?php

use Core\Classes\Encrypt;
use Core\Classes\Cipher;
use Core\Classes\Request;
use Core\Classes\Response;

include_once __DIR__ . "/core/autoload.php";

# Initialize variable
$request = new Request();
$cipher = new Cipher("alololo");
$encrypt = new Encrypt();
$response = new Response();

$body = $request->file('file');
var_dump($body);
