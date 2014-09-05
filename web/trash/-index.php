<?php
header('Content-Type: text/html; charset=utf-8');

require __DIR__."/../vendor/autoload.php";


//index.php

// Uses
use Admin\Curl;

// Start stopwatch
$start = time();

// Load configuration
//$config = json_decode(file_get_contents(__DIR__.'/config.json'));

$cc = new cURL(false);

echo "ok";

