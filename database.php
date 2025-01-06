



<?php



    class database{

        private $username="root";
        private $password="";
        private $host="localhost";
        private $dbname="drive";
        protected $cnx;

        public function __construct()
        {
            $this->connection();
        }

        private function connection(){
            $this->cnx = new PDO("mysql:host={$this->host};dbname={$this->dbname}",$this->username,$this->password);
            if($this->cnx){
                return $this->cnx;
            }else{
                die();
            }
        }

        public function getConnect(){
            return $this->cnx;
        }
    }









?>