<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles - My Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php require_once '../commands/header.php';
    

    require_once '../commands/displayArticles.php';

    $callFunctions = new article($conn->getConnect());

    $getArticles = $callFunctions->displayMyArticles($getID);
    
    
    ?>

    <!-- Main Content Area -->
    <main class="flex-1 p-6">
        <!-- My Articles Section -->
        <section id="my-articles" class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">My Articles</h2>
            
            <!-- Article List -->
            <div class="space-y-4">


                <?php

                    if($getArticles->rowCount() > 0){
                        foreach($getArticles as $article){
                            $getDesc = substr($article['content'],0,100);
                            echo '<div class="bg-white p-4 rounded-lg shadow-md flex justify-between items-center">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-800">'.$article['title'].'</h3>
                        <p class="text-gray-600 text-sm mt-2">'.$getDesc.'...</p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="openModifyArticlePopup(`'.$article['title'].'`, `'.$article['content'].'`, '.$article['id_article'].')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Edit</button>
                        <button onclick="openDeleteArticlePopup('.$article['id_article'].')" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete</button>
                    </div>
                </div>';
                        
                    }}else{
                            echo "You don't have any article!";
                        }
                
                
                ?>

                <!-- Example of a single article -->
                <!-- <div class="bg-white p-4 rounded-lg shadow-md flex justify-between items-center">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-800">How to Manage Your Articles</h3>
                        <p class="text-gray-600 text-sm mt-2">Learn the basics of managing articles in your platform with simple tools and techniques.</p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="openModifyArticlePopup('How to Manage Your Articles', 'Learn the basics of managing articles in your platform with simple tools and techniques.', 1)" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Edit</button>
                        <button onclick="openDeleteArticlePopup(1)" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete</button>
                    </div>
                </div>
                

                <div class="bg-white p-4 rounded-lg shadow-md flex justify-between items-center">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-800">Understanding CSS Flexbox</h3>
                        <p class="text-gray-600 text-sm mt-2">A complete guide to mastering Flexbox for responsive web layouts.</p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="openModifyArticlePopup('Understanding CSS Flexbox', 'A complete guide to mastering Flexbox for responsive web layouts.', 2)" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Edit</button>
                        <button onclick="openDeleteArticlePopup(2)" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete</button>
                    </div>
                </div> -->

                
            </div>
        </section>
    </main>


    <?php 

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST['edit'])){
                $getTitre = htmlspecialchars(trim($_POST['articleTitle']));
                $getContent = htmlspecialchars(trim($_POST['articleContent']));
                $getArticle = htmlspecialchars(trim($_POST['edit']));
                if(!empty($getTitre) && !empty($getContent) && !empty($getArticle)){
                    $callFunctions->editArticle($getArticle, $getTitre, $getContent);
                }else{
                    echo '<script>Invalid information!</script>';
                }
            }

            if(isset($_POST['delete'])){
                $getArticle = htmlspecialchars(trim($_POST['delete']));
                if(!empty($getArticle)){
                    $callFunctions->removeArticle($getArticle);
                }else{
                    echo '<script>Invalid information!</script>';
                }
            }
            
            
        }
    
    
    
    ?>

    <!-- Modify Article Popup -->
    <div id="modifyArticlePopup" class="fixed hidden flex justify-center items-center inset-0 bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-2xl font-semibold mb-4">Modify Article</h3>
            <form method="POST">
                <div class="mb-4">
                    <label for="articleTitle" class="block text-gray-700">Article Title</label>
                    <input type="text" id="articleTitle" name="articleTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="articleContent" class="block text-gray-700">Article Content</label>
                    <textarea id="articleContent" name="articleContent" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="6"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModifyArticlePopup()" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
                    <button id="edit" name="edit" type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Article Delete Confirmation Popup -->
    <div id="deleteArticlePopup" class="fixed hidden flex justify-center items-center inset-0 bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-2xl font-semibold mb-4">Delete Article</h3>
            <p class="mb-4">Are you sure you want to delete this article?</p>
            <form method="POST" class="flex justify-end space-x-4">
                <button type="button" onclick="closeDeleteArticlePopup()" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
                <button id="delete" name="delete" type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Delete</button>
            </form>
        </div>
    </div>

    <script>
        // Open Modify Article Popup with Pre-filled Data
        function openModifyArticlePopup(title, content, articleId) {
            document.getElementById("articleTitle").value = title;
            document.getElementById("articleContent").value = content;
            document.getElementById("edit").value = articleId;
            document.getElementById("modifyArticlePopup").classList.remove("hidden");
        }

        // Close Modify Article Popup
        function closeModifyArticlePopup() {
            document.getElementById("modifyArticlePopup").classList.add("hidden");
        }

        // Open Delete Article Popup
        function openDeleteArticlePopup(articleId) {
            document.getElementById("delete").value = articleId;
            document.getElementById("deleteArticlePopup").classList.remove("hidden");
        }

        // Close Delete Article Popup
        function closeDeleteArticlePopup() {
            document.getElementById("deleteArticlePopup").classList.add("hidden");
        }
    </script>
</body>
</html>
