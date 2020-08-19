<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_User extends Model {
    private $table = "users";

    function do_login($username=null, $password=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where email='".$username."'");
        $query->execute(); 
        $user = $query->fetch();

        if($user && $user["password"] === $password) {
            return $user;
        }
        return false;
    }

    function getUsers($limit=20, $offset=0, $search=null) {
        $sql = "SELECT ur.name as user_role, cc.name as collection_center, u.id,u.role_id,u.collection_center_id,u.name,u.email,u.modified_at from ".$this->table." as u ";
        $sql .=" inner join user_roles ur on ur.id = u.role_id";
        $sql .=" inner join collection_centers cc on cc.id = u.collection_center_id ";
        $sql .=" where u.status = 1";

        if($search) {
            $sql .=" and u.name like '%".$search."%' or u.email like '%".$search."%'";
        }

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and collection_center_id = ".get_assigned_center();
        }

        $sql .=" and u.id != ".get_session('user_id');

        $sql .=" order by u.modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }
    

    function getUserById($id=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deleteUserById($id=NULL) {
        $date = date("Y-m-d h:i:s");
        $sql = "UPDATE `".$this->table."` SET `status`='4', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
        return $this->db->exec($sql);
    }

    function createOrUpdateRecord($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        if($id > 0) {
            $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `collection_center_id`='".$data['collection_center']."', `name`= '".$data['name']."' , `email` = '".$data['email']."' , `password` = '".$data['password']."', `role_id` = '".$data['role_id']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (collection_center_id,name,email,role_id,password,reset_pin,created_by,created_at,modified_by,status) VALUES (:collection_center, :name, :email, :role_id, :password, :reset_pin, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':collection_center' => $data['collection_center'],
                ':name' => $data['name'], 
                ':email' => $data['email'], 
                ':role_id' => $data['role_id'], 
                ':password' => password_encrypt($data['password']),
                ':reset_pin' => rand(1111,9999),
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
                ':status' => 1
            ));
        }
    }


    function updateProfile($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        $password = password_encrypt($data['password']);
        $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `name`= '".$data['name']."', `password` = '".$password."' WHERE `id` = ".$id ;
        return $this->db->exec($sql);

    }
    
    function validPin($pin=null, $username=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where reset_pin='".$pin."' and email = '".$username."'");
        $query->execute(); 
        return $query->rowCount();
    }

    function validUser($email=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where email='".$email."'");
        $query->execute(); 
        return $query->rowCount();
    }


    function updateUserPassword($data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id = -1;
        $password = password_encrypt($data['password']);
        $center = $data['collection_center'];
        $pin = $data['pin'];
        $uname = $data['username'];
        $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `password` = '".$password."' WHERE `reset_pin` = '".$pin."' and `collection_center_id`= '".$center." 'and `email`='".$uname."'";
        return $this->db->exec($sql);
    }
}