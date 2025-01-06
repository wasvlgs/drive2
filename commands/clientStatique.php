

<?php






    class getClientStatique{


        private $database;
        private $idClient;

        public function __construct($db,$getID)
        {
            $this->database = $db;
            $this->idClient = $getID;
        }


        public function getActiveReservation(){
            $getActiveReserve = $this->database->prepare("SELECT COUNT(*) AS totale FROM reservation WHERE id_client = :getClient AND statut = 'Canfirmed'");
            $getActiveReserve->bindParam(":getClient",$this->idClient);
            if($getActiveReserve->execute()){
                $getRow = $getActiveReserve->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }

        public function getReviews(){
            $getReviews = $this->database->prepare("SELECT COUNT(*) AS totale FROM avis WHERE id_client = :getClient");
            $getReviews->bindParam(":getClient",$this->idClient);
            if($getReviews->execute()){
                $getRow = $getReviews->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }

        public function getPendingReservation(){
            $getPendingReserve = $this->database->prepare("SELECT COUNT(*) AS totale FROM reservation WHERE id_client = :getClient AND statut = 'Pending'");
            $getPendingReserve->bindParam(":getClient",$this->idClient);
            if($getPendingReserve->execute()){
                $getRow = $getPendingReserve->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }

        public function getRejectedReservation(){
            $getRejectedReserve = $this->database->prepare("SELECT COUNT(*) AS totale FROM reservation WHERE id_client = :getClient AND statut = 'Rejected'");
            $getRejectedReserve->bindParam(":getClient",$this->idClient);
            if($getRejectedReserve->execute()){
                $getRow = $getRejectedReserve->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }

        public function showVehicules(){
            $sql = $this->database->prepare("SELECT * FROM vehicule LIMIT 3");
            if($sql->execute() && $sql->rowCount() > 0){
                foreach($sql as $item){
                    echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <img src="../img/imgPages/'.$item['imgSrc'].'" alt="SUV" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-xl font-bold">'.$item['name'].'</h3>
                            <p class="text-gray-600">Starting at $'.$item['prix'].'/day</p>
                            <a target="_blank" href="../cars/car.php?car='.$item['id_vehicule'].'" class="text-blue-600 hover:underline">View Details</a>
                        </div>
                    </div>';
                }
            }else{
                    echo 'No vehicule exict!';
                }

        }

        public function showAllReservation(){
            $getReservation = $this->database->prepare("SELECT * FROM reservation INNER JOIN vehicule ON reservation.id_vehicule = vehicule.id_vehicule WHERE reservation.id_client = :idClient ORDER BY id_reservation DESC");
            $getReservation->bindParam(":idClient",$this->idClient);
            if($getReservation->execute() && $getReservation->rowCount() > 0){
                foreach($getReservation as $reservation){
                    $getColor = 'black';
                    if($reservation['statut'] === 'Pending'){
                        $getColor = "yellow-600";
                    }else if($reservation['statut'] === 'Canfirmed'){
                        $getColor = "green-600";
                    }else if($reservation['statut'] === 'Rejected'){
                        $getColor = "red-600";
                    }
                    echo '<tr class="border-b">
                            <td class="py-4 px-6">'.$reservation['name'].'</td>
                            <td class="py-4 px-6">'.$reservation['date_start'].'</td>
                            <td class="py-4 px-6">'.$reservation['date_end'].'</td>
                            <td class="py-4 px-6 text-'.$getColor.'">'.$reservation['statut'].'</td>
                        </tr>';
                }
            }else{
                echo 'Faild to get data';
            }
        }

        public function showReviews(){
            $getReviews = $this->database->prepare("SELECT * FROM avis INNER JOIN vehicule ON avis.id_vehicule = vehicule.id_vehicule WHERE id_client = :idClient ORDER BY id_avis DESC");
            $getReviews->bindParam(":idClient",$this->idClient);
            if($getReviews->execute() && $getReviews->rowCount() > 0){
                foreach($getReviews as $item){

                    $getStars = '';
                    for($i = 1; $i <= 5; $i++){
                        if($i <= $item['note']){
                            $getStars = $getStars.'★';
                        }else{
                            $getStars = $getStars.'☆';
                        }
                    }
                    echo '<div class="bg-white shadow-lg rounded-lg p-6">
                        <h3 class="font-bold text-gray-800">'.$item['name'].'</h3>
                        <p class="text-gray-600">"'.$item['commentaire'].'"</p>
                        <div class="text-yellow-500 mt-2">'.$getStars.'</div>
                    </div>';
                }
                
            }else{
                echo 'You hove no review!';
            }
        }
    }