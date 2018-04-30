<?php
// Contains a number of utility functions

function parse_xml_file($file) {
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

// Can be changed to support any db engine
function db_connect($host, $user, $pass, $name) {
  $conn = new mysqli($host, $user, $pass, $name);
  if ($conn->connect_error) {
      die("Connection failed: {$conn->connect_error}");
  }
  return $conn;
}


// Uses replace into so it will update if row already exists
function db_insert($conn, $table, $cols) {
  // echo "\n\tInserting record into {$table}...\n";
  $cols_list = '`' . implode('`,`', array_keys($cols)) . '`';
  $vals = '\'' . implode('\',\'', $cols) . '\'';
  $sql = "REPLACE INTO `{$table}` ({$cols_list}) VALUES ({$vals})";
  if ($conn->query($sql) !== true) {
    die("Error running sql:\n\n{$sql}\n\n{$conn->error}");
  }
  // echo "\tDone.\n";
}

function parse_int($str) {
  if ($str == '') {
    return 0;
  }
  return $str;
}
