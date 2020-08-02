<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class CollectionCenters extends Controller {
    
    public function index($param=null) {
        $this->view->render("collection_centers/index", "template", $this->data);
    }

    public function get_collection_centers() {
        $data = array();
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $center_model = $this->model->load('collectionCenter');

        $res = $center_model->getCollectionCenters($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->view->render("collection_centers/cc_form", "template", $this->data);
    }

    public function edit($id=null) {
        $center_model = $this->model->load('collectionCenter');
        if($id > 0) {
            $this->data['record'] = $center_model->getCollectionCenterById($id);
        }

        if($_POST['submit']) {
            $this->createOrUpdateCC();
        }
        $this->view->render("collection_centers/cc_form", "template", $this->data);
    }

    private function createOrUpdateCC() {

    }
}