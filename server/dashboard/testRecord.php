<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: ../../login.php");
    exit();
}

$user_name = $_SESSION['user_name'];

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

// Handle reset test history
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_history'])) {
    $delete_sql = "DELETE FROM tests_taken WHERE user_name = '$user_name'";
    if ($conn->query($delete_sql) === TRUE) {
        $success = "Test history reset successfully!";
    } else {
        $error = "Error resetting test history: " . $conn->error;
    }
}

// Fetch the test history for the logged-in user
$sql = "SELECT tt.test_id, t.test_title, tt.correct_score, tt.incorrect_score, tt.exam_time 
        FROM tests_taken tt
        JOIN tests t ON tt.test_id = t.test_id
        WHERE tt.user_name = '$user_name'
        ORDER BY tt.exam_time DESC";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test History</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100  h-screen">
        <h1 class="text-2xl text-center font-semibold mb-4">Test History</h1>
    <div class="flex justify-center items-start w-full bg-white p-8 rounded-lg shadow-md">
        <button type="button" name="add_question" class="h-screen bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded outline-none"
            onclick="location.href='../dashboard.php'">
            Back to Dashboard
        </button>
        <table class="w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Test Title</th>
                    <th class="py-2 px-4 border-b">Correct Score</th>
                    <th class="py-2 px-4 border-b">Incorrect Score</th>
                    <th class="py-2 px-4 border-b">Date Taken</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center py-2 px-4 border-b"><?php echo htmlspecialchars($row['test_title']); ?></td>
                            <td class="text-center py-2 px-4 border-b"><?php echo htmlspecialchars($row['correct_score']); ?></td>
                            <td class="text-center py-2 px-4 border-b"><?php echo htmlspecialchars($row['incorrect_score']); ?></td>
                            <td class="text-center py-2 px-4 border-b"><?php echo htmlspecialchars($row['exam_time']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="py-2 px-4 border-b text-center">No test history found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <form method="POST" action="">
            <button type="submit" name="reset_history" class="h-screen mb-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded outline-none">
                Reset Test History
            </button>
        </form> 
    </div>
</body>
</html>
