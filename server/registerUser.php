<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database  = "quiz_app_details";
    $conn = new mysqli($host,$username,$password,$database);
   // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Escape user input to prevent SQL Injection
$username = mysqli_real_escape_string($conn, $_POST["username"]);
$firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
$lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn,$_POST["password"]); // Hash password for security
$accountType = mysqli_real_escape_string($conn, $_POST["accountType"] );

// Get current timestamp
$registrationTimestamp = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS

// SQL insert query
$sql = "INSERT INTO all_users (user_name, first_name, last_name, email, password, account_type, registration_time)
VALUES ('$username', '$firstName', '$lastName', '$email', '$password', '$accountType', '$registrationTimestamp')";

if ($conn->query($sql) === TRUE) {
  echo "<p>You are successfully registerd </p>";
  echo "<p> Do you want to <a href='../login.php'>log in</a> or go <a href='../'>home </a></p>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>