<?php
session_start();

// Database connection details
$host = 'localhost';
$db = 'quiz_app_details';
$user = 'root';
$pass = '';

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check if the connection was successful
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Retrieve username and password from POST request
$username = trim($_POST['username']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM all_users WHERE user_name = '$username'";
$result  = $conn->query($sql);
// Check if the user exists
if ($result->num_rows > 0) { 
    $row = $result->fetch_assoc();
    // Verify the password
    $checkpass = $row['password']; 
    if (($password == $checkpass)) {
        // Password is correct, start the session
        $_SESSION['username'] = $username;
        $_SESSION['account_type'] = $row['account_type'];
        header('Location: dashboard.php'); 
        exit();
    } else {
        // Password is incorrect 
        $error = 'The user name and password you entered doesnt match';
    }
} else {
    // Username does not exist
    $error = 'This user name is not found ';
}

// Close the database connection
$conn->close();

// Redirect back to the login page with an error message
header('Location: ../login.php?error=' . urlencode($error)."&password=".($checkpass));
exit();
?>