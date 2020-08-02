<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Transfer extends Model {
    private $table = "transfers";

    function getTransfers($limit=20, $offset=0) {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getTransferById($id=null) {

    }

    function deleteTransferById($id=NULL) {

    }

    function addTransfer($data=[]) {

    }

    function updateTransferById($id=NULL, $data=[]) {

    }
}