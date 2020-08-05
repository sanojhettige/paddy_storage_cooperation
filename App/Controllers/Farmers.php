<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Farmers extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Farmers";
        $this->view->render("farmers/index", "template", $this->data);
    }

    public function get_farmers() {
        $data = array();
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $farmer_model = $this->model->load('farmer');

        $res = $farmer_model->getFarmers($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add farmer";
        $farmer_model = $this->model->load('farmer');
        $cc_model = $this->model->load('collectionCenter');
        if(isset($_POST['submit'])) {
            $this->createOrUpdateFarmer($farmer_model);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("farmers/farmer_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update farmer";
        $farmer_model = $this->model->load('farmer');
        $cc_model = $this->model->load('collectionCenter');
        if($id > 0) {
            $this->data['record'] = $farmer_model->getFarmerById($id);
        }
        if(isset($_POST['submit'])) {
            $this->createOrUpdateFarmer($farmer_model);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("farmers/farmer_form", "template", $this->data);
    }

    private function createOrUpdateFarmer($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty($_POST["name"])) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty($_POST["collection_center"])) {
                $this->data['errors']["collection_center"] = "Collection center is required";
            } elseif(empty($_POST["address"])) {
                $this->data['errors']["address"] = "Address is required";
            } elseif(empty($_POST["nic_no"])) {
                $this->data['errors']["nic_no"] = "NIC No is required";
            } elseif(empty($_POST["phone"])) {
                $this->data['errors']["phone"] = "Phone Number is required";
            } elseif(!preg_match("/^[0]{1}[7]{1}[0-9]{8}$/", $_POST["phone"])) {
                $this->data['errors']["phone"] = "Invalid phone number format (Ex: 07xxxxxxxx)";
            } elseif(empty($_POST["land_size"])) {
                $this->data['errors']["land_size"] = "Land size is required";
            } else {
                $res = $model->createOrUpdateRecord($_POST["_id"], $_POST);
                if($res) {
                    $this->data['success_message'] = "Farmer Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save Farmer data, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function delete($id=NULL) {
        $this->data['title'] = "Delete farmer";
        $farmer_model = $this->model->load('farmer');
        if($id > 0) {
            $this->data['record'] = $farmer_model->getFarmerById($id);
        }
        if(isset($_POST['submit']) && $this->data['record']) {
            $this->doDelete($farmer_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("farmers/view_farmer", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteFarmerById($id);
            if($res) {
                $this->data['success_message'] = "Farmer successfully deleted.";
            } else {
                $this->data['error_message'] = "Unable to delete Farmer data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}