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

    function getUsers($limit=20, $offset=0) {
        $query = $this->db->query("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    function getUserById($id=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deleteUserById($id=NULL) {

    }

    function addUser($data=[]) {

    }

    function updateUserById($id=NULL, $data=[]) {

    }
}