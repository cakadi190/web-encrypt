<?php

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=Encrypt.txt");

echo file_get_contents('tmp/Encrypt.txt');
