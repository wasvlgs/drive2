

<?php






    class getAdminStatique{


        private $database;
        private $idClient;

        public function __construct($db,$getID)
        {
            $this->database = $db;
            $this->idClient = $getID;
        }


        public function getAllVehicule(){
            $getAllVehicule = $this->database->prepare("SELECT COUNT(*) AS totale FROM vehicule");
            if($getAllVehicule->execute()){
                $getRow = $getAllVehicule->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }

        public function getActiveResere(){
            $getActiveReserve = $this->database->prepare("SELECT COUNT(*) AS totale FROM reservation WHERE statut = 'Canfirmed'");
            if($getActiveReserve->execute()){
                $getRow = $getActiveReserve->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }

        public function getAllReviews(){
            $getReviews = $this->database->prepare("SELECT COUNT(*) AS totale FROM avis");
            if($getReviews->execute()){
                $getRow = $getReviews->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }

        public function getAllCategories(){
            $getCategories = $this->database->prepare("SELECT COUNT(*) AS totale FROM categorie");
            if($getCategories->execute()){
                $getRow = $getCategories->fetch(PDO::FETCH_ASSOC);
                return $getRow['totale'];
            }else{
                return 0;
            }
        }


        public function showAllReservation(){
            $getAllReservation = $this->database->prepare("SELECT *,reservation.statut AS reStatus FROM reservation INNER JOIN vehicule ON reservation.id_vehicule = vehicule.id_vehicule INNER JOIN client ON reservation.id_client = client.id_client ORDER BY id_reservation DESC");
            if($getAllReservation->execute() && $getAllReservation->rowCount() > 0){
                foreach($getAllReservation as $reservation){
                    $getColor = 'black';
                    if($reservation['reStatus'] === 'Pending'){
                        $getColor = "yellow-600";
                    }else if($reservation['reStatus'] === 'Canfirmed'){
                        $getColor = "green-600";
                    }else if($reservation['reStatus'] === 'Rejected'){
                        $getColor = "red-600";
                    }
                    echo '<tr class="border-b">
                                <td class="py-4 px-6">'.$reservation['name'].'</td>
                                <td class="py-4 px-6">'.$reservation['nom'].'</td>
                                <td class="py-4 px-6">'.$reservation['email'].'</td>
                                <td class="py-4 px-6">'.$reservation['date_start'].'</td>
                                <td class="py-4 px-6 text-'.$getColor.'">'.$reservation['reStatus'].'</td>
                            </tr>';
                }
            }else{
                echo 'Faild to get data';
            }
        }

    }