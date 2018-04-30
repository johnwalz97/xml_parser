<?php

// Includes functions file
require 'functions.php';

// Sets DB configuration
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'pow54321';
$DB_NAME = 'pathology_watch_test';

// Initiates DB
$DB = db_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
