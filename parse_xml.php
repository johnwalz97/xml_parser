<?php
// Set db configuration
$DB_HOST = '';
$DB_USER = '';
$DB_PASS = '';
$DB_NAME = '';
// Set location of xml file
$XML_FILE = '';

// Include functions file
require_once 'functions.php';

$conn = db_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$xml = parse_xml_file($XML_FILE);

// loop through xml and parse/store entries
foreach ($xml->{'proceeding-information'}->{'proceeding-entry'} as $entry) {
  db_insert($conn, 'proceeding-entry', [
    'number' => parse_int($entry->number),
    'type-code' => $entry->{'type-code'},
    'filing-date' => parse_int($entry->{'filing-date'}),
    'location-code' => parse_int($entry->{'location-code'}),
    'day-in-location' => parse_int($entry->{'day-in-location'}),
    'status-update-date' => parse_int($entry->{'status-update-date'}),
    'status-code' => parse_int($entry->{'status-code'}),
  ]);

  $party = $entry->{'party-information'}->party;
  db_insert($conn, 'proceeding-party', [
    'proceeding-id' => $conn->insert_id,
    'identifier' => parse_int($party->identifier),
    'role-code' => $party->{'role-code'},
    'name' => parse_text($party->name),
  ]);
  $party_id = $conn->insert_id;

  $address = $party->{'address-information'}->{'proceeding-address'};
  if ($address)
    db_insert($conn, 'proceeding-party-address', [
      'identifier' => parse_int($address->identifier),
      'name' => parse_text($address->name),
      'orgname' => parse_text($address->orgname),
      'address-1' => $address->{'address-1'},
      'address-2' => $address->{'address-2'},
      'city' => $address->city,
      'state' => $address->state,
      'country' => $address->country,
      'postcode' => $address->postcode,
      'proceeding-party-id' => $party_id,
    ]);

  $prop = $party->{'property-information'}->property;
  if ($prop)
    db_insert($conn, 'proceeding-party-property', [
      'identifier' => parse_int($prop->identifier),
      'serial-number' => parse_int($prop->{'serial-number'}),
      'mark-text' => parse_text($prop->{'mark-text'}),
      'proceeding-party-id' => $party_id,
    ]);

  foreach ($entry->{'prosecution-history'}->{'prosecution-entry'} as $pros) {
    db_insert($conn, 'prosecution-entries', [
      'identifier' => parse_int($pros->identifier),
      'code' => parse_int($pros->code),
      'type-code' => $pros->{'type-code'},
      'date' => parse_int($pros->date),
      'history-text' => parse_text($pros->{'history-text'}),
    ]);
  }
}
