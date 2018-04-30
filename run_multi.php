<?php

if (!$argv[1] || !$argv[2])
  die("Need two date parameters\n.");

$begin = new DateTime($argv[1]);
$end = new DateTime($argv[2]);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ($period as $dt) {
  echo "\n{$dt->format("l Y-m-d")}:\n";
  $date = $dt->format('ymd');
  $file = "tt{$date}.xml";
  $url = "https://bulkdata.uspto.gov/data/trademark/dailyxml/ttab/tt{$date}.zip";

  // Start the script that grabs the zip and extracts it
  echo shell_exec("php fetch_xml.php {$url} {$file}");
  // Start the script that parses the extracted file
  echo shell_exec("php parse_xml.php {$file}");

  // Delete parsed xml file
  unlink($file);

  echo "\nDone\n";
}
