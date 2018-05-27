<?php

require_once "config.php";

print_r($GLOBALS);

$db = new Database();

$date = $argv[1] ?: date('ymd', time() - 86400);
$url = "https://bulkdata.uspto.gov/data/trademark/dailyxml/ttab/tt{$date}.zip";
$file = "tt{$date}.xml";

download_xml($url, $file);
save_xml($db, $file);

unlink($file);
