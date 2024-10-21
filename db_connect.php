<!-- db_connect.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "tailwebs"; // Use your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
