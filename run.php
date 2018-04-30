<?php

// Get yymmdd format for url/filename
$date = "180120";
$file = "tt{$date}.xml";
$url = "https://bulkdata.uspto.gov/data/trademark/dailyxml/ttab/tt{$date}.zip";

// Start the script that grabs the zip and extracts it
echo shell_exec("php fetch_xml.php {$url} {$file}");
// Start the script that parses the extracted file
echo shell_exec("php parse_xml.php {$file}");

// Delete parsed xml file
unlink($file);

echo "\nDone\n";
