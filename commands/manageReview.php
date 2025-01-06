<?php






    class manageReview{

        private $database;

        public function __construct($db)
        {
            $this->database = $db;
        }


        public function showReviews(){

            $getReviews = $this->database->prepare("SELECT * FROM avis INNER JOIN client ON avis.id_client = client.id_client INNER JOIN vehicule ON avis.id_vehicule = vehicule.id_vehicule");
            if($getReviews->execute() && $getReviews->rowCount() > 0){
                foreach($getReviews as $review){
                    echo '<tr>
                            <td class="py-4 px-6">'.$review['nom'].'</td>
                            <td class="py-4 px-6">'.$review['name'].'</td>
                            <td class="py-4 px-6">'.$review['note'].' Stars</td>
                            <td class="py-4 px-6">'.$review['commentaire'].'</td>
                            <td class="py-4 px-6" id="status-1">'.$review['date_avis'].'</td>
                            <td class="py-4 px-6 flex space-x-4">
                                <form method="POST">
                                <button value="'.$review['id_avis'].'" name="delete" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Delete</button></form>
                            </td>
                        </tr>';
                }
            }else{
                echo 'No reviews exict';
            }
        }

        public function deleteReview($getId){
            $delete = $this->database->prepare("DELETE FROM avis WHERE id_avis = :idAvis");
            $delete->bindParam(":idAvis",$getId);
            if($delete->execute()){
                echo '<script>Location.replace("review.php")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }
    }