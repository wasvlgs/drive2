



<?php



    class displayReview{

        private $database;
        private $getIdClient;

        public function __construct($database,$getIdClient)
        {
            $this->database = $database;
            $this->getIdClient = $getIdClient;
        }

        public function showReviews(){
            $getReviews = $this->database->prepare("SELECT * FROM avis INNER JOIN vehicule ON avis.id_vehicule = vehicule.id_vehicule WHERE id_client = :idClient ORDER BY id_avis DESC");
            $getReviews->bindParam(":idClient",$this->getIdClient);
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
                        <h3 class="text-xl font-semibold text-gray-800">'.$item['name'].'</h3>
                        <div class="flex items-center space-x-2">
                            <div class="text-yellow-500">'.$getStars.'</div>
                            <span class="text-gray-600">('.$item['note'].'/5)</span>
                        </div>
                        <p class="text-gray-600 mt-2">"'.$item['commentaire'].'"</p>
                        <form method="POST" class="mt-4 flex justify-end space-x-4">
                            <button type="button" onclick="openModifyReviewPopup(`'.$item['name'].'`, `'.$item['commentaire'].'`, '.$item['note'].','.$item['id_avis'].')" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Modify</button>
                            <button name="delete" type="submit" value="'.$item['id_avis'].'" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Delete</button>
                        </form>
                    </div>';
                }
                
            }else{
                echo 'You hove no review!';
            }
        }

        public function editReview($getNote,$getDesc,$getId){
            $editReview = $this->database->prepare("UPDATE avis SET note = :getNote, commentaire = :getDesc WHERE id_avis = :getId");
            $editReview->bindParam(":getNote",$getNote);
            $editReview->bindParam(":getDesc",$getDesc);
            $editReview->bindParam(":getId",$getId);
            if($editReview->execute()){
                echo '<script>location.replace("review.php")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }

        public function removeReview($getId){
            $deleteReview = $this->database->prepare("DELETE FROM avis WHERE id_avis = :idAvis");
            $deleteReview->bindParam(":idAvis",$getId);
            if($deleteReview->execute()){
                echo '<script>location.replace("review.php")</script>';
            }else{
                echo '<script>alert("Error try again later!")</script>';
            }
        }


    }





