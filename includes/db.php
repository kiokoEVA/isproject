<?php
$host = "localhost";
$username = "root";
$password = ""; // <<<<< Change this line — leave empty if no password
$database = "police_abstract";

try {
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (mysqli_sql_exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>