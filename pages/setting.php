<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
        <?php
            require_once '../commands/header.php';
         ?>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- Account Settings Section -->
            <section id="account-settings" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Account Settings</h2>

                <!-- Change Password Form -->
                <form id="change-password-form" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-lg">
                    <!-- Current Password -->
                    <div>
                        <label for="current-password" class="block text-gray-700">Current Password</label>
                        <input type="password" id="current-password" name="currentPassword" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new-password" class="block text-gray-700">New Password</label>
                        <input type="password" id="new-password" name="newPassword" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="confirm-password" class="block text-gray-700">Confirm New Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Error Message for Password Mismatch -->
                    <div id="error-message" class="text-red-500 text-sm hidden mt-2">
                        <p>Passwords do not match. Please try again.</p>
                    </div>

                    <!-- Save Changes Button -->
                    <div class="mt-4">
                        <button name="saveChange" type="submit" id="save-changes" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Save Changes</button>
                    </div>
                </form>
            </section>
        </main>
    </div>


    <?php

        require_once '../commands/profileManage.php';
        $callFunctions = new manageProfile($conn->getConnect(),$getID);


        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST['saveChange'])){
                $getOldPass = htmlspecialchars(trim($_POST['currentPassword']));
                $getNewPass = htmlspecialchars(trim($_POST['newPassword'])); 
                if(!empty($getOldPass) && !empty($getNewPass)){
                    $getNew = password_hash($getNewPass, PASSWORD_DEFAULT);
                    $callFunctions->updatePassword($getOldPass, $getNew);
                }else{
                    echo '<script>alert("Invalid information!")</script>';
                }
            }
        }

    ?>

    <script>
        // Get form elements
        const form = document.getElementById('change-password-form');
        const newPassword = document.getElementById('new-password');
        const confirmPassword = document.getElementById('confirm-password');
        const errorMessage = document.getElementById('error-message');
        const saveButton = document.getElementById('save-changes');

        // Form submission event listener
        form.addEventListener('submit', function(event) {
            // Check if the passwords match
            if (newPassword.value !== confirmPassword.value) {
                // Prevent form submission if passwords don't match
                event.preventDefault();

                // Show error message
                errorMessage.classList.remove('hidden');
                errorMessage.classList.add('block');

                // Change button style to indicate error
                saveButton.classList.add('bg-red-600', 'hover:bg-red-700');
                saveButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            } else {
                // Hide error message and reset button style
                errorMessage.classList.add('hidden');
                saveButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                saveButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }
        });
    </script>
</body>
</html>
