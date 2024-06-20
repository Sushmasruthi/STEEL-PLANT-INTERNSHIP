<?php
// /backend/db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "steel_plant_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
