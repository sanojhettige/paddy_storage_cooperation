<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Farmers extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Farmers";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("farmers/index", "template", $this->data);
        clear_messages();
    }

    public function get_farmers() {
        $data = array();
        $farmers = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $farmer_model = $this->model->load('farmer');

        $res = $farmer_model->getFarmers($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        
        $editable = is_permitted('farmers-edit');
        $deletable = is_permitted('farmers-delete');

        foreach($res["data"] as $index=>$item) {
            $farmers[$index]['id'] = $item['id'];
            $farmers[$index]['name'] = $item['name'];
            $farmers[$index]['nic_no'] = $item['nic_no'];
            $farmers[$index]['phone_number'] = $item['phone_number'];
            $farmers[$index]['land_size'] = $item['land_size'];
            $farmers[$index]['modified_at'] = $item['modified_at'];
            $farmers[$index]['delete'] = $deletable;
            $farmers[$index]['edit'] = $editable;
        }
        $data["data"] = $farmers;

        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add farmer";
        $farmer_model = $this->model->load('farmer');
        $cc_model = $this->model->load('collectionCenter');
        if(get_post('submit')) {
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
        if(get_post('submit')) {
            $this->createOrUpdateFarmer($farmer_model);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("farmers/farmer_form", "template", $this->data);
    }

    private function createOrUpdateFarmer($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty(get_post("collection_center"))) {
                $this->data['errors']["collection_center"] = "Collection center is required";
            } elseif(empty(get_post("address"))) {
                $this->data['errors']["address"] = "Address is required";
            } elseif(empty(get_post("nic_no"))) {
                $this->data['errors']["nic_no"] = "NIC No is required";
            } elseif(empty(get_post("phone"))) {
                $this->data['errors']["phone"] = "Phone Number is required";
            } elseif(!preg_match("/^[0]{1}[7]{1}[0-9]{8}$/", get_post("phone"))) {
                $this->data['errors']["phone"] = "Invalid phone number format (Ex: 07xxxxxxxx)";
            } elseif(empty(get_post("land_size"))) {
                $this->data['errors']["land_size"] = "Land size is required";
            } else {
                $res = $model->createOrUpdateRecord(get_post("_id"), $_POST);
                if($res) {
                    $message = "Farmer Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    header("Location: ".BASE_URL."/farmers");
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
        if(get_post('submit') && $this->data['record']) {
            $this->doDelete($farmer_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("farmers/view_farmer", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteFarmerById($id);
            if($res) {
                $message = "Farmer successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: ".BASE_URL."/farmers");
            } else {
                $this->data['error_message'] = "Unable to delete Farmer data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}