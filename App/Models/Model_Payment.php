<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Payment extends Model {
    private $table = "payments";

    function getPayments($limit=20, $offset=0) {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPaymentById($id=null) {

    }

    function deletePaymentById($id=NULL) {

    }

    function addPayment($data=[]) {

    }

    function updatePaymentById($id=NULL, $data=[]) {

    }
}