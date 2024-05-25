<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const accountType = 'candidate'; 
        document.addEventListener('DOMContentLoaded', () => {
            const examinerDashboard = document.getElementById('examinerDashboard');
            const candidateDashboard = document.getElementById('candidateDashboard');
            if (accountType === 'examiner') {
                examinerDashboard.classList.remove('hidden');
            } else if (accountType === 'candidate') {
                candidateDashboard.classList.remove('hidden');
            }
        });
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
            <!-- Examiner Dashboard -->
            <div id="examinerDashboard" class="hidden">
                <h2 class="text-xl font-semibold mb-4">Examiner Dashboard</h2>
                <ul>
                    <li class="mb-2">
                        <a href="dashboard/manageTests.php" class="text-blue-500 hover:underline">Manage Tests</a>
                    </li>
                    <li class="mb-2">
                        <a href="dashboard/addTests.php" class="text-blue-500 hover:underline">Add New Test</a>
                    </li>
                    <li class="mb-2">
                        <a href="dashboard/setProfile.php" class="text-blue-500 hover:underline">Profile Settings</a>
                    </li>
                </ul>
            </div>
            <!-- Candidate Dashboard -->
            <div id="candidateDashboard" class="hidden">
                <h2 class="text-xl font-semibold mb-4">Candidate Dashboard</h2>
                <ul>
                    <li class="mb-2">
                        <a href="dashboard/takeTest.php" class="text-blue-500 hover:underline">Take New Test</a>
                    </li>
                    <li class="mb-2">
                        <a href="dashboard/testRecord.php" class="text-blue-500 hover:underline">View Records</a>
                    </li>
                    <li class="mb-2">
                        <a href="dashboard/setProfile.php" class="text-blue-500 hover:underline">Profile Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>