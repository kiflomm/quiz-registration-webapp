<?php
session_start();

$test_id = $_SESSION['test_id_']; 
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

// Fetch the question details
$question_id = $_GET['question_id'];
$question_sql = "SELECT * FROM questions WHERE question_id = '$question_id'";
$question_result = $conn->query($question_sql); 
$question_row = $question_result->fetch_assoc(); 

// Handle question update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_question'])) {
    $question_text = $conn->real_escape_string($_POST['question_text']);
    $option_1 = $conn->real_escape_string($_POST['option_1']);
    $option_2 = $conn->real_escape_string($_POST['option_2']);
    $option_3 = $conn->real_escape_string($_POST['option_3']);
    $option_4 = $conn->real_escape_string($_POST['option_4']);
    $correct_answer = $conn->real_escape_string($_POST['correct_answer']);

    $update_sql = "UPDATE questions SET question_text = '$question_text', 
                    option_1 = '$option_1', option_2 = '$option_2', 
                    option_3 = '$option_3', option_4 = '$option_4', 
                    correct_answer = '$correct_answer' 
                    WHERE question_id = '$question_id'";

    if ($conn->query($update_sql) === TRUE) {
        $success = "Question updated successfully!";
        header("Location: manage_questions.php?test_id=$test_id");
        exit();
    } else {
        $error = "Error updating question: " . $conn->error;
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
    <title>Edit Question</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100 flex justify-center items-center h-screen">
    
        <button type="button" name="add_question" class="h-screen bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700"
            onclick="location.href='manage_questions.php?test_id=<?php echo $test_id; ?>'">
            Cancel Editing
        </button> 
        <div class=" w-full bg-white p-8 rounded-lg shadow-md">
        <form action="" method="POST" class="space-y-4">
            <div class="flex flex-col">
                <label for="question_text" class="text-gray-700 mb-2">Question Text</label>
                <textarea id="question_text" name="question_text" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required><?php echo htmlspecialchars($question_row['question_text']); ?></textarea>
            </div>
            <div class="flex flex-col">
                <label for="option_1" class="text-gray-700 mb-2">Option 1</label>
                <input type="text" id="option_1" name="option_1" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($question_row['option_1']); ?>" required>
            </div>
            <div class="flex flex-col">
                <label for="option_2" class="text-gray-700 mb-2">Option 2</label>
                <input type="text" id="option_2" name="option_2" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($question_row['option_2']); ?>" required>
            </div>
            <div class="flex flex-col">
                <label for="option_3" class="text-gray-700 mb-2">Option 3</label>
                <input type="text" id="option_3" name="option_3" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($question_row['option_3']); ?>" required>
            </div>
            <div class="flex flex-col">
                <label for="option_4" class="text-gray-700 mb-2">Option 4</label>
                <input type="text" id="option_4" name="option_4" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($question_row['option_4']); ?>" required>
            </div>
            <div class="flex flex-col">
                <label for="correct_answer" class="text-gray-700 mb-2">Correct Option [1 - 4]</label>
                <input type="number" id="correct_answer" name="correct_answer" max='4' min='1' class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" value="<?php echo htmlspecialchars($question_row['correct_answer']); ?>" required>
            </div>
            <button type="submit" name="update_question" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700">Update Question</button>
        </form>
    </div>
</body>
</html>

