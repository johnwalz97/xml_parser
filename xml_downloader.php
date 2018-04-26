<?php

echo "hello world!<br />";

//global variables
$webroot = "/var/www";
//figure out for end of month (day = 1), end of year (month =1 and day = 1)

//get the date and format it properly for USPTO file naming conventions
$today = getdate();
$year = substr($today["year"], 2, 2);
$day = $today["mday"] - 1;
$month = $today["mon"];

$day = str_pad($day, 2, '0', STR_PAD_LEFT);
$month = str_pad($month, 2, '0', STR_PAD_LEFT);

$name = "tt" . $year . $month . $day. ".zip";


//create the URL and the filename for grabbing the file
$url = "https://bulkdata.uspto.gov/data/trademark/dailyxml/ttab/".$name;
$filename = $webroot."/docs/".$name;

echo $url."<br />";
echo $filename."<br />";

// grab the file
// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
$out = curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);


//write the file to the local server
$fp = fopen($filename, 'w');
fwrite($fp, $out);
fclose($fp);

$zip = new ZipArchive;
if ($zip->open($filename) === TRUE) {
    $zip->extractTo($webroot.'/docs');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}

unlink ($filename);

echo "did it!";
