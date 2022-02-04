<?php
// db_connect.inc.php
// PDO Code Start
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ctec';

// DSN - Data Source Name
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

// Create a PDO Instance
$db = new PDO($dsn, $user, $password);
// Set PDO default data type to be returned
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
