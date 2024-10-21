<?php
// register.php - Register new teacher with hashed password

require_once 'db_connect.php'; // Include your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); // User-entered password

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert teacher into the database
    $query = "INSERT INTO teachers (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    if ($stmt->execute()) {
        echo "Teacher registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
</head>
<body>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>
