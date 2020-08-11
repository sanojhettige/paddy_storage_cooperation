<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Vehicle extends Model {
    private $table = "vehicles";

    function getVehicles($limit=20, $offset=0) {
        $sql = "SELECT v.id,vt.name as vehicle_type,v.registration_number as reg_no,v.modified_at from ".$this->table." v ";
        
        $sql .=" left join vehicle_types vt on vt.id = v.vehicle_type";
        $sql .= " where v.status = 1";

        if($search) {
            $sql .=" and v.vehicle_type like '%".$search."%' or v.registration_number like '%".$search."%'";
        }

        $sql .=" order by v.modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getVehicleById($id=null) {
        $query = $this->db->prepare("SELECT v.*, vt.name as vehicle_type from ".$this->table." v left join vehicle_types vt on vt.id = v.vehicle_type where v.id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deleteVehicleById($id=NULL) {
        $date = date("Y-m-d h:i:s");
        $sql = "UPDATE `".$this->table."` SET `status`='4', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
        return $this->db->exec($sql);
    }

    function createOrUpdateRecord($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `".$this->table."` SET `vehicle_type`='".$data['vehicle_type']."', `registration_number`= '".$data['registration_number']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (vehicle_type,registration_number,created_by,created_at,modified_by,status) VALUES (:vehicle_type, :registration_number, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':vehicle_type' => $data['vehicle_type'],
                ':registration_number' => $data['registration_number'],
                ':created_by' => $_SESSION['user_id'],
                ':created_at' => date("Y-m-d h:i:s"),
                ':modified_by' => $_SESSION['user_id'],
                ':status' => 1
            ));
        }
    }
}