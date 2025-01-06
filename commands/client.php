



<?php

    require_once '../database.php';

    class client{

        private $database;


        public function __construct($db)
        {
            $this->database = $db;
        }

        public function login($email,$password){
            $sql = "SELECT * FROM client INNER JOIN role ON client.role = role.id_role WHERE email = :email";

            $getUser = $this->database->prepare($sql);
            $getUser->bindParam(":email",$email);
            if($getUser->execute() && $getUser->rowCount() === 1){
                $user = $getUser->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $user['password']) && $user['name'] === 'client'){
                    session_start();
                    $_SESSION['id'] = $user['id_client'];
                    echo '<script>location.replace("../pages/dashboard.php")</script>';
                }else if(password_verify($password, $user['password']) && $user['name'] === 'admin'){
                    session_start();
                    $_SESSION['id'] = $user['id_client'];
                    $_SESSION['role'] = $user['name'];
                    echo '<script>location.replace("../admin/dashboard.php")</script>';
                }else{
                    echo '<script>
                        document.getElementById("email").style.border = "2px solid red";
                        document.getElementById("password").style.border = "2px solid red";
                    </script>';
                }
            }else{
                echo '<script>alert("Error try again")</script>';
            }
        }

        public function signup($email,$name,$password){
            $sql = "SELECT * FROM client WHERE email = :email";
            $checkEmail = $this->database->prepare($sql);
            $checkEmail->bindParam(":email",$email);
            if($checkEmail->execute()){
                if($checkEmail->rowCount() === 0){
                    $statut = true;
                    $addUserSql = "INSERT INTO client(nom,email,password,role,statut) VALUES(:nom,:email,:pass,2,:statut)";
                    $addUser = $this->database->prepare($addUserSql);
                    $addUser->bindParam(":nom",$name);
                    $addUser->bindParam(":email",$email);
                    $addUser->bindParam(":pass",$password);
                    $addUser->bindParam(":statut",$statut);
                    if($addUser->execute()){
                        $getUserBack = $this->database->prepare("SELECT * FROM client WHERE email = :email");
                        $getUserBack->bindParam(":email",$email);
                        if($getUserBack->execute()){
                            $getSingleUser = $getUserBack->fetch(PDO::FETCH_ASSOC);
                            $getID = $getSingleUser['id_client'];
                            session_start();
                            $_SESSION['id'] = $getID;
                            echo '<script>location.replace("../pages/dashboard.php")</script>';
                        }else{
                            echo '<script>location.replace("../login/login.php")</script>';
                        }
                        
                    }else{
                        echo '<script>alert("Error try again")</script>';
                    }
                }else{
                    echo '<script>
                        alert("Email already exict");
                    </script>';
                }
            }else{
                echo '<script>alert("Error try again")</script>';
            }
        }
    }


    
