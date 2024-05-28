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

// Check if test_id is provided in the URL
if (isset($_GET['test_id'])) {
    $test_id = $conn->real_escape_string($_GET['test_id']);

    // Fetch test details from the database
    $sql = "SELECT * FROM tests WHERE test_id = '$test_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $test = $result->fetch_assoc();
    } else {
        $error = "Test not found.";
    }
} else {
    $error = "Test ID not provided.";
}

// Handle test update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_test'])) {
    $test_title = $conn->real_escape_string($_POST['test_title']);
    $test_desc = $conn->real_escape_string($_POST['test_desc']);
    $test_duration = $conn->real_escape_string($_POST['test_duration']);
    $test_catagory = $conn->real_escape_string($_POST['test_catagory']);

    // Update test in the database
    $update_sql = "UPDATE tests SET test_title = '$test_title', test_desc = '$test_desc', test_duration = '$test_duration', test_catagory = '$test_catagory' WHERE test_id = '$test_id'";

    if ($conn->query($update_sql) === TRUE) {
        $success = "Test updated successfully!";
        // Redirect to manage_tests.php after updating
        header("Location: manageTests.php");
        exit();
    } else {
        $error = "Error updating test: " . $conn->error;
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
    <title>Edit Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Edit Test</h1>
        <?php if (isset($error)): ?>
            <p class="text-red-500 text-sm mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="" method="POST" class="space-y-4">
            <div class="flex flex-col">
                <label for="test_title" class="text-gray-700 mb-2">Test Title</label>
                <input type="text" id="test_title" name="test_title" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($test['test_title']); ?>" required>
            </div>
            <div class="flex flex-col">
                <label for="test_desc" class="text-gray-700 mb-2">Test Description</label>
                <textarea id="test_desc" name="test_desc" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required><?php echo htmlspecialchars($test['test_desc']); ?></textarea>
            </div>
            <div class="flex flex-col">
                <label for="test_duration" class="text-gray-700 mb-2">Test Duration (minutes)</label>
                <input type="number" id="test_duration" name="test_duration" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($test['test_duration']); ?>" required>
            </div>
            <div class="flex flex-col">
                <label for="test_catagory" class="text-gray-700 mb-2">Test Category</label>
                <input type="text" id="test_catagory" name="test_catagory" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($test['test_catagory']); ?>" required>
            </div>
            <button type="submit" name="update_test" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700">Update Test</button>
        </form>
    </div>
</body>
</html>
