<?php

if (!$argv[1] || !$argv[2])
  die("Missing arguments.\n");

// Download file from url passed as the first argument
$tmp_file = tmpfile();
$tmp_filename = stream_get_meta_data($tmp_file)['uri']
file_put_contents($tmp_filename, fopen($argv[1], 'r'));

// Unpack downloaded file and extract the file specified in the second argument
$zip = new ZipArchive;
if ($zip->open($tmp_filename) === TRUE) {
    $zip->extractTo('/tmp', $argv[2]);
    $zip->close();
} else {
    die("Failed to extract xml from zip!\n");
}
