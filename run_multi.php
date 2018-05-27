<?php

if (!$argv[1] || !$argv[2])
  die("Need two date parameters\n.");

require_once "config.php";

$begin = new DateTime($argv[1]);
$end = new DateTime($argv[2]);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ($period as $dt) {
  echo "\n{$dt->format("l Y-m-d")}:\n";
  $date = $dt->format('ymd');
  $file = "tt{$date}.xml";
  $url = "https://bulkdata.uspto.gov/data/trademark/dailyxml/ttab/tt{$date}.zip";
  download_xml($url, $file);
  save_xml($file);

  // Delete parsed xml file
  unlink($file);

  echo "\nDone\n";
}
