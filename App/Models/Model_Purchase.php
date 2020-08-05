<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Purchase extends Model {
    private $table = "purchases";

    function getPurchases($limit=20, $offset=0) {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPurchaseById($id=null) {

    }

    function deletePurchaseById($id=NULL) {

    }

    function addPurchase($data=[]) {

    }

    function updatePurchaseById($id=NULL, $data=[]) {

    }
}