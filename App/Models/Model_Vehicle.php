<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Vehicle extends Model {
    private $table = "vehicles";

    function getVehicles($limit=20, $offset=0) {
        $query = $this->db->prepare("SELECT * from ".$this->table);
        $query->execute(array(":limit" => $limit));

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getVehicleById($id=null) {

    }

    function deleteVehicleById($id=NULL) {

    }

    function addVehicle($data=[]) {

    }

    function updateVehicleById($id=NULL, $data=[]) {

    }
}