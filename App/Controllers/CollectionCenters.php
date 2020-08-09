<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class CollectionCenters extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Collection centers";
        $this->data['assets'] = array(
            'css'=>array(
                '/assets/css/datatables.min.css'
            ),
            'js'=>array(
                '/assets/js/datatables.min.js',
                '/assets/js/datatables.js'
            )
        );
        $this->view->render("collection_centers/index", "template", $this->data);
        clear_messages();
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
        $this->data['record'] = array();
        $this->data['title'] = "Add collection center";
        $center_model = $this->model->load('collectionCenter');
        if(isset($_POST['submit'])) {
            $this->createOrUpdateCC($center_model);
        }
        $this->view->render("collection_centers/cc_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update collection center";
        $center_model = $this->model->load('collectionCenter');
        if($id > 0) {
            $this->data['record'] = $center_model->getCollectionCenterById($id);
        }
        if(isset($_POST['submit'])) {
            $this->createOrUpdateCC($center_model);
        }
        $this->view->render("collection_centers/cc_form", "template", $this->data);
    }

    private function createOrUpdateCC($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty($_POST["name"])) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty($_POST["address"])) {
                $this->data['errors']["address"] = "Address is required";
            } elseif(empty($_POST["city"])) {
                $this->data['errors']["city"] = "City is required";
            } elseif(empty($_POST["phone"])) {
                $this->data['errors']["phone"] = "Phone Number is required";
            } elseif(empty($_POST["capacity"])) {
                $this->data['errors']["capacity"] = "Capacity is required";
            } else {
                $res = $model->createOrUpdateRecord($_POST["_id"], $_POST);
                if($res) {
                    $message = "Collection Center Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    header("Location: /collection-centers");
                } else {
                    $message = "Unable to save Collection Center data, please try again.";
                    $this->data['error_message'] = $message;
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function delete($id=NULL) {
        $this->data['title'] = "Delete collection center";
        $center_model = $this->model->load('collectionCenter');
        if($id > 0) {
            $this->data['record'] = $center_model->getCollectionCenterById($id);
        }
        if(isset($_POST['submit']) && $this->data['record']) {
            $this->doDelete($center_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("collection_centers/view_cc", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteCollectionCenterById($id);
            if($res) {
                $message = "Collection Center Successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: /collection-centers");
            } else {
                $this->data['error_message'] = "Unable to delete Collection Center data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}