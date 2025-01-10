

<?php




    class comment{

        private $db;
        private $id_comment;
        private $content;
        private $id_article;
        private $id_client;

        public function __construct($database)
        {
            $this->db = $database;
        }


        public function addComment($content,$client,$article){

            $this->content = $content;
            $this->id_client = $client;
            $this->id_article = $article;

            $addComment = $this->db->prepare("INSERT INTO comment(content,date_create,id_client,id_article)
             VALUES(:content,CURRENT_DATE, :client,:article)");
            $addComment->bindParam(":content",$this->content);
            $addComment->bindParam(":client",$this->id_client);
            $addComment->bindParam(":article",$this->id_article);
            if($addComment->execute()){
                echo '<script>location.replace("article.php?article='.$this->id_article.'")</script>';
            }else{
                echo '<script>alert("Faild to add comment, try again!")</script>';
            }
        }


        public function getComments($article){
            $this->id_article = $article;
            $getComments = $this->db->prepare("SELECT * FROM comment INNER JOIN client ON comment.id_client = client.id_client WHERE id_article = :article");
            $getComments->bindParam(":article",$this->id_article);
            if($getComments->execute() && $getComments->rowCount() > 0){
                return $getComments;
            }else{
                return null;
            }
        }

        public function editComment($getID,$content){
            $this->id_comment = $getID;
            $this->content = $content;

            $editComment = $this->db->prepare("UPDATE comment SET content = :content WHERE id_comment = :getID");
            $editComment->bindParam(":content",$content);
            $editComment->bindParam(":getID",$getID);
            if($editComment->execute()){
                echo '<script>location.replace("article.php?article='.$this->id_article.'")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }
        }

        public function removeComment($getID){
            $this->id_comment = $getID;
            $removeComment = $this->db->prepare("DELETE FROM comment WHERE id_comment = :getID");
            $removeComment->bindParam(":getID",$getID);
            if($removeComment->execute()){
                echo '<script>location.replace("article.php?article='.$this->id_article.'")</script>';
            }else{
                echo '<script>alert("Error try again!")</script>';
            }

        }
    }