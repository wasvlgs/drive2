<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-purple-600">
        <div class="bg-white shadow-lg rounded-lg w-full max-w-4xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Form Section -->
                <div class="p-8">
                    <div class="text-center mb-6">
                        <h2 id="form-title" class="text-3xl font-bold text-gray-800">Login</h2>
                        <p id="form-description" class="text-gray-600">Access your account</p>
                    </div>
                    <form id="auth-form" method="post">
                        <input name="type" id="type" type="text" hidden value="in">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input name="email" type="text" id="email" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your email">
                        </div>
                        <div id="name-field" class="mb-4 hidden">
                            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                            <input name="username" type="text" id="name" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your name">
                        </div>
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                            <input name="pass" type="password" id="password" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your password">
                        </div>
                        <button name="submit" type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            <span id="form-action">Login</span>
                        </button>
                    </form>
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            <span id="toggle-text">Don't have an account?</span>
                            <button id="toggle-form" class="text-blue-600 hover:underline font-medium">Sign Up</button>
                        </p>
                    </div>
                </div>
                <!-- Image Section -->
                <div class="md:block bg-cover bg-center" style="background-image: url('../img/1_24\ LEADING\ IDEAL\ ONE\ SUV\ Alloy\ New\ Energy\ Car\ Model\ Diecast\ Metal\ Toy\ Vehicles\ Car\ Model\ High.jpg');"></div>
            </div>
        </div>
    </div>

    <?php

        require_once '../database.php';
        require_once '../commands/client.php';

        $data = (new database())->getConnect();

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST['submit']) && $_POST['type'] === "in"){
                $getEmail = trim(htmlspecialchars($_POST['email']));
                $getPassword = trim(htmlspecialchars($_POST['pass']));
                if($getEmail && $getPassword && $getEmail != "" && $getPassword != ""){
                    $conn = new client($data);
                    $conn->login($getEmail,$getPassword);
                }else{
                    echo '<script>
                        document.getElementById("email").style.border = "2px solid red";
                        document.getElementById("password").style.border = "2px solid red";
                    </script>';
                }
                
            }else if(isset($_POST['submit']) && $_POST['type'] === "up"){
                $getEmail = trim(htmlspecialchars($_POST['email']));
                $getName = trim(htmlspecialchars($_POST['username']));
                $getPassword = trim(htmlspecialchars($_POST['pass']));
                if($getEmail && $getName && $getPassword && $getEmail != "" && $getName != "" && $getPassword != ""){
                    $getHashPassword = password_hash($getPassword, PASSWORD_DEFAULT);
                    $getConn = new client($data);
                    $getConn->signup($getEmail,$getName,$getHashPassword);
                }else{
                    echo '<script>
                        alert("Incorrect information");
                    </script>';
                }
            }
            else{
                echo '<script>alert("Error try again")</script>';
            }
        }

     ?>

    <script>
        const toggleButton = document.getElementById('toggle-form');
        const formTitle = document.getElementById('form-title');
        const formDescription = document.getElementById('form-description');
        const nameField = document.getElementById('name-field');
        const formAction = document.getElementById('form-action');
        const toggleText = document.getElementById('toggle-text');
        const setType = document.getElementById('type');

        toggleButton.addEventListener('click', () => {
            const isLogin = formTitle.textContent === 'Login';

            if (isLogin) {
                formTitle.textContent = 'Sign Up';
                formDescription.textContent = 'Create a new account';
                nameField.classList.remove('hidden');
                formAction.textContent = 'Sign Up';
                toggleText.textContent = 'Already have an account?';
                toggleButton.textContent = 'Login';
                setType.value = "up";
                document.getElementById("email").style.border = "1px solid #e5e7eb";
                document.getElementById("password").style.border = "1px solid #e5e7eb";
            } else {
                formTitle.textContent = 'Login';
                formDescription.textContent = 'Access your account';
                nameField.classList.add('hidden');
                formAction.textContent = 'Login';
                toggleText.textContent = "Don't have an account?";
                toggleButton.textContent = 'Sign Up';
                setType.value = "in";
                document.getElementById("email").style.border = "1px solid #e5e7eb";
                document.getElementById("password").style.border = "1px solid #e5e7eb";
            }
        });
    </script>
</body>
</html>
