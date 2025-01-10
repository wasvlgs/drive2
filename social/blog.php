<?php 
    session_start();
    $getID;

    if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
        $getID = $_SESSION['id'];
    }else{
        $getID = '';
    }

    require_once '../database.php';
  
    $conn = new database();
    $db = $conn->getConnect();

    require_once '../commands/displayArticles.php';
    $callFunctions = new article($conn->getConnect());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Articles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #add-article-modal {
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
            max-width: 700px;
            max-height: 90%;
            overflow-y: auto;
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

        .tag {
            display: inline-flex;
            align-items: center;
            background-color: #e2e8f0;
            border-radius: 9999px;
            padding: 0.25rem 0.5rem;
            margin: 0.25rem;
        }

        .tag span {
            margin-right: 0.5rem;
        }

        .tag i {
            cursor: pointer;
        }
        .modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
  padding-top: 60px;
  text-align: center;
}

/* Modal Content */
.modal-content {
  background-color: #fff;
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 300px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
}

/* Close button */
.close-btn {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close-btn:hover,
.close-btn:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <h1 class="text-3xl font-bold text-blue-600">Drive & Loc Blog</h1>
            <nav class="hidden md:flex space-x-6">
                <a href="../index.php" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                <a href="../social/blog.php" class="text-gray-700 hover:text-blue-600 transition">Explore</a>
                <a href="../index.php#features" class="text-gray-700 hover:text-blue-600 transition">Features</a>
                <a href="../index.php#contact" class="text-gray-700 hover:text-blue-600 transition">Contact</a>
            </nav>
            <?php
                if(!empty($getID)){
                    echo '<a href="../pages/dashboard.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Dashboard</a>';
                }else{
                    echo '<a href="../login/login.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Login</a>';
                }
            ?>
        </div>

        <div class="bg-gray-100 border-t border-b">
            <div class="container mx-auto flex justify-between items-center py-3 px-6 overflow-x-auto">
                <div class="flex space-x-4">
                    <div class="filter-item text-gray-700 bg-white py-2 px-4 rounded-lg shadow-sm hover:bg-blue-100 transition cursor-pointer" onclick="filterArticles('All')">All</div>
                    <div class="filter-item text-gray-700 bg-white py-2 px-4 rounded-lg shadow-sm hover:bg-blue-100 transition cursor-pointer" onclick="filterArticles('Technology')">Technology</div>
                    <div class="filter-item text-gray-700 bg-white py-2 px-4 rounded-lg shadow-sm hover:bg-blue-100 transition cursor-pointer" onclick="filterArticles('Travel')">Travel</div>
                    <div class="filter-item text-gray-700 bg-white py-2 px-4 rounded-lg shadow-sm hover:bg-blue-100 transition cursor-pointer" onclick="filterArticles('Health')">Health</div>
                    <div class="filter-item text-gray-700 bg-white py-2 px-4 rounded-lg shadow-sm hover:bg-blue-100 transition cursor-pointer" onclick="filterArticles('Education')">Education</div>
                    <div class="filter-item text-gray-700 bg-white py-2 px-4 rounded-lg shadow-sm hover:bg-blue-100 transition cursor-pointer" onclick="filterArticles('Lifestyle')">Lifestyle</div>
                </div>

                <div class="relative">
                    <input 
                        type="text" 
                        id="search-input" 
                        placeholder="Search articles..." 
                        class="py-2 px-4 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-600 focus:outline-none w-64"
                        oninput="searchArticles()"
                    >
                    <i class="fa fa-search absolute right-3 top-2.5 text-gray-400"></i>
                </div>
            </div>
        </div>
    </header>

    <section class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-12 px-10">
                <h2 class="text-4xl font-bold text-gray-800">Articles</h2>
                <button onclick="openModal()" class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition">Add Article</button>
            </div>
            <div id="articles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 px-8">
                <!-- Manual articles insertion -->

                <?php 

                    $data = $callFunctions->afficherResult();
                    if(count($data) > 0){
                        foreach($data as $item){
                            $getDesc = substr($item['content'],0,100);
                            echo '<div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                            <img src="../img/imgArticles/'.$item['imgSrc'].'" alt="'.$item['title'].'" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-800 mb-2">'.$item['title'].'</h3>
                                <p class="text-sm text-gray-600 mb-4">By '.$item['nom'].' | '.$item['date_create'].'</p>
                                <p class="text-gray-700 mb-4">'.$getDesc.'...</p>
                                <a href="articles/article.php?article='.$item['id_article'].'" target="_blank" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Read More</a>
                            </div>
                        </div>';
                        }
                    }else{
                        echo 'No article exict';
                    }
                
                ?>

                <!-- <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" alt="Article Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Getting Started with Web Development</h3>
                        <p class="text-sm text-gray-600 mb-4">By John Doe | Jan 7, 2025</p>
                        <p class="text-gray-700 mb-4">Learn the basics of HTML, CSS, and JavaScript...</p>
                        <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Read More</button>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                    <img src="https://via.placeholder.com/400x250" alt="Article Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">The Future of AI</h3>
                        <p class="text-sm text-gray-600 mb-4">By Jane Smith | Jan 6, 2025</p>
                        <p class="text-gray-700 mb-4">Exploring the latest trends in artificial intelligence...</p>
                        <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Read More</button>
                    </div>
                </div> -->

                <!-- Add more articles as necessary -->
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8 space-x-2" id="pagination">
                <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Prev</button>
                <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">1</button>
                <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">2</button>
                <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">Next</button>
            </div>
        </div>
    </section>

    <!-- Add Article Modal -->
    <div id="overlay"></div>
    <div id="add-article-modal">
        <h3 class="text-2xl font-bold mb-6">Add New Article</h3>
        <form method="POST"  enctype="multipart/form-data">
            <div class="mb-6">
                <label for="article-image" class="block text-gray-700 font-semibold mb-2">Article Image</label>
                <input id="article-image" name="image" type="file" accept="image/*" class="w-full p-4 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>
            <div class="mb-6">
                <label for="article-title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input id="article-title" name="titre" type="text" class="w-full p-4 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="Enter the article title" required>
            </div>
            <div class="mb-6">
                <label for="article-content" class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea id="article-content" name="content" rows="10" class="w-full p-4 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none" placeholder="Write your article here..." required></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Tags</label>
                <div id="tag-container" class="flex flex-wrap border p-4 rounded-lg">
                    <input id="tag-input" type="text" class="flex-grow p-2 focus:outline-none" placeholder="Add a tag">
                </div>
                <small class="text-gray-500">Press Enter or comma (,) to add a tag</small>
                <input type="hidden" id="tags-hidden" name="tags" value="">
            </div>
            
            <div class="mb-6">
                <label for="article-them" class="block text-gray-700 font-semibold mb-2">Article Theme</label>
                <select id="article-them" class="w-full p-4 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none" name="them">
                    <option selected disabled value="">   --  Select theme  --   </option>
                    <?php $callFunctions->get_Themes(); ?>
                </select>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-400 transition" id="cancel-button">Cancel</button>
                <button name="addArticle" type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition">Add Article</button>
            </div>
        </form>
    </div>

    <?php

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            if(isset($_POST['addArticle'])){
                $getImage = $_FILES['image'];
                $getTitre = htmlspecialchars(trim($_POST['titre']));
                $getContent = htmlspecialchars(trim($_POST['content']));
                $getTags = htmlspecialchars(trim($_POST['tags']));
                $getThem = htmlspecialchars(trim($_POST['them']));
                if(!empty($getTitre) && !empty($getContent) && !empty($getImage) && !empty($getThem)){
                    $callFunctions->ajouterArticle($getTitre,$getContent,$getImage,$getThem,$getTags,$getID);
                }else{
                    echo '<script>alert("Invalid information")</script>';
                }

            }
        }



    ?>


    </div>

    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Drive & Loc Blog. All rights reserved.</p>
        </div>
    </footer>

    <script>
    // Modal elements and state management
    // Modal elements and state management
const overlay = document.getElementById('overlay');
const modal = document.getElementById('add-article-modal');
const cancelButton = document.getElementById('cancel-button');
const tagContainer = document.getElementById('tag-container');
const tagInput = document.getElementById('tag-input');
const tagsHidden = document.getElementById('tags-hidden');
let tags = new Set();

document.getElementById('tag-input').addEventListener('keyup', function(e) {
    if (e.key === 'Enter' || e.key === ',') {
        let tagInput = e.target.value.trim();
        if (tagInput) {
            let tags = document.getElementById('tags-hidden').value;
            tags += tags ? ',' + tagInput : tagInput;  // Append the tag to existing ones
            document.getElementById('tags-hidden').value = tags;
            
            let tagContainer = document.getElementById('tag-container');
            let tagElement = document.createElement('span');
            tagElement.classList.add('tag');
            tagElement.textContent = tagInput;
            tagContainer.appendChild(tagElement);
            e.target.value = '';  // Clear input field after tag is added
        }
    }
});
// Modal functions
function openModal() {
    modal.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modal.style.display = 'none';
    overlay.style.display = 'none';
    document.body.style.overflow = 'auto';
    resetForm();
}

function resetForm() {
    document.getElementById('add-article-form').reset();
    tags.clear();
    updateHiddenInput();
    while (tagContainer.firstChild) {
        if (tagContainer.firstChild !== tagInput) {
            tagContainer.removeChild(tagContainer.firstChild);
        } else {
            break;
        }
    }
}

// Tag handling functions
function handleTagInput(event) {
    if (event.type === 'blur' || event.key === 'Enter' || event.key === ',') {
        event.preventDefault();
        const value = tagInput.value.trim();
        if (value) {
            const tagValues = value.split(',').map(tag => tag.trim()).filter(tag => tag !== '');
            tagValues.forEach(addTag);
            tagInput.value = '';
        }
    }
}

function addTag(tag) {
    if (!tags.has(tag) && tag !== '') {
        tags.add(tag);
        const tagElement = document.createElement('div');
        tagElement.className = 'tag';
        tagElement.innerHTML = `
            <span>${tag}</span>
            <i class="fas fa-times text-gray-500" onclick="removeTag(this, '${tag}')"></i>
        `;
        tagContainer.insertBefore(tagElement, tagInput);
        updateHiddenInput();
    }
}

function removeTag(element, tag) {
    tags.delete(tag);
    element.parentElement.remove();
    updateHiddenInput();
}

function updateHiddenInput() {
    tagsHidden.value = Array.from(tags).join(',');
}



// Filter articles function
function filterArticles(category) {
    // Add your filtering logic here
    console.log('Filtering by:', category);
}

// Search articles function
function searchArticles() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    // Add your search logic here
    console.log('Searching for:', searchTerm);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the page

    
    // Set up event listeners
    tagInput.addEventListener('keydown', handleTagInput);
    tagInput.addEventListener('blur', handleTagInput);
    
    cancelButton.addEventListener('click', closeModal);
    
    overlay.addEventListener('click', closeModal);
    
    document.getElementById('add-article-form').addEventListener('submit', function(e) {
        e.preventDefault();
        // Handle form submission here
        console.log('Tags:', tagsHidden.value);
        closeModal();
    });


});
</script>
</body>
</html>