<?php







    class manageVehicle{
        private $database;

        public function __construct($db)
        {
            $this->database = $db;
        }


        public function getCategories(){
            $getCategories = $this->database->prepare("SELECT * FROM categorie");
            if($getCategories->execute() && $getCategories->rowCount() > 0){
                foreach($getCategories as $categorie){
                    echo '<option value="'.$categorie['id_categorie'].'">'.$categorie['nom'].'</option>';
                }
            }
        }
        public function addVehicle($Name,$modele,$categorie,$price,$type,$img){
            $addVehicle = $this->database->prepare("INSERT INTO vehicule(name,modele,prix,disponibilite,id_categorie,imgSrc)
             VALUES(:name,:modele,:prix,:disponibilite,:idcategorie,:imgSrc)
            ");
            $addVehicle->bindParam(":name",$Name);
            $addVehicle->bindParam(":modele",$modele);
            $addVehicle->bindParam(":prix",$price);
            $addVehicle->bindParam(":disponibilite",$type);
            $addVehicle->bindParam(":idcategorie",$categorie);
            $addVehicle->bindParam(":imgSrc",$img['name']);

            if(move_uploaded_file($img['tmp_name'], '../img/imgPages/'.$img['name']) && $addVehicle->execute()){
                echo '<script>location.replace("vehicules.php")</script>';
            }else{
                echo '<script>alert("Faild to add vehicle")</script>';
            }
        }

        public function showVehicle(){
            $getVehicle = $this->database->prepare("SELECT * FROM vehicule INNER JOIN categorie ON vehicule.id_categorie = categorie.id_categorie");
            if($getVehicle->execute() && $getVehicle->rowCount() > 0){
                foreach($getVehicle as $item){
                    $getType = '';
                    if($item['disponibilite'] == 1){
                        $getType = "Available";
                    }else if($item['disponibilite'] == 0){
                        $getType = "Not available";
                    }
                    echo '<tr>
                            <td class="py-4 px-6">'.$item['name'].'</td>
                            <td class="py-4 px-6">'.$item['nom'].'</td>
                            <td class="py-4 px-6">$'.$item['prix'].'</td>
                            <td class="py-4 px-6">'.$getType.'</td>
                            <td class="py-4 px-6 flex space-x-4">
                                <form method="POST"><button type="button" onclick="openEditModal(`'.$item['name'].'`, `'.$item['modele'].'`, '.$item['id_categorie'].', '.$item['prix'].','.$item['disponibilite'].','.$item['id_vehicule'].')" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-500">Modify</button>
                                <button value="'.$item['id_vehicule'].'" name="delete" type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-500">Delete</button></form>
                            </td>
                        </tr>';
                }
            }else{
                echo 'No vehicle exict';
            }
        }

        public function editVehicle($Name,$modele,$categorie,$price,$type,$id){
            $editVehicle = $this->database->prepare("UPDATE vehicule SET name = :name , modele = :modele , prix = :prix , disponibilite = :type , id_categorie = :categorie WHERE id_vehicule = :getID");
            $editVehicle->bindParam(":name",$Name);
            $editVehicle->bindParam(":modele",$modele);
            $editVehicle->bindParam(":prix",$price);
            $editVehicle->bindParam(":type",$type);
            $editVehicle->bindParam(":categorie",$categorie);
            $editVehicle->bindParam(":getID",$id);
            if($editVehicle->execute()){
                echo '<script>Location.replace("vehicules.php")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }

        public function removeVehicle($getID){
            $remove = $this->database->prepare("DELETE FROM vehicule WHERE id_vehicule = :getID");
            $remove->bindParam(":getID",$getID);
            if($remove->execute()){
                echo '<script>Location.replace("vehicules.php")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }
    }