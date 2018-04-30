<?php

// Get yymmdd format for url/filename
$date = date('ymd', time() - 86400);
$file = "tt{$date}.xml";
$url = "https://bulkdata.uspto.gov/data/trademark/dailyxml/ttab/tt{$date}.zip";

// Start the script that grabs the zip and extracts it
exec("php fetch_xml.php {$url} {$file}");
// Start the script that parses the extracted file
exec("php parse_xml.php {$file}");

// Delete parsed xml file
unlink($file);
