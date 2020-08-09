<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Purchase extends Model {
    private $table = "purchases";

    function getPurchases($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,farmer_id,collection_center_id,collection_date,modified_at from ".$this->table." where status = 1";

        if($search) {
            $sql .=" and name like '%".$search."%' or address like '%".$search."%' or city like '%".$search."%'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
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