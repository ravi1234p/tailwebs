<?php
include('dbconn.php');
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $username = $_POST['usrnm'];
    $email = $_POST['email'];
    $password = $_POST['psw'];

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'All fields are required!';
        header('Location: login.php');
        exit();
    }

    // Hash the password before saving it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the teacher table
    $sql = "INSERT INTO teachers (name,username, email, password) VALUES (?,?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name,$username, $email, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Registration successful! Please login.';
        header('Location: login.php'); // Redirect to login page
        exit();
    } else {
        $_SESSION['error'] = 'Error: ' . $conn->error;
        header('Location: login.php');
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
