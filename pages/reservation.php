<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php
            require_once '../commands/header.php';
         ?>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <!-- My Reservations Section -->
            <section id="my-reservations" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">My Reservations</h2>
                
                <!-- Reservation Table -->
                <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="py-3 px-6">Vehicle</th>
                            <th class="py-3 px-6">Lieu</th>
                            <th class="py-3 px-6">Pickup Date</th>
                            <th class="py-3 px-6">Return Date</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php

                            require_once '../commands/displayReservation.php';
                            $conn = new database();
                            $getReservation = new displayReservation($conn->getConnect(),$getID);
                            $getReservation->displayReservationClient();
                            

                            if($_SERVER['REQUEST_METHOD'] === "POST"){

                                if(isset($_POST['edit']) && !empty($_POST['edit'])){
                                    $getPlace = htmlspecialchars(trim($_POST['lieu']));
                                    $getStart = htmlspecialchars(trim($_POST['pickupDate']));
                                    $getEnd = htmlspecialchars(trim($_POST['returnDate']));
                                    $getReserveId = htmlspecialchars(trim($_POST['edit']));

                                    if(!empty($getPlace) && !empty($getStart) && !empty($getEnd) && !empty($getReserveId)){
                                        $getReservation->editReserve($getPlace,$getStart,$getEnd,$getReserveId);
                                    }else{
                                        echo '<script>alert("Invalid informations!")</script>';
                                    }
                                }
                                if(isset($_POST['delete']) && !empty($_POST['delete'])){
                                    $getReserveId2 = htmlspecialchars(trim($_POST['delete']));
                                    if(!empty($getReserveId2)){
                                        $getReservation->deleteReserve($getReserveId2);
                                    }
                                }

                                if(isset($_POST['review']) && !empty($_POST['review'])){
                                    $getRate = htmlspecialchars(trim($_POST['rating']));
                                    $getReviewText = htmlspecialchars(trim($_POST['reviewText']));
                                    $vehiculeId = htmlspecialchars(trim($_POST['review']));
                                    $getClient = $getID;
                                    if(!empty($getRate) && !empty($getReviewText) && !empty($vehiculeId) && ($getRate === '1' || $getRate === '2' || $getRate === '3' || $getRate === '4' || $getRate === '5' )){
                                        $getReservation->addReview($getRate,$getReviewText,$getClient,$vehiculeId);
                                    }else{
                                        echo '<script>alert("Invalid review!")</script>';
                                    }

                                }
                                
                            }


                            
                        ?>
                        
                    </tbody>
                </table>
            </section>
        </main>

    <!-- Modify Reservation Popup -->
    <div id="modifyPopup" class="fixed hidden flex justify-content items-center inset-0 bg-gray-800 bg-opacity-50 justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg">
            <h3 class="text-2xl font-semibold mb-4">Modify Reservation</h3>
            <form method="POST">
                <div class="mb-4">
                    <label for="vehicle" class="block text-gray-700">Lieu</label>
                    <input type="text" id="vehicle" name="lieu" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="pickupDate" class="block text-gray-700">Pickup Date</label>
                    <input type="date" id="pickupDate" name="pickupDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="returnDate" class="block text-gray-700">Return Date</label>
                    <input type="date" id="returnDate" name="returnDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModifyPopup()" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
                    <button id="submit" name="edit" type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Set Review Popup -->
    <div id="reviewPopup" class="fixed hidden flex justify-content items-center inset-0 bg-gray-800 bg-opacity-50 justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg">
            <h3 class="text-2xl font-semibold mb-4">Set Review for <span id="reviewVehicle"></span></h3>
            <form method="POST">
                <div class="mb-4">
                    <label for="reviewRating" class="block text-gray-700">Rating</label>
                    <select id="reviewRating" name="rating" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="reviewText" class="block text-gray-700">Review</label>
                    <textarea id="reviewText" name="reviewText" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeReviewPopup()" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
                    <button id="review" name="review" type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Submit Review</button>
                </div>
            </form>
        </div>
    </div>



    

    <script>
        // Open Modify Popup with Pre-filled Data
        function openModifyPopup(place, pickupDate, returnDate, getID) {
            document.getElementById("vehicle").value = place;
            document.getElementById("pickupDate").value = pickupDate;
            document.getElementById("returnDate").value = returnDate;
            document.getElementById("submit").value = getID;
            document.getElementById("modifyPopup").classList.remove("hidden");
        }

        // Close Modify Popup
        function closeModifyPopup() {
            document.getElementById("modifyPopup").classList.add("hidden");
        }

        // Open Review Popup with Vehicle Name
        function openReviewPopup(vehicle,id) {
            document.getElementById("reviewVehicle").textContent = vehicle + ' vehicule';
            document.getElementById("reviewPopup").classList.remove("hidden");
            document.getElementById("review").value = id;
        }

        // Close Review Popup
        function closeReviewPopup() {
            document.getElementById("reviewPopup").classList.add("hidden");
        }
    </script>
</body>
</html>
