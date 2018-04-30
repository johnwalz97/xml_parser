<?php

// Sets DB configuration
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'pow54321';
$DB_NAME = 'pathology_watch_test';

// Includes functions file
require_once 'functions.php';

// Initiates DB
$DB = db_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
