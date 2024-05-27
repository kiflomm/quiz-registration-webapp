<?php
function checkUsernameInDatabase($username) {
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "quiz_app_details";

// Create connection
$conn = new mysqli($servername, $user, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Escape user input to prevent SQL Injection
  $escapedUsername = mysqli_real_escape_string($conn,$username);

  // SQL query to check username existence 
  $sql = "SELECT COUNT(*) AS username_count FROM all_users WHERE user_name = '$escapedUsername'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $usernameCount = $row["username_count"]; 
    return $usernameCount > 0; // True if username exists, False otherwise
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    
    return false; // Handle potential errors
  }

  $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $username = $_GET['username'];

  $usernameExists = checkUsernameInDatabase($username);

  echo json_encode(array('exists' => $usernameExists));
}

?>
