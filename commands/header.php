<?php 
                session_start();
                $getID;
                $getName;


                if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
                    $getID = $_SESSION['id'];
                }else{
                    session_destroy();
                    echo '<script>location.replace("../login/login.php")</script>';
                    die();
                }
            
            
                if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['logout'])){
                    session_destroy();
                    echo '<script>location.replace("../index.php")</script>';
                    die();
                }

                require_once '../database.php';
                if($getID){
                    $conn = new database();
                    $db = $conn->getConnect();


                    $sql = $db->prepare("SELECT * FROM client WHERE id_client = :id");
                    $sql->bindParam(":id",$getID);
                    if($sql->execute()){
                        $user = $sql->fetch(PDO::FETCH_ASSOC);
                        $getName = $user['nom'];
                    }
                }
                

                
             ?>




<header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="flex justify-between items-center">
            <!-- Greeting -->
            <div class="text-xl font-semibold">Hi, <?php 
                if($getName){
                    echo $getName;
                }else{
                    session_destroy();
                    echo '<script>location.replace("../index.php")</script>';
                }
             ?>!</div>
            <!-- Logout Link -->
            <form method="post"><button name="logout" href="logout.html" class="text-white hover:text-blue-300">🚪 Logout</button></form>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-600 text-white min-h-screen p-6">
            <h1 class="text-2xl font-bold mb-6">Drive & Loc</h1>
            <nav>
                <ul class="space-y-4">
                    <li><a href="dashboard.php" class="block hover:text-blue-300">🏠 Dashboard</a></li>
                    <li><a href="explore.php" class="block hover:text-blue-300">🚗 Explore Vehicles</a></li>
                    <li><a href="reservation.php" class="block hover:text-blue-300">🛣️ My Reservations</a></li>
                    <li><a href="review.php" class="block hover:text-blue-300">📝 My Reviews</a></li>
                    <li><a href="setting.php" class="block hover:text-blue-300">⚙️ Account Settings</a></li>
                </ul>
            </nav>
        </aside>