<?php

use frexin\converter\CsvSqlConverter;

require_once 'vendor/autoload.php';

$converter = new CsvSqlConverter('data/csv');
$result = $converter->convertFiles('data/sql');

var_dump($result);