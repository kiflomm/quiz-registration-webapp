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

// Fetch all available tests
$sql = "SELECT * FROM tests";
$tests_result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">
        <button type="button" name="add_question" class="h-screen bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded outline-none"
            onclick="location.href='../dashboard.php'">
            Back to Dashboard
        </button>
    <div class="w-full  bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Available Tests</h1>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Test Title</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Duration (minutes)</th>
                    <th class="py-2 px-4 border-b">Category</th>
                    <th class="py-2 px-4 border-b">Author</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($test_row = $tests_result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($test_row['test_title']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($test_row['test_desc']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($test_row['test_duration']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($test_row['test_catagory']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($test_row['test_author']); ?></td>
                        <td class="py-2 px-4 border-b bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded outline-none">
                            <button onclick='location.href="take_test.php?test_id=<?php echo $test_row['test_id']; ?>"'>Take Test</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
