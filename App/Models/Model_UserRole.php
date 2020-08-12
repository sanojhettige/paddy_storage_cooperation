<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_UserRole extends Model {
    private $table = "user_roles";

    function getUserRoles() {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUserRoleById($id=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

}