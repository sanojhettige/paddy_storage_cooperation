<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class UserRole extends Model {
    private $table = "user_roles";

    function getUserRoles($limit=20, $offset=0) {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getUserRoleById($id=null) {

    }

}