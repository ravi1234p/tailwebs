<?php
session_start();
require_once 'db_connect.php'; // Include your DB connection file

// Check if the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic server-side validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid email format
        $_SESSION['error'] = "Invalid email format";
        header('Location: login.php'); // Redirect to the login page with error
        exit;
    }

    if (empty($password)) {
        // Empty password
        $_SESSION['error'] = "Password cannot be empty";
        header('Location: login.php'); // Redirect to the login page with error
        exit;
    }

    // Check if the user exists in the database
    $query = "SELECT * FROM teachers WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $teacher = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $teacher['password'])) {
            // Success: Store user data in session and redirect
            $_SESSION['teacher_id'] = $teacher['id'];
            $_SESSION['teacher_name'] = $teacher['name'];
            header('Location: ./admin/admin.php'); // Redirect to the dashboard
            exit;
        } else {
            // Incorrect password
            $_SESSION['error'] = "Invalid password";
            header('Location: login.php'); // Redirect with error
            exit;
        }
    } else {
        // No user found with that email
        $_SESSION['error'] = "No account found with that email";
        header('Location: login.php'); // Redirect with error
        exit;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
