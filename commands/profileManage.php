

<?php








    class manageProfile{

        private $database;
        private $idClient;

        public function __construct($db, $getId)
        {
            $this->database = $db;
            $this->idClient = $getId;
        }


        public function updatePassword($getOld, $getNew){

            $check = $this->database->prepare("SELECT * FROM client WHERE id_client = :getID");
            $check->bindParam(":getID",$this->idClient);
            if($check->execute() && $check->rowCount() === 1){
                $userCheck = $check->fetch(PDO::FETCH_ASSOC);
                if(password_verify($getOld,$userCheck['password'])){
                    $editPassword = $this->database->prepare("UPDATE client SET password = :getNew WHERE id_client = :getID");
                    $editPassword->bindParam(":getNew",$getNew);
                    $editPassword->bindParam(":getID",$userCheck['id_client']);
                    if($editPassword->execute()){
                        echo '<script>alert("Password updated successfuly!")</script>';
                    }else{
                        echo '<script>alert("Error try again!")</script>';
                    }
                }else{
                    echo '<script>alert("Invalid information!")</script>';
                }
            }
        }
    }