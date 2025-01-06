<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reviews - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php
            require_once '../commands/header.php';
         ?>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- My Reviews Section -->
            <section id="my-reviews" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">My Reviews</h2>
                
                <!-- Review List -->
                <div class="space-y-4">


                    <?php 

                        require_once '../commands/displayReview.php';
                        $getReviews = new displayReview($conn->getConnect(),$getID);
                        $getReviews->showReviews();


                        if($_SERVER['REQUEST_METHOD'] == "POST"){
                            if(isset($_POST['edit']) && !empty($_POST['edit'])){
                                $getReviewId = htmlspecialchars(trim($_POST['edit']));
                                $getDesc = htmlspecialchars(trim($_POST['reviewText']));
                                $getNote = htmlspecialchars(trim($_POST['rating']));

                                if(!empty($getReviewId) && !empty($getDesc) && !empty($getNote) && ($getNote === '1' || $getNote === '2' || $getNote === '3' || $getNote === '4' || $getNote === '5')){
                                    $getReviews->editReview($getNote,$getDesc,$getReviewId);
                                }else{
                                    echo '<script>alert("Invalid information!")</script>';
                                }
                            }


                            if(isset($_POST['delete'])){
                                $getReviewId = htmlspecialchars(trim($_POST['delete']));

                                if(!empty($getReviewId)){
                                    $getReviews->removeReview($getReviewId);
                                }else{
                                    echo '<script>alert("Error try again!")</script>';
                                }
                            }

                        }


                    ?>



                </div>
            </section>
        </main>
    </div>

    <!-- Modify Review Popup -->
    <div id="modifyReviewPopup" class="fixed hidden flex justify-center items-center inset-0 bg-gray-800 bg-opacity-50 justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-2xl font-semibold mb-4">Modify Review</h3>
            <form method="POST">
                <div class="mb-4">
                    <label for="vehicle" class="block text-gray-700">Vehicle</label>
                    <input type="text" id="vehicle" name="vehicle" class="w-full px-4 py-2 border border-gray-300 rounded-lg" disabled>
                </div>
                <div class="mb-4">
                    <label for="reviewText" class="block text-gray-700">Review Text</label>
                    <textarea id="reviewText" name="reviewText" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="4"></textarea>
                </div>
                <div class="mb-4">
                    <label for="rating" class="block text-gray-700">Rating</label>
                    <select id="rating" name="rating" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="5">★★★★★</option>
                        <option value="4">★★★★☆</option>
                        <option value="3">★★★☆☆</option>
                        <option value="2">★★☆☆☆</option>
                        <option value="1">★☆☆☆☆</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModifyReviewPopup()" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
                    <button id="edit" name="edit" type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open Modify Review Popup with Pre-filled Data
        function openModifyReviewPopup(vehicle, reviewText, rating, review) {
            document.getElementById("vehicle").value = vehicle;
            document.getElementById("reviewText").value = reviewText;
            document.getElementById("rating").value = rating;
            document.getElementById("edit").value = review;
            document.getElementById("modifyReviewPopup").classList.remove("hidden");
        }

        // Close Modify Review Popup
        function closeModifyReviewPopup() {
            document.getElementById("modifyReviewPopup").classList.add("hidden");
        }
    </script>
</body>
</html>
