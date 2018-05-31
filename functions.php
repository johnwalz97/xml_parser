<?php

function parse_int($str) {
  if ($str == '') {
    return 0;
  }
  return $str;
}

function progress_bar($done, $total, $info="", $width=50) {
    $perc = round(($done * 100) / $total);
    $bar = round(($width * $perc) / 100);
    return sprintf(
      "%s%%[%s>%s]%s\r",
      $perc,
      str_repeat("=", $bar),
      str_repeat(" ", $width-$bar),
      $info
    );
}

function download_xml($url, $file) {
  $tmp_file = tmpfile();
  $tmp_filename = stream_get_meta_data($tmp_file)['uri'];
  file_put_contents($tmp_filename, fopen($url, 'r'));

  $zip = new ZipArchive;
  if ($zip->open($tmp_filename) === TRUE) {
      $zip->extractTo('.', $file);
      $zip->close();
  } else {
      die("Failed to extract xml from zip!\n");
  }
  return $file;
}

function parse_xml($file) {
  libxml_use_internal_errors(true);
  $xml = simplexml_load_file($file);
  if ($xml === false) {
      echo 'Failed loading XML: ';
      foreach(libxml_get_errors() as $error) {
          echo "\n {$error->message}";
      }
      die();
  }
  return $xml;
}

function save_xml($db, $file) {
  $xml = parse_xml($file);
  foreach ($xml->{'proceeding-information'}->{'proceeding-entry'} as $entry) {
    $db->insert_or_update('proceeding-entry', [
      'number' => parse_int($entry->number),
      'type-code' => $entry->{'type-code'},
      'filing-date' => parse_int($entry->{'filing-date'}),
      'location-code' => parse_int($entry->{'location-code'}),
      'day-in-location' => parse_int($entry->{'day-in-location'}),
      'status-update-date' => parse_int($entry->{'status-update-date'}),
      'status-code' => parse_int($entry->{'status-code'}),
    ], ['number' => parse_int($entry->number)]);
    $proceeding_id = $db->insert_id();

    $party = $entry->{'party-information'}->party;
    $db->insert_or_update('proceeding-party', [
      'proceeding-id' => $proceeding_id,
      'identifier' => parse_int($party->identifier),
      'role-code' => $party->{'role-code'},
      'name' => $db->escape($party->name),
    ], ['proceeding-id' => $db->insert_id()]);
    $party_id = $db->insert_id();

    $address = $party->{'address-information'}->{'proceeding-address'};
    if ($address)
      $db->insert_or_update('proceeding-party-address', [
        'identifier' => parse_int($address->identifier),
        'name' => $db->escape($address->name),
        'orgname' => $db->escape($address->orgname),
        'address-1' => $db->escape($address->{'address-1'}),
        'address-2' => $db->escape($address->{'address-2'}),
        'city' => $db->escape($address->city),
        'state' => $db->escape($address->state),
        'country' => $address->country,
        'postcode' => $address->postcode,
        'proceeding-party-id' => $party_id,
      ], ['identifier' => parse_int($address->identifier)]);

    $prop = $party->{'property-information'}->property;
    if ($prop)
      $db->insert_or_update('proceeding-party-property', [
        'identifier' => parse_int($prop->identifier),
        'serial-number' => parse_int($prop->{'serial-number'}),
        'mark-text' => $db->escape($prop->{'mark-text'}),
        'proceeding-party-id' => $party_id,
      ], ['identifier' => parse_int($prop->identifier)]);

    foreach ($entry->{'prosecution-history'}->{'prosecution-entry'} as $pros) {
      $db->insert_or_update('prosecution-entries', [
        'proceeding-id' => $proceeding_id,
        'identifier' => parse_int($pros->identifier),
        'code' => parse_int($pros->code),
        'type-code' => $pros->{'type-code'},
        'date' => parse_int($pros->date),
        'history-text' => $db->escape($pros->{'history-text'}),
      ], ['proceeding-id' => $proceeding_id, 'identifier' => parse_int($pros->identifier)]);
    }
  }
}
