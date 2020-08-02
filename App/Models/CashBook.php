<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class CashBook extends Model {
    private $table = "collection_center_cash_book";

    function getCashRecords($limit=20, $offset=0) {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCashRecordById($id=null) {

    }

    function deleteCashRecordById($id=NULL) {

    }

    function addCashRecord($data=[]) {

    }

    function updateCashRecordById($id=NULL, $data=[]) {

    }
}