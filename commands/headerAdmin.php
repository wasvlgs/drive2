<?php

    session_start();
    $getID;
    $getName;


    if(isset($_SESSION['id']) && isset($_SESSION['role']) && !empty($_SESSION['id']) && $_SESSION['role'] === "admin"){
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
            <div class="text-xl font-semibold">Welcome to control section, <?php echo $getName; ?>!</div>
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
                    <li><a href="vehicules.php" class="block hover:text-blue-300">🚗 Manage Vehicles</a></li>
                    <li><a href="reservation.php" class="block hover:text-blue-300">🛣️ Manage Reservations</a></li>
                    <li><a href="review.php" class="block hover:text-blue-300">📝 Manage Reviews</a></li>
                    <li><a href="categorie.php" class="block hover:text-blue-300">📂 Manage Categories</a></li>
                </ul>
            </nav>
        </aside>
