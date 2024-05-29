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

// Handle test form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_test'])) {
    $test_title = $conn->real_escape_string($_POST['test_title']);
    $test_desc = $conn->real_escape_string($_POST['test_desc']);
    $test_duration = $conn->real_escape_string($_POST['test_duration']);
    $test_catagory = $conn->real_escape_string($_POST['test_catagory']);
    $test_author = $conn->real_escape_string($_SESSION['first_name']);

    // Insert test into the database
    $sql = "INSERT INTO tests (test_title, test_desc, test_duration, test_catagory, test_author) 
            VALUES ('$test_title', '$test_desc', '$test_duration', '$test_catagory', '$test_author')";

    if ($conn->query($sql) === TRUE) {
        $test_id = $conn->insert_id;
        header("Location:manage_questions.php?test_id=$test_id");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Handle question form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_question'])) {
    if (isset($_SESSION['test_id'])) {
        $test_id = $_SESSION['test_id'];
        $question_text = $conn->real_escape_string($_POST['question_text']);
        $option_1 = $conn->real_escape_string($_POST['option_1']);
        $option_2 = $conn->real_escape_string($_POST['option_2']);
        $option_3 = $conn->real_escape_string($_POST['option_3']);
        $option_4 = $conn->real_escape_string($_POST['option_4']);
        $correct_answer = $conn->real_escape_string($_POST['correct_answer']);

        // Insert question into the database
        $sql = "INSERT INTO questions (test_id, question_text, option_1, option_2, option_3, option_4, correct_answer) 
                VALUES ('$test_id', '$question_text', '$option_1', '$option_2', '$option_3', '$option_4', '$correct_answer')";

        if ($conn->query($sql) === TRUE) {
            $success = "Question added successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "Please add a test first.";
    }
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Test and Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">
    <div class="h-screen">
        <button type="button" name="add_question" class="h-screen bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded outline-none" onclick="location.href='../dashboard.php'">
            Go back to dashboard
        </button> 
    </div>
    <div class="w-full bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Add New Test</h1>
            <form action="" method="POST" class="space-y-4">
                <div class="flex flex-col">
                    <label for="test_title" class="text-gray-700 mb-2">Test Title</label>
                    <input type="text" id="test_title" name="test_title" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>
                <div class="flex flex-col">
                    <label for="test_desc" class="text-gray-700 mb-2">Test Description</label>
                    <textarea id="test_desc" name="test_desc" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required></textarea>
                </div>
                <div class="flex flex-col">
                    <label for="test_duration" class="text-gray-700 mb-2">Test Duration (minutes)</label>
                    <input type="number" id="test_duration" name="test_duration" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>
                <div class="flex flex-col">
                    <label for="test_catagory" class="text-gray-700 mb-2">Test Category</label>
                    <input type="text" id="test_catagory" name="test_catagory" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>
                <button type="submit" name="add_test" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700">Submit Test Info</button>
            </form>
    </div>
</body>
</html>
