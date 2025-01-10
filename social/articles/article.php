<?php 
    session_start();
    $getID;

    if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
        $getID = $_SESSION['id'];
    }else{
        $getID = '';
    }

    require_once '../../database.php';
  
    $conn = new database();
    $db = $conn->getConnect();

    require_once '../../commands/displayArticles.php';
    $callFunctions = new article($conn->getConnect());

    if(isset($_GET['article']) && !empty(htmlspecialchars(trim($_GET['article'])))){
        $getArticle = $callFunctions->getArticleDetails(htmlspecialchars(trim($_GET['article'])));
        if($getArticle){
            $getImage = $getArticle['imgSrc'];
            $getTitre = $getArticle['title'];
            $getContent = $getArticle['content'];
            $getDate = $getArticle['date_create'];
        }else{
            die("No article exict");
        }
    }
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Simple modal styling */
        #comment-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <h1 class="text-3xl font-bold text-blue-600">Drive & Loc Blog</h1>
            <nav class="hidden md:flex space-x-6">
                <a href="../../index.php" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                <a href="../blog.php" class="text-gray-700 hover:text-blue-600 transition">Articles</a>
                <a href="../../index.php#features" class="text-gray-700 hover:text-blue-600 transition">Features</a>
                <a href="../../index.php#contact" class="text-gray-700 hover:text-blue-600 transition">Contact</a>
            </nav>
            <?php
                if(!empty($getID)){
                    echo '<a href="../pages/dashboard.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Dashboard</a>';
                }else{
                    echo '<a href="../login/login.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Login</a>';
                }
            ?>
        </div>
    </header>

    <!-- Article Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
                <!-- Article Image -->
                <img src="../../img/imgArticles/<?php if(isset($getImage)){echo $getImage;} ?>" alt="Article Image" class="w-full h-72 object-cover rounded-md mb-6">
                
                <!-- Article Metadata -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">H<?php if(isset($getTitre)){echo $getTitre;} ?></h1>
                    <p class="text-sm text-gray-600">Published on <?php if(isset($getDate)){echo $getDate;} ?></p>
                </div>
                
                <!-- Tags -->
                <!-- <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Tags:</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-sm">Travel</span>
                        <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-sm">Road Trip</span>
                        <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-sm">Adventure</span>
                    </div>
                </div> -->
                <?php

                 ?>

                <!-- Article Content -->
                <div class="text-gray-700 leading-relaxed mb-8">
                    <p class="mb-4"><?php if(isset($getContent)){echo $getContent;} ?></p>
                </div>

                <!-- Comment Section -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Comments</h3>
                    
                    <!-- Existing Comments -->
                    <div class="space-y-6" id="comments-section">
                        <div class="border-b pb-4 flex justify-between items-center">
                            <div>
                                <p class="text-gray-800"><span class="font-bold">Jane Smith</span> - Great tips for planning a road trip! I especially loved the part about mapping out key stops.</p>
                                <p class="text-sm text-gray-600">Posted on Jan 7, 2025</p>
                            </div>
                            <div class="flex space-x-4">
                                <button class="text-blue-600 hover:underline" onclick="openModal('Jane Smith', 'Great tips for planning a road trip! I especially loved the part about mapping out key stops.')">Modify</button>
                                <button class="text-red-600 hover:underline" onclick="removeComment(this)">Remove</button>
                            </div>
                        </div>
                    </div>

                    <!-- Add Comment -->
                    <?php
                if(!empty($getID)){
                    echo '<div class="mt-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Add a Comment:</h4>
                        <form>
                            <textarea class="w-full p-4 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none mb-4" placeholder="Write your comment here..." rows="4"></textarea>
                            <button type="button" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition">Submit</button>
                        </form>
                    </div>';
                }else{
                    echo '';
                }
            ?>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Comment Modification -->
    <div id="overlay"></div>
    <div id="comment-modal">
        <h3 class="text-xl font-bold mb-4">Modify Comment</h3>
        <form id="modify-comment-form">
            <textarea id="comment-text" class="w-full p-4 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none mb-4" rows="4"></textarea>
            <div class="flex justify-end space-x-4">
                <button type="button" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-400 transition" onclick="closeModal()">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition">Save</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Drive & Loc Blog. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        const overlay = document.getElementById('overlay');
        const modal = document.getElementById('comment-modal');
        const commentText = document.getElementById('comment-text');
        let currentCommentElement = null;

        function openModal(name, comment) {
            commentText.value = comment;
            modal.style.display = 'block';
            overlay.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
            overlay.style.display = 'none';
        }

        function removeComment(button) {
            const commentElement = button.closest('.border-b');
            commentElement.remove();
        }

        document.getElementById('modify-comment-form').addEventListener('submit', function (e) {
            e.preventDefault();
            if (currentCommentElement) {
                currentCommentElement.textContent = commentText.value;
            }
            closeModal();
        });
    </script>
</body>
</html>
