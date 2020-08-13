<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class CollectionCenters extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Collection centers";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("collection_centers/index", "template", $this->data);
        clear_messages();
    }

    public function get_collection_centers() {
        $data = array();
        $ccs = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $center_model = $this->model->load('collectionCenter');

        $res = $center_model->getCollectionCenters($limit,$offset, $search);
        $editable = is_permitted('collection-centers-edit');
        $deletable = is_permitted('collection-centers-delete');
        $viewable = is_permitted('collection-centers-view');

        foreach($res["data"] as $index=>$center) {
            $ccs[$index]['id'] = $center['id'];
            $ccs[$index]['name'] = $center['name'];
            $ccs[$index]['city'] = $center['city'];
            $ccs[$index]['address'] = $center['address'];
            $ccs[$index]['capacity'] = $center['capacity'];
            $ccs[$index]['modified_at'] = $center['modified_at'];
            $ccs[$index]['edit'] = $editable;
            $ccs[$index]['delete'] = $deletable;
            $ccs[$index]['view'] = $viewable;
        }

        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        $data["data"] = $ccs;
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add collection center";
        $center_model = $this->model->load('collectionCenter');
        if(get_post('submit')) {
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
        if(get_post('submit')) {
            $this->createOrUpdateCC($center_model);
        }
        $this->view->render("collection_centers/cc_form", "template", $this->data);
    }

    private function createOrUpdateCC($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty(get_post("address"))) {
                $this->data['errors']["address"] = "Address is required";
            } elseif(empty(get_post("city"))) {
                $this->data['errors']["city"] = "City is required";
            } elseif(empty(get_post("phone"))) {
                $this->data['errors']["phone"] = "Phone Number is required";
            } elseif(empty(get_post("capacity"))) {
                $this->data['errors']["capacity"] = "Capacity is required";
            } else {
                $res = $model->createOrUpdateRecord(get_post("_id"), $_POST);
                if($res) {
                    $message = "Collection Center Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    header("Location: ".BASE_URL."/collection-centers");
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
        if(get_post('submit') && $this->data['record']) {
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
                header("Location: ".BASE_URL."/collection-centers");
            } else {
                $this->data['error_message'] = "Unable to delete Collection Center data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function view($id=NULL) {
        $this->data['title'] = "View collection center";
        $center_model = $this->model->load('collectionCenter');
        if($id > 0) {
            $this->data['record'] = $center_model->getCollectionCenterById($id);
        }
        
        $this->view->render("collection_centers/view_cc", "template", $this->data);
    }
}