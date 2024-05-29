<?php

// Database connection details
$host = 'localhost';
$db = 'quiz_app_details';
$user = 'root';
$pass = '';

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_question'])) {
    if (isset($_GET['test_id'])) {
        $test_id = $_GET['test_id'];
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
            header("Location:manage_questions.php?test_id=$test_id");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "Please add a test first.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add question</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body> 
<div class="flex justify-center h-screen">  
    <button type="submit" name="add_question" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded outline-none"
        onclick="location.href='manage_questions.php?test_id=<?php echo $_GET['test_id'];?>'"
    >Cancel Adding</button> 
    <form action="" method="POST" class="w-full bg-white rounded shadow-md px-8 py-5">
    <div class="flex flex-col">
      <label for="question_text" class="text-gray-700 text-lg font-semibold mb-2">Question Text</label>
      <textarea id="question_text" name="question_text" class="rounded-md border border-gray-300 px-3 py-2 h-24 focus:outline-none focus:ring-1 focus:ring-blue-500" required></textarea>
    </div>
    <div class="flex flex-col">
      <label for="option_1" class="text-gray-700 text-base mb-2">Option 1</label>
      <input type="text" id="option_1" name="option_1" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
    </div>
    <div class="flex flex-col">
      <label for="option_2" class="text-gray-700 text-base mb-2">Option 2</label>
      <input type="text" id="option_2" name="option_2" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
    </div>
    <div class="flex flex-col">
      <label for="option_3" class="text-gray-700 text-base mb-2">Option 3</label>
      <input type="text" id="option_3" name="option_3" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
    </div>
    <div class="flex flex-col">
      <label for="option_4" class="text-gray-700 text-base mb-2">Option 4</label>
      <input type="text" id="option_4" name="option_4" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
    </div>
    <div class="flex flex-col">
      <label for="correct_answer" class="text-gray-700 text-base mb-2">Correct Option [1 - 4]</label>
      <input type="number" id="correct_answer" name="correct_answer" max='4' min='1' class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
    </div>
    <div class="flex justify-end mt-4">  
        <button type="submit" name="add_question" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded outline-none">Add Question</button>
    </div>
  </form>
</div>