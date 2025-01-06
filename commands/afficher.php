<?php




class VehiculePagination
{
    private $db;
    // private $limit;
    // private $offset;
    private $currentPage;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    // private function setPagination()
    // {
    //     if (isset($_GET['page']) && !empty($_GET['page'])) {
    //         $this->currentPage = htmlspecialchars($_GET['page']);
    //         $this->offset = ($this->currentPage - 1) * $this->limit;
    //     } else {
    //         $this->currentPage = 1;
    //         $this->offset = 0;
    //     }
    // }

    public function getVehicules($limit,$offset,$getFilter)
    {
        $sql = '';
        $getRows = '';
        if($getFilter){
            $sql = $this->db->prepare("SELECT * FROM vehicule where id_categorie = :getID  LIMIT :limit OFFSET :offset");
            $sql->bindParam(":getID",$getFilter);
            $getRows = $this->db->prepare("SELECT COUNT(*) AS result FROM vehicule where id_categorie = :getID");
            $getRows->bindParam(":getID",$getFilter);

        }else{
            $sql = $this->db->prepare("SELECT * FROM vehicule LIMIT :limit OFFSET :offset");
            $getRows = $this->db->prepare("SELECT COUNT(*) AS result FROM vehicule");
        }
        $sql->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sql->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sql->execute();

        $getRows->execute();
        $getRowCount = $getRows->fetch(PDO::FETCH_ASSOC)['result'];
        $totalPages = ceil($getRowCount / $limit);

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        return [
            'getData' => $data,
            'totalPages' => $totalPages,
            'currentPage' => $this->currentPage
        ];
    }


    public function getCategories(){
        $getCategories = $this->db->prepare("SELECT * FROM categorie");
        if($getCategories->execute() && $getCategories->rowCount() > 0){
            foreach($getCategories as $categorie){
                echo '<option value="'.$categorie['id_categorie'].'">'.$categorie['nom'].'</option>';
            }
        }
    }
}

// require_once '../database.php';

// $conn = new database();
// $db = $conn->getConnect();


// $pagination = new VehiculePagination($db);


// $response = $pagination->getVehicules();
// echo json_encode($response);
