


<?php 

    session_start();

    if(isset($_GET['car']) && !empty($_GET['car'])){
        class getCar{

                private $carId;
                private $database;

                public function __construct($db)
                {
                    $this->carId = $_GET['car'];
                    $this->database = $db;
                }


                public function getInformation(){

                    $sql = "SELECT * FROM vehicule INNER JOIN categorie ON vehicule.id_categorie = categorie.id_categorie WHERE id_vehicule = :vehicule";
                    $getInfo = $this->database->prepare($sql);
                    $getInfo->bindParam(":vehicule",$this->carId);
                    if($getInfo->execute() && $getInfo->rowCount() === 1){
                        return $getInfo->fetch(PDO::FETCH_ASSOC);
                    }else{
                        die("No car exict!");
                    }
                }
            }



    


    include_once '../database.php';
    $conn = new database;
    $connCard = new getCar($conn->getConnect());

    $data = $connCard->getInformation();
    }else{
        die("No car exict!");
    }


?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details - Drive & Loc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl font-semibold">Drive & Loc</div>
            <div>
                <a href="../index.php" class="text-white hover:text-blue-300 px-4">Home</a>
                <a href="../pages/explore.php" class="text-white hover:text-blue-300 px-4">Explore Vehicles</a>
            </div>
        </div>
    </header>

    <!-- Car Details Section -->
    <div class="container mx-auto py-12 px-5">
        <div class="flex flex-col lg:flex-row justify-between items-center space-y-8 lg:space-y-0">
            <!-- Car Image Section -->
            <div class="w-full lg:w-1/2 max-h-[550px] flex justify-center items-center overflow-hidden">
                <img src="../img/imgPages/<?php echo $data['imgSrc']; ?>" alt="Car Image" class="w-full h-auto rounded-lg shadow-lg">
            </div>

            <!-- Car Information Section -->
            <div class="w-full lg:w-1/2 space-y-6 px-6">
                <h2 class="text-4xl font-semibold text-gray-800"><?php echo $data['name']; ?></h2>
                <p class="text-xl text-gray-600"><?php echo $data['description']; ?></p>

                <!-- Car Specifications -->
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-800">
                        <span class="font-medium">Category:</span>
                        <span><?php echo $data['nom']; ?></span>
                    </div>
                    <div class="flex justify-between text-gray-800">
                        <span class="font-medium">Price per Day:</span>
                        <span>$<?php echo $data['prix']; ?></span>
                    </div>
                    <div class="flex justify-between text-gray-800">
                        <span class="font-medium">Availability:</span>
                        <span><?php
                            if($data['disponibilite'] == 1){
                                echo 'Available';
                            }else{
                                echo 'Not available';
                            }
                         ?></span>
                    </div>
                    <div class="flex justify-between text-gray-800">
                        <span class="font-medium">Modele:</span>
                        <span><?php echo $data['modele']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservation Form -->
        <!-- <section class="mt-12">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6">Reserve This Car</h3>
            <form method="POST" class="space-y-6">
                <div class="flex flex-col">
                    <label for="lieuDeCharge" class="text-gray-700 font-medium mb-2">Lieu de charge</label>
                    <input type="text" id="lieuDeCharge" name="lieuDeCharge" class="w-full p-3 border border-gray-300 rounded-md" required>
                </div>

               

                <div class="flex space-x-6">
                    <div class="flex flex-col w-1/2">
                        <label for="start-date" class="text-gray-700 font-medium mb-2">Start Date</label>
                        <input type="date" id="start-date" name="startDate" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label for="end-date" class="text-gray-700 font-medium mb-2">End Date</label>
                        <input type="date" id="end-date" name="endDate" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button name="reserve" type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-500">Reserve Now</button>
                </div>
            </form>
        </section> -->

        <?php 
            if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
                echo '<section class="mt-12">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6">Reserve This Car</h3>
            <form method="POST" class="space-y-6">
                <div class="flex flex-col">
                    <label for="lieuDeCharge" class="text-gray-700 font-medium mb-2">Lieu de charge</label>
                    <input type="text" id="lieuDeCharge" name="lieuDeCharge" class="w-full p-3 border border-gray-300 rounded-md" required>
                </div>

               

                <div class="flex space-x-6">
                    <div class="flex flex-col w-1/2">
                        <label for="start-date" class="text-gray-700 font-medium mb-2">Start Date</label>
                        <input type="date" id="start-date" name="startDate" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label for="end-date" class="text-gray-700 font-medium mb-2">End Date</label>
                        <input type="date" id="end-date" name="endDate" class="w-full p-3 border border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button name="reserve" type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-500">Reserve Now</button>
                </div>
            </form>
        </section>';
            }

            require_once '../commands/reserve.php';

            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['reserve'])){
                $lieu = htmlspecialchars(trim($_POST['lieuDeCharge']));
                $startDate = htmlspecialchars(trim($_POST['startDate']));
                $endDate = htmlspecialchars(trim($_POST['endDate']));
                $idClient = $_SESSION['id'];
                $idVecule = htmlspecialchars(trim($_GET['car']));
                if(!empty($lieu) && !empty($startDate) && !empty($endDate) && !empty($idClient) && !empty($idVecule)){
                    $conn = new database();
                    $getConn = $conn->getConnect();
                    $reserve = new reserve($lieu,$startDate,$endDate,$idClient,$idVecule,$getConn);
                    $reserve->reserve();
                }
                
            }
        
        
        
        
        
        
        
        ?>

        <!-- Customer Reviews Section -->
        <section class="mt-12">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6">Customer Reviews</h3>
            <div class="space-y-8">

                <?php 

                    class displayReviewsCar{
                        private $database;
                        private $getID;

                        public function __construct($getID,$db)
                        {
                            $this->database = $db;
                            $this->getID = $getID;
                        }


                        public function showReviews(){
                            $getReviews = $this->database->prepare("SELECT * FROM avis INNER JOIN client ON avis.id_client = client.id_client WHERE id_vehicule = :idVehicule");
                            $getReviews->bindParam(":idVehicule",$this->getID);
                            if($getReviews->execute() && $getReviews->rowCount() > 0){
                                foreach($getReviews as $review){
                                    $getStars = '';
                                    for($i = 1; $i < $review['note']; $i++){
                                        $getStars = $getStars.'⭐';
                                    }
                                    echo '<div class="flex space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full flex justify-center items-center bg-white"><i class="fa-solid fa-user text-2xl"></i></div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="text-gray-800 font-semibold">'.$review['nom'].'</div>
                                        <div class="text-gray-600">"'.$review['commentaire'].'"</div>
                                        <div class="text-yellow-400">'.$getStars.'</div>
                                    </div>
                                </div>';
                                }
                            }else{
                                echo 'No review exict!';
                            }
                        }
                    }

                    $getFunction = new displayReviewsCar($_GET['car'],$conn->getConnect());
                    $getFunction->showReviews();
                
                ?>
                <!-- <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <img src="user-avatar.jpg" alt="User Avatar" class="w-12 h-12 rounded-full">
                    </div>
                    <div class="space-y-2">
                        <div class="text-gray-800 font-semibold">John Doe</div>
                        <div class="text-gray-600">"This sedan was amazing! Super comfortable for my trip to the mountains. Highly recommend!"</div>
                        <div class="text-yellow-400">⭐⭐⭐⭐⭐</div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <img src="user-avatar.jpg" alt="User Avatar" class="w-12 h-12 rounded-full">
                    </div>
                    <div class="space-y-2">
                        <div class="text-gray-800 font-semibold">Jane Smith</div>
                        <div class="text-gray-600">"Perfect for city driving. Clean and stylish. Worth every penny!"</div>
                        <div class="text-yellow-400">⭐⭐⭐⭐</div>
                    </div>
                </div> -->
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Drive & Loc. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
