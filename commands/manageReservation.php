<?php








    class manageReservation{

        private $database;
        
        public function __construct($db)
        {
            $this->database = $db;
        }


        public function showPenReservation(){
            $getReservation = $this->database->prepare("SELECT *,reservation.statut as reStatus FROM reservation INNER JOIN client ON reservation.id_client = client.id_client
             INNER JOIN vehicule ON reservation.id_vehicule = vehicule.id_vehicule WHERE reservation.statut = 'Pending'");
            if($getReservation->execute() && $getReservation->rowCount() > 0){
                foreach($getReservation as $reserve){
                    echo '<tr>
                            <td class="py-4 px-6">'.$reserve['nom'].'</td>
                            <td class="py-4 px-6">'.$reserve['name'].'</td>
                            <td class="py-4 px-6">'.$reserve['date_start'].'</td>
                            <td class="py-4 px-6">'.$reserve['reStatus'].'</td>
                            <td class="py-4 px-6 flex space-x-4">
                                <form method="POST"><button value="'.$reserve['id_reservation'].'" name="confirm" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-500">Confirm</button>
                                <button value="'.$reserve['id_reservation'].'" name="cancel" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Cancel</button></form>
                            </td>
                        </tr>';
                }
            }else{
                echo 'No reservation exict';
            }
        }

        public function showActReservation(){
            $getReservation = $this->database->prepare("SELECT *,reservation.statut as reStatus FROM reservation INNER JOIN client ON reservation.id_client = client.id_client
             INNER JOIN vehicule ON reservation.id_vehicule = vehicule.id_vehicule WHERE reservation.statut = 'Canfirmed'");
            if($getReservation->execute() && $getReservation->rowCount() > 0){
                foreach($getReservation as $reserve){
                    echo '<tr>
                            <td class="py-4 px-6">'.$reserve['nom'].'</td>
                            <td class="py-4 px-6">'.$reserve['name'].'</td>
                            <td class="py-4 px-6">'.$reserve['date_start'].'</td>
                            <td class="py-4 px-6">'.$reserve['reStatus'].'</td>
                            <td class="py-4 px-6 flex space-x-4">
                                <form method="POST"><button value="'.$reserve['id_reservation'].'" name="cancel" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Cancel</button></form>
                            </td>
                        </tr>';
                }
            }else{
                echo 'No reservation exict';
            }
        }

        public function confirmReservation($getId){
            $confirm = $this->database->prepare("UPDATE reservation SET statut = 'Canfirmed' WHERE id_reservation = :getID");
            $confirm->bindParam(":getID",$getId);
            if($confirm->execute()){
                echo '<script>Location.replace("reservation.php")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }

        public function rejectReservation($getId){
            $reject = $this->database->prepare("UPDATE reservation SET statut = 'Rejected' WHERE id_reservation = :getID");
            $reject->bindParam(":getID",$getId);
            if($reject->execute()){
                echo '<script>Location.replace("reservation.php")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }
    }