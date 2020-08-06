<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Permission extends Model {
    private $table = "permissions";

    function getIsPermittedByRole($permission=null, $role_id=null) {
        $query = $this->db->prepare("SELECT `".$permission."` from ".$this->table." where role_id='".$role_id."'");
        $query->execute(); 
        $row =  $query->fetch();
        return ($row[$permission] === 1) ? true: false;
    }

}