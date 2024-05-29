<?php
session_start(); 
$test_id = $_GET['test_id'];

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

// Fetch the test details
$sql = "SELECT * FROM tests WHERE test_id = '$test_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$_SESSION['test_title'] = $row['test_title'];
$_SESSION['test_id_'] = $row['test_id'];

// Fetch questions for the test
$questions_sql = "SELECT * FROM questions WHERE test_id = '$test_id'";
$questions_result = $conn->query($questions_sql);

// Handle delete question
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_question'])) {
    $question_id = $conn->real_escape_string($_POST['question_id']);
    $delete_sql = "DELETE FROM questions WHERE question_id = '$question_id'";

    if ($conn->query($delete_sql) === TRUE) {
        $success = "Question deleted successfully!";
        // Refresh the page to reflect changes
        header("Refresh:0");
    } else {
        $error = "Error deleting question: " . $conn->error;
   
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
    <title>Manage Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="w-full bg-white p-8 rounded-lg shadow-md h-full">
        <div class="flex justify-between">
        <button type="button" name="add_question" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded outline-none"
            onclick="location.href='manageTests.php'"
        >
            Go back to Manage Tests
        </button> 
        <button type="button" name="add_question" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded outline-none"
            onclick="location.href='add_question.php?test_id=<?php echo $test_id ?>'"
        >
            Add new question
        </button>
        </div>
        <h1 class="text-2xl text-center font-semibold mb-4 text-blue-500">Manage Questions for: <?php echo "<span class='text-red-500'>". htmlspecialchars($row['test_title'])."</span>"; ?></h1>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Question Text</th>
                    <th class="py-2 px-4 border-b">Option 1</th>
                    <th class="py-2 px-4 border-b">Option 2</th>
                    <th class="py-2 px-4 border-b">Option 3</th>
                    <th class="py-2 px-4 border-b">Option 4</th>
                    <th class="py-2 px-4 border-b">Correct Answer</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($question_row = $questions_result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($question_row['question_text']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($question_row['option_1']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($question_row['option_2']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($question_row['option_3']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($question_row['option_4']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($question_row['correct_answer']); ?></td>
                        <td class="py-2 px-4 border-b">
                        <a href="edit_question.php?question_id=<?php echo $question_row['question_id']; ?>" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded mr-2">Edit</a>
                            <form action="" method="POST" class="inline-block">
                                <input type="hidden" name="question_id" value="<?php echo $question_row['question_id']; ?>">
                                <button type="submit" name="delete_question" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
