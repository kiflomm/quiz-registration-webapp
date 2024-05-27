<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Register here</h2>
        <form action="server/registerUser.php" method="POST" onsubmit="return validateAll(event)">
            <!-- First Name -->
            <div class="mb-4">
                <label for="firstName" class="block text-gray-700">First Name</label>
                <input type="text" id="firstName" name="firstName" class="form-input mt-1 block w-full" required>
            </div>
            <!-- Last Name -->
            <div class="mb-4">
                <label for="lastName" class="block text-gray-700">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="form-input mt-1 block w-full" required>
            </div>
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" class="form-input mt-1 block w-full" required>
            </div>
            <!-- User Name -->
            <div class="mb-4">
                <label for="username" class="block text-gray-700">User Name</label>
                <input type="text" id="username" name="username" class="form-input mt-1 block w-full" required>
                <p id="usernamefeedback" class="text-red-500 text-sm mt-1"></p>
            </div>
            <!-- New Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="form-input mt-1 block w-full" required>
            </div>
            <!-- confirm Password -->
            <div class="mb-4">
                <label for="confirmpassword" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" class="form-input mt-1 block w-full"
                    required>
            </div>
            <!-- Account Type -->
            <div class="mb-4">
                <label for="accountType" class="block text-gray-700">Account Type</label>
                <select id="accountType" name="accountType" class="form-select mt-1 block w-full" required>
                    <option value="" disabled selected>Select Account Type</option>
                    <option value="candidate">Candidate</option>
                    <option value="examiner">Examiner</option>
                </select>
            </div>
            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</button>
            </div>
        </form>
        <div class="flex justify-around"><p class="text-center font-bold">already have an account?</p><a href="login.php" class="text-sm text-gray-600 hover:text-blue-500">log in here</a></div>
        
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