<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Customer extends Model {
    private $table = "customers";

    function getCustomers($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,phone_number,address,company_name,modified_at,email_address from ".$this->table." where status = 1";

        if($search) {
            $sql .=" and name like '%".$search."%' or company_name like '%".$search."%' or email_address like '%".$search."%'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getCustomerById($id=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deleteCustomerById($id=NULL) {
        $date = date("Y-m-d h:i:s");
        $sql = "UPDATE `".$this->table."` SET `status`='4', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
        return $this->db->exec($sql);
    } 

    function createOrUpdateRecord($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');
        if($id > 0) {
            $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `company_name`='".$data['company_name']."', `name`= '".$data['name']."' , `address` = '".$data['address']."' , `email_address` = '".$data['email_address']."', `phone_number` = '".$data['phone']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (company_name,name,address,email_address,phone_number,created_by,created_at,modified_by,status) VALUES (:company_name, :name, :address, :email_address, :phone_number, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':company_name' => $data['company_name'],
                ':name' => $data['name'], 
                ':address' => $data['address'], 
                ':email_address' => $data['email_address'], 
                ':phone_number' => $data['phone'],
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
                ':status' => 1
            ));
        }
    }
}