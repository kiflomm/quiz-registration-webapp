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

// Get the admin username from the session
$admin_username = $_SESSION['first_name'];

// Fetch the list of tests authored by the admin
$sql = "SELECT * FROM tests WHERE test_author = '$admin_username'";
$result = $conn->query($sql);

// Handle delete test
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_test'])) {
    $test_id = $conn->real_escape_string($_POST['test_id']);
    $delete_test_sql = "DELETE FROM tests WHERE test_id = '$test_id'";
    $delete_questions_sql = "DELETE FROM questions WHERE test_id = '$test_id'";

    if ($conn->query($delete_test_sql) === TRUE && $conn->query($delete_questions_sql) === TRUE) {
        $success = "Test and associated questions deleted successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "Error: " . $conn->error;
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
    <title>Manage Tests</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="w-full bg-white p-8 rounded-lg shadow-md">
        <div class="flex justify-between">
            <button type="button" name="add_question" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700"
                onclick="location.href='../dashboard.php'">
                Go back to dashboard
            </button> 
            <button type="button" name="add_question" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700"
                onclick="location.href='addTests.php'">
                Add new Test
            </button> 
        </button> 
        </div>
        <h1 class="text-2xl font-semibold mb-4">Manage Your Tests</h1>
        <?php if (isset($success)): ?>
            <p class="text-green-500 text-sm mb-4"><?php echo htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="text-red-500 text-sm mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Test Title</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Duration</th>
                    <th class="py-2 px-4 border-b">Category</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['test_title']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['test_desc']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['test_duration']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['test_catagory']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="edit_test.php?test_id=<?php echo $row['test_id']; ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded mr-2">Edit</a>
                            <a href="manage_questions.php?test_id=<?php echo $row['test_id']; ?>" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded mr-2">Manage Questions</a>
                            <form action="" method="POST" class="inline-block">
                                <input type="hidden" name="test_id" value="<?php echo $row['test_id']; ?>">
                                <button type="submit" name="delete_test" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
