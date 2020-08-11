<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_CollectionCenter extends Model {
    private $table = "collection_centers";

    function getCollectionCenters($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,city,address,capacity,modified_at from ".$this->table." where status = 1";

        if($search) {
            $sql .=" and name like '%".$search."%' or address like '%".$search."%' or city like '%".$search."%'";
        }

        if(get_user_role() === 4) {
            $sql .=" and id = ".get_assigned_center();
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    public function getCollectionCentersDropdownData() {
        $sql = "SELECT id,name from ".$this->table." where status = 1";

        if(get_user_role() === 4) {
            $sql .=" and id = ".get_assigned_center();
        }

        $sql .=" order by name asc";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    function getCollectionCenterById($id=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deleteCollectionCenterById($id=NULL) {
        $date = date("Y-m-d h:i:s");
        $sql = "UPDATE `".$this->table."` SET `status`='4', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
        return $this->db->exec($sql);
    } 

    function createOrUpdateRecord($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `".$this->table."` SET `name`= '".$data['name']."' , `address` = '".$data['address']."' , `city` = '".$data['city']."', `phone_number` = '".$data['phone']."', `capacity` = '".$data['capacity']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (name,address,city,phone_number,capacity,created_by,created_at,modified_by,status) VALUES (:name, :address, :city, :phone_number, :capacity, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':name' => $data['name'],
                ':address' => $data['address'], 
                ':city' => $data['city'], 
                ':phone_number' => $data['phone'],
                ':capacity' => $data['capacity'],
                ':created_by' => $_SESSION['user_id'],
                ':created_at' => date("Y-m-d h:i:s"),
                ':modified_by' => $_SESSION['user_id'],
                ':status' => 1
            ));
        }
    }
}