<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tailwebs";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an ID is provided
if (isset($_POST['id'])) {
    $studentId = $_POST['id'];

    // Prepare the DELETE query
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the student ID and execute the query
    $stmt->bind_param("i", $studentId);
    if ($stmt->execute()) {
        echo 'success'; // Return success if deletion is successful
    } else {
        echo 'error'; // Return error if deletion fails
    }

    $stmt->close();
} else {
    echo 'error'; // If no ID is passed, return error
}

$conn->close();
?>
