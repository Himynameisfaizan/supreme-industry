<?php
if (session_status() === PHP_SESSION_NONE) {
    // session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Database Configuration
$local = true; 

if ($local) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'supreme_industry';
    $site = "http://localhost/office_php_project/supreme-industry/";
} else {
    $host = 'localhost';
    $username = 'u799879276_supreme_ind';
    $password = 'Supreme@ind1';
    $dbName = 'u799879276_supreme_ind';
    $site = 'rustic-goldenrod-elk-08.hostingersite.com';
}

// Make `$site` global
global $site;

// Create Database Connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: Set Character Encoding to UTF-8
$conn->set_charset("utf8");

?>