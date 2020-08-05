<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Sale extends Model {
    private $table = "sales";

    function getSales($limit=20, $offset=0) {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getSaleById($id=null) {

    }

    function deleteSaleById($id=NULL) {

    }

    function addSale($data=[]) {

    }

    function updateSaleById($id=NULL, $data=[]) {

    }
}