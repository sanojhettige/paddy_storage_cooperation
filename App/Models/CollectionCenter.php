<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class CollectionCenter extends Model {
    private $table = "collection_centers";

    function getCollectionCenters($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,city,address,capacity,modified_at from ".$this->table." where status = 1";

        if($search) {
            $sql .=" and name like '%".$search."%' or address like '%".$search."%' or city like '%".$search."%'";
        }

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getCollectionCenterById($id=null) {
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deleteCollectionCenterById($id=NULL) {

    }

    function addCollectionCenter($data=[]) {

    }

    function updateCollectionCenterById($id=NULL, $data=[]) {

    }
}