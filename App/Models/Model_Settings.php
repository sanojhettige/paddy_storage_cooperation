<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Settings extends Model {

    function getDailyPrices($start=null, $end=null) {
        $sql = "SELECT id,date,buying_price,selling_price,modified_at,paddy_category_id from paddy_prices where status = 1";

        if($start && $end) {
            $sql .=" and date between '".$start."' and '".$end."'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return $records ? $records : [];
    }

    function getPriceById($id=null) {
        $query = $this->db->prepare("SELECT * from paddy_prices where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deletePriceById($id=NULL) {
        $sql = "DELETE FROM paddy_prices WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    } 

    function createOrUpdatePrice($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `paddy_prices` SET `paddy_category_id`='".$data['paddy_category_id']."', `date`='".$data['date']."', `buying_price`= '".$data['buying_price']."' , `selling_price` = '".$data['selling_price']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO paddy_prices (paddy_category_id,date,buying_price,selling_price,created_by,created_at,modified_by,status) VALUES (:paddy_category_id, :date, :buying_price, :selling_price, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':paddy_category_id' => $data['paddy_category_id'],
                ':date' => $data['date'],
                ':buying_price' => $data['buying_price'], 
                ':selling_price' => $data['selling_price'],
                ':created_by' => $_SESSION['user_id'],
                ':created_at' => date("Y-m-d h:i:s"),
                ':modified_by' => $_SESSION['user_id'],
                ':status' => 1
            ));
        }
    }

    function priceExists($date=null, $category=NULL) {
        $query = $this->db->prepare("SELECT * from paddy_prices where date='".$date."' and paddy_category_id='".$category."'");
        $query->execute(); 
        return $query->fetch();
    }

    function getPaddyCategories($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,modified_at from paddy_categories where status = 1";

        if($search) {
            $sql .=" and name like '%".$search."%'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getCategoryById($id=null) {
        $query = $this->db->prepare("SELECT * from paddy_categories where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    public function createOrUpdateCategory($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `paddy_categories` SET `name`='".$data['name']."', `description`= '".$data['description']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO paddy_categories (name,description,created_by,created_at,modified_by,status) VALUES (:name, :description, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':name' => $data['name'],
                ':description' => $data['description'], 
                ':created_by' => $_SESSION['user_id'],
                ':created_at' => date("Y-m-d h:i:s"),
                ':modified_by' => $_SESSION['user_id'],
                ':status' => 1
            ));
        }
    }

    function deleteCategoryById($id=NULL) {
        $sql = "DELETE FROM paddy_categories WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }

    function getPaddySeasons($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,description,period from paddy_seasons";

        if($search) {
            $sql .=" and name like '%".$search."%'";
        }

        $sql .=" order by name desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getSeasonById($id=null) {
        $query = $this->db->prepare("SELECT * from paddy_seasons where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    public function createOrUpdateSeason($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `paddy_seasons` SET `name`='".$data['name']."', `period`='".$data['period']."', `description`= '".$data['description']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO paddy_seasons (name,period,description) VALUES (:name, :period, :description)") ;
            return $stm->execute(array(
                ':name' => $data['name'],
                ':period' => $data['period'],
                ':description' => $data['description']
            ));
        }
    }
    
    function deleteSeasonById($id=NULL) {
        $sql = "DELETE FROM paddy_seasons WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }

    function getVehicleTypes($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,description from vehicle_types";

        if($search) {
            $sql .=" and name like '%".$search."%'";
        }

        $sql .=" order by name desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getVehicleTypeById($id=null) {
        $query = $this->db->prepare("SELECT * from vehicle_types where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    public function createOrUpdateVehicleType($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `vehicle_types` SET `name`='".$data['name']."', `description`= '".$data['description']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO vehicle_types (name,description) VALUES (:name, :description)") ;
            return $stm->execute(array(
                ':name' => $data['name'],
                ':description' => $data['description']
            ));
        }
    }
    
    function deleteVehicleTypeById($id=NULL) {
        $sql = "DELETE FROM vehicle_types WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }

    function getPaddyRateByCategoryAndDate($date=NULL, $category=NULL) {
        $def_price = array("buying_price" => 0,"selling_price" => 0);
        $sql = "SELECT buying_price,selling_price from paddy_prices where paddy_category_id='".$category."' and date='".$date."'";
        $query = $this->db->prepare($sql);
        $query->execute(); 
        $row = $query->fetch();
        return $row ? $row : $def_price;
    }
    
}