<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database  = "quiz_app_details";
    $conn = new mysqli($host,$username,$password,$database);
   // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST["username"])){
// Escape user input to prevent SQL Injection
$username = mysqli_real_escape_string($conn, $_POST["username"]);
$firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
$lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn,$_POST["password"]); // Hash password for security
$accountType = mysqli_real_escape_string($conn, $_POST["accountType"] );

// Get current timestamp
$registrationTimestamp = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS

// SQL insert query
$sql = "INSERT INTO all_users (user_name, first_name, last_name, email, password, account_type, registration_time)
VALUES ('$username', '$firstName', '$lastName', '$email', '$password', '$accountType', '$registrationTimestamp')";

if ($conn->query($sql) === TRUE) {
  $success = "Congratulations You have created your $accountType account successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-around">
    <div class="w-3/4 bg-white px-8 rounded-lg shadow-md ">
        <h2 class="text-2xl font-semibold mb-4 text-center text-blue-600">Create Your Account Here</h2> 
        <i class="text-green-500 text-center"><?php if(isset($success)) echo $success; ?></i>
        <form action="" method="POST" onsubmit="return validateAll(event)">
            <!-- First Name -->
            <div class="mb-1">
                <label for="firstName" class="block text-gray-700">First Name</label>
                <input type="text" id="firstName" name="firstName" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <!-- Last Name -->
            <div class="mb-1">
                <label for="lastName" class="block text-gray-700">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <!-- Email -->
            <div class="mb-1">
                <label for="email" class="block text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <!-- User Name -->
            <div class="mb-1">
                <label for="username" class="block text-gray-700">User Name</label>
                <input type="text" id="username" name="username" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                <p id="usernamefeedback" class="text-red-500 text-sm mt-1"></p>
            </div>
            <!-- New Password -->
            <div class="mb-1">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <!-- confirm Password -->
            <div class="mb-1">
                <label for="confirmpassword" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2"
                    required>
            </div>
            <!-- Account Type -->
            <div class="mb-1">
                <label for="accountType" class="block text-gray-700">Account Type</label>
                <select id="accountType" name="accountType" class="form-select mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    <option value="" disabled selected>Select Account Type</option>
                    <option value="candidate">Candidate</option>
                    <option value="examiner">Examiner</option>
                </select>
            </div>
            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Register</button>
            </div>
        </form>
    </div>
    <div class="flex flex-col justify-center mt-4"><p class="text-center font-bold">Already have an account?</p>
        <button onclick="location.href='login.php'" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Log in here</button>
    </div>
    <script>
        const validateAll = async (event) => {
            event.preventDefault(); // Prevent form submission
            const username = document.getElementById('username').value;
            let passwordCheck = validatePassword();
            let usernameCheck = await checkUsername(username);
            if (passwordCheck && usernameCheck) {
                event.target.submit(); // Submit the form if all validations pass
            } else {
                if (!usernameCheck) {
                    document.getElementById('usernamefeedback').textContent = 'Username already exists';
                }
            }
        }
        const validatePassword = () => {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmpassword').value;
            if (password !== confirmPassword) {
                alert("Passwords don't match!");
                return false;
            }
            return true;
        }
        const checkUsername = async (username) => {
            try {
                const response = await fetch('server/checkUsername.php?username=' + username);
                const data = await response.json();
                return !data.exists; // Return opposite of "exists" for availability
            } catch (error) {
                console.error('Error:', error);
                return false; // Handle potential errors (consider user notification)
            }
        };
    </script>
</body>
</html>
