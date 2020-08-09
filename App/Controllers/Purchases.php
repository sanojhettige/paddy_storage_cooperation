<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Purchases extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Purcahses";
        $this->data['assets'] = array(
            'css'=>array(
                '/assets/css/datatables.min.css'
            ),
            'js'=>array(
                '/assets/js/datatables.min.js',
                '/assets/js/datatables.js'
            )
        );
        $this->view->render("purchases/index", "template", $this->data);
        clear_messages();
    }

    public function get_purchases() {
        $data = array();
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $purchase_model = $this->model->load('purchase');

        $res = $purchase_model->getPurchases($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add purchase";

        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                '/assets/js/purchases.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );


        $purchase_model = $this->model->load('purchase');
        $cc_model = $this->model->load('collectionCenter');
        $farmer_model = $this->model->load('farmer');
        $settings_model = $this->model->load('settings');
        if(isset($_POST['submit'])) {
            $this->createOrUpdatePurcahse($purchase_model);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['farmers'] = $farmer_model->getFarmerDropdownData();
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->view->render("purchases/purchase_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update purchase";
        $purchase_model = $this->model->load('purchase');
        $cc_model = $this->model->load('collectionCenter');
        $settings_model = $this->model->load('settings');
        $farmer_model = $this->model->load('farmer');
        if($id > 0) {
            $this->data['record'] = $purchase_model->getPurcahseById($id);
        }
        if(isset($_POST['submit'])) {
            $this->createOrUpdateFarmer($farmer_model);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['farmers'] = $farmer_model->getFarmerDropdownData();
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->view->render("purchases/purchase_form", "template", $this->data);
    }

    private function createOrUpdatePurcahse($model=null) {
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
                    $message = "Farmer Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    header("Location: /farmers");
                } else {
                    $this->data['error_message'] = "Unable to save Farmer data, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function delete($id=NULL) {
        $this->data['title'] = "Delete purchase";
        $purchase_model = $this->model->load('purchase');
        if($id > 0) {
            $this->data['record'] = $purchase_model->getPurchaseById($id);
        }
        if(isset($_POST['submit']) && $this->data['record']) {
            $this->doDelete($purchase_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("purchases/view_farmer", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deletePurcahseById($id);
            if($res) {
                $message = "Purchase successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: /purchases");
            } else {
                $this->data['error_message'] = "Unable to delete purchase data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}