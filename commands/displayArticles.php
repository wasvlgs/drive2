


<?php






    class article{
        private $database;
        private $id_article;
        private $id_client;
        private $id_them;
        private $titre;
        private $content;
        private $tags;

        public function __construct($db)
        {
            $this->database = $db;
        }



        public function afficherResult(){
            $getData = $this->database->prepare("SELECT * FROM article INNER JOIN client ON article.id_client = client.id_client WHERE is_approved = true");
            if($getData->execute()){
                return $getData->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return [];
            }
        }


        public function get_Themes(){
            $getThem = $this->database->prepare("SELECT * FROM them");
            if($getThem->execute()){
                foreach($getThem as $option){
                    echo '<option value="'.$option['id_them'].'">'.$option['name'].'</option>';
                }
            }
        }

        public function ajouterArticle($titre, $content, $img, $them, $tags, $id_client) {
            $this->titre = $titre;
            $this->content = $content;
            $this->id_them = $them;
            $this->tags = array_map('trim', explode(',', $tags));
            $this->id_client = $id_client;
        
            if (!$img['name'] || !$img['tmp_name'] || !move_uploaded_file($img['tmp_name'], "../img/imgArticles/" . $img['name'])) {
                echo '<script>alert("File upload failed")</script>';
                return;
            }
        
            $addArticle = $this->database->prepare("INSERT INTO article(title, content, date_create, id_client, is_approved, id_them, imgSrc)
                                                    VALUES(:titre, :content, CURRENT_DATE, :id_client, 0, :id_them, :img)");
        
            $addArticle->bindValue(":titre", $this->titre);
            $addArticle->bindValue(":content", $this->content);
            $addArticle->bindValue(":id_client", $this->id_client);
            $addArticle->bindValue(":id_them", $this->id_them);
            $addArticle->bindValue(":img", $img['name']);
        
            if ($addArticle->execute()) {
                $getArticleId = $this->database->lastInsertId();
        
                foreach ($this->tags as $tag) {
                    $checkTag = $this->database->prepare("SELECT id_tag FROM tag WHERE name = :name");
                    $checkTag->bindValue(":name", $tag);
                    $checkTag->execute();
        
                    if ($checkTag->rowCount() == 0) {
                        $addTag = $this->database->prepare("INSERT INTO tag(name) VALUES(:name)");
                        $addTag->bindValue(":name", $tag);
                        $addTag->execute();
                        $getTagId = $this->database->lastInsertId();
                    } else {
                        $tagData = $checkTag->fetch(PDO::FETCH_ASSOC);
                        $getTagId = $tagData['id_tag'];
                    }
        
                    $addAssoc = $this->database->prepare("INSERT INTO tag_article(id_article, id_tag) VALUES(:articleId, :tagId)");
                    $addAssoc->bindValue(":articleId", $getArticleId);
                    $addAssoc->bindValue(":tagId", $getTagId);
                    $addAssoc->execute();
                }
        
                echo '<script>alert("Article added successfully")</script>';
            } else {
                echo '<script>alert("Error: Try again")</script>';
            }
        }
        

        public function getArticleDetails($getID){
            $this->id_article = $getID;
            $getArticle = $this->database->prepare("SELECT * FROM article WHERE id_article = :getID AND is_approved = '1'");
            $getArticle->bindParam(":getID",$this->id_article);
            if($getArticle->execute()){
                return $getArticle->fetch(PDO::FETCH_ASSOC);
            }else{
                return [];
            }
        }

        public function getTages($getID){
            $this->id_article = $getID;
            $getTags = $this->database->prepare("SELECT * FROM tag_article INNER JOIN tag ON tag_article.id_tag = tag.id_tag WHERE id_article = :getID");
            $getTags->bindParam(":getID",$this->id_article);
            if($getTags->execute() && $getTags->rowCount() > 0){
                return $getTags->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return [];
            }
        }

        



    }