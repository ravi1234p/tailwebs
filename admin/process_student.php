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

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['studentName'];
    $subject = $_POST['studentSubject'];
    $marks = $_POST['studentMarks'];

    // Sanitize input to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $subject = $conn->real_escape_string($subject);
    $marks = (int)$conn->real_escape_string($marks);  // Ensure marks is an integer

    // Check if a student with the same name and subject already exists
    $checkQuery = "SELECT id FROM students WHERE name = ? AND subject = ?";
    $stmt = $conn->prepare($checkQuery);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $name, $subject);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Student exists, update the marks
        $updateQuery = "UPDATE students SET marks = ? WHERE name = ? AND subject = ?";
        $updateStmt = $conn->prepare($updateQuery);
        if ($updateStmt === false) {
            die("Error preparing update statement: " . $conn->error);
        }
        $updateStmt->bind_param("iss", $marks, $name, $subject);  // Update marks
        if ($updateStmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Marks updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating marks: ' . $updateStmt->error]);
        }
        $updateStmt->close();
    } else {
        // Student does not exist, insert new record
        $insertQuery = "INSERT INTO students (name, subject, marks) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        if ($insertStmt === false) {
            die("Error preparing insert statement: " . $conn->error);
        }
        $insertStmt->bind_param("ssi", $name, $subject, $marks);
        if ($insertStmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'New student added successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error adding new student: ' . $insertStmt->error]);
        }
        $insertStmt->close();
    }
    $stmt->close();
}

$conn->close();
?>
