<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold mb-4">Login</h1>
    <?php
if (isset($_GET['error'])) {
    echo '<p class="text-red-500 text-sm mb-4">' . htmlspecialchars($_GET['error']) . '</p>';
}
?>

    <form action="server/logincontrol.php" onsubmit="" class="space-y-4" method="post">
      <div class="flex flex-col">
        <label for="username" class="text-gray-700 mb-2">Username</label>
        <input type="text" id="username" name="username" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
      </div>
      <div class="flex flex-col">
        <label for="password" class="text-gray-700 mb-2">Password</label>
        <input type="password" id="password" name="password" class="rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
      </div>
      <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700">Login</button>
        <a href="#" class="text-sm text-gray-600 hover:text-blue-500">Forgot Password?</a>
      </div>
      
      <p class=" text-center font-bold"> Don't have an account? <a href="/" class="text-sm text-gray-600 hover:text-blue-500">sign up here</a></p>
    </form>
  </div>
</body>
</html>