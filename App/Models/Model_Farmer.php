<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Farmer extends Model {
    private $table = "farmers";

    function getFarmers($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,phone_number,address,nic_no,land_size,modified_at from ".$this->table." where status = 1";

        if($search) {
            $sql .=" and name like '%".$search."%' or address like '%".$search."%' or city like '%".$search."%'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getFarmerById($id=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deleteFarmerById($id=NULL) {
        $sql = "DELETE FROM ".$this->table." WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    } 

    function createOrUpdateRecord($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `".$this->table."` SET `collection_center_id`='".$data['collection_center']."', `name`= '".$data['name']."' , `address` = '".$data['address']."' , `nic_no` = '".$data['nic_no']."', `phone_number` = '".$data['phone']."', `land_size` = '".$data['land_size']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (collection_center_id,name,address,nic_no,phone_number,land_size,created_by,created_at,modified_by,status) VALUES (:collection_center, :name, :address, :nic_no, :phone_number, :land_size, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':collection_center' => $data['collection_center'],
                ':name' => $data['name'], 
                ':address' => $data['address'], 
                ':nic_no' => $data['nic_no'], 
                ':phone_number' => $data['phone'],
                ':land_size' => $data['land_size'],
                ':created_by' => $_SESSION['user_id'],
                ':created_at' => date("Y-m-d h:i:s"),
                ':modified_by' => $_SESSION['user_id'],
                ':status' => 1
            ));
        }
    }
}