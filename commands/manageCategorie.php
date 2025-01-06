<?php









    class manageCategories{

        private $database;

        public function __construct($db)
        {
            $this->database = $db;
        }

        public function getCategorie(){
            $getCategorie = $this->database->prepare("SELECT * FROM categorie");
            if($getCategorie->execute() && $getCategorie->rowCount() > 0){
                foreach($getCategorie as $item){
                   echo '<tr>
                            <td class="py-4 px-6">'.$item['nom'].'</td>
                            <td class="py-4 px-6">'.$item['description'].'</td>
                            <td class="py-4 px-6 flex space-x-4">
                                <form method="POST"><button type="button" onclick="showEditModal(`'.$item['nom'].'`, `'.$item['description'].'`,'.$item['id_categorie'].')" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-500">Modify</button>
                                <button value="'.$item['id_categorie'].'" name="delete" type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Delete</button></form>
                            </td>
                        </tr>'; 
                }
                
            }else{
                echo 'No categorie exict!';
            }
        }

        public function editCategorie($name,$desc,$id){
            $updateCategorie = $this->database->prepare("UPDATE categorie SET nom = :nom, description = :desc WHERE id_categorie = :getId");
            $updateCategorie->bindParam("nom",$name);
            $updateCategorie->bindParam("desc",$desc);
            $updateCategorie->bindParam("getId",$id);
            if($updateCategorie->execute()){
                echo '<script>location.replace("categorie.php")</script>';
            }else{
                echo '<script>alert("Invalid information!")</script>';
            }
        }

        public function removeCategorie($getid){
            $deleteCategorie = $this->database->prepare("DELETE FROM categorie WHERE id_categorie = :getID");
            $deleteCategorie->bindParam(":getID",$getid);
            if($deleteCategorie->execute()){
                echo '<script>location.replace("categorie.php")</script>';
            }else{
                echo '<script>alert("Invalid information!")</script>';
            }
        }

        public function addCategorie($name,$desc){
            $addCategorie = $this->database->prepare("INSERT INTO categorie(nom,description)
             VALUES(:name,:desc)");
             $addCategorie->bindParam(":name",$name);
             $addCategorie->bindParam(":desc",$desc);
            if($addCategorie->execute()){
                echo '<script>location.replace("categorie.php")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }
    }