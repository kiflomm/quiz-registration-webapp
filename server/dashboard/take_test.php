<?php
session_start();

// Check if test_id is set and is a valid number
if (! isset($_GET['test_id']) || ! is_numeric($_GET['test_id'])) {
    header("Location: takeTest.php");
    exit();
}

$test_id = $_GET['test_id'];
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

// Fetch the test details
$sql = "SELECT * FROM tests WHERE test_id = '$test_id'";
$test_result = $conn->query($sql);

if ($test_result->num_rows == 0) { 
    header("Location: takeTest.php");
    exit();
}

$test_row = $test_result->fetch_assoc();
$test_duration = $test_row['test_duration'];
$test_author = $test_row['test_author'];
// Fetch questions for the test
$questions_sql = "SELECT * FROM questions WHERE test_id = '$test_id'";
$questions_result = $conn->query($questions_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_test'])) {
    $correct_score = 0;
    $incorrect_score = 0;

    while ($question_row = $questions_result->fetch_assoc()) {
        $question_id = $question_row['question_id'];
        $selected_answer = $_POST['question_' . $question_id];
        $correct_answer = $question_row['correct_answer'];
        if ($selected_answer == $correct_answer) {
            $correct_score++;
        } else {
            $incorrect_score++;
        }
    }

    // Store the test results in the tests_taken table
    $exam_time = date('Y-m-d H:i:s');
    $insert_sql = "INSERT INTO tests_taken (test_id, user_name, correct_score, incorrect_score, exam_time) 
                   VALUES ('$test_id', '$user_name', '$correct_score', '$incorrect_score', '$exam_time')";

    if ($conn->query($insert_sql) === TRUE) {
        $success = "Test submitted successfully! You scored $correct_score correct and $incorrect_score incorrect."; 
        header("Location:testRecord.php");
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
    <title>Take Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100  items-center h-screen">
        <div class="text-2xl text-center font-semibold mb-4">Test title : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars($test_row['test_title']); ?>
        <br/> Candidate :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['first_name']." ".$_SESSION['last_name']?>
        <br/>Examainer: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $test_author ?></div>
        <?php if (isset($success)): ?>
            <p class="text-green-500 text-sm mb-4"><?php echo htmlspecialchars($success); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="text-red-500 text-sm mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    <form id="test_form" action="" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
    <div class="w-full flex justify-between bg-white py-1 rounded-lg shadow-md">
        <button type="button" name="add_question" class="bg-blue-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded outline-none"
            onclick="location.href='takeTest.php'"
        >
           Quit Test
        </button>
        <div id="timer" class="text-red-500 font-bold text-xl"></div>
        <button type="submit" name="submit_test" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded outline-none"        >
        Submit Test
        </button>
        </div>
    <?php
    $questions_result->data_seek(0); // Reset pointer to the start
    $roll_num = 1;
    while ($question_row = $questions_result->fetch_assoc()): ?>
        <div class="mb-6">
            <p class="text-gray-700 text-lg font-semibold mb-3"><?php echo "<span class ='text-red-500'>".$roll_num . ".</span> ".htmlspecialchars($question_row['question_text']); ?></p>
            <div class="flex flex-col space-y-2">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="question_<?php echo $question_row['question_id']; ?>" value="1" class="form-radio h-4 w-4 text-blue-600" required>
                    <span><?php echo htmlspecialchars($question_row['option_1']); ?></span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="question_<?php echo $question_row['question_id']; ?>" value="2" class="form-radio h-4 w-4 text-blue-600" required>
                    <span><?php echo htmlspecialchars($question_row['option_2']); ?></span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="question_<?php echo $question_row['question_id']; ?>" value="3" class="form-radio h-4 w-4 text-blue-600" required>
                    <span><?php echo htmlspecialchars($question_row['option_3']); ?></span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="question_<?php echo $question_row['question_id']; ?>" value="4" class="form-radio h-4 w-4 text-blue-600" required>
                    <span><?php echo htmlspecialchars($question_row['option_4']); ?></span>
                </label>
            </div>
        </div>

    <?php $roll_num++;endwhile; ?>
</form>
    <script>
        // Timer logic
        let duration = <?php echo $test_duration * 60; ?>; // Convert minutes to seconds
        let timerDisplay = document.getElementById('timer');

        setInterval(() => {
            let minutes = Math.floor(duration / 60);
            let seconds = duration % 60;

            timerDisplay.textContent = `${minutes}m ${seconds}s`;

            if (duration > 0) {
                duration--;
            } else {
                document.getElementById('test_form').submit();
            }
        }, 1000);
    </script>
</body>
</html>
