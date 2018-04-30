<?php

// Includes functions file
require 'functions.php';

// Sets DB configuration
$DB_HOST = '';
$DB_USER = '';
$DB_PASS = '';
$DB_NAME = '';

// Initiates DB
$DB = db_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
