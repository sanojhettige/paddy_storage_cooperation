<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Transfers extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Transfers";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("transfers/index", "template", $this->data);
        clear_messages();
    }

    public function get_transfers() {
        $data = array();
        $transfers = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $transfer_model = $this->model->load('transfer');
        $cc_model = $this->model->load('collectionCenter');

        $res = $transfer_model->getTransfers($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;

        $editable = is_permitted('transfers-edit');
        $deletable = is_permitted('transfers-delete');


        foreach($res["data"] as $index=>$transfer) {
            $transfers[$index]['id'] = $transfer['id'];
            $transfers[$index]['transfer_date'] = $transfer['transfer_date'];
            $transfers[$index]['modified_at'] = $transfer['modified_at'];
            $transfers[$index]['from_center'] = $cc_model->getCollectionCenterById($transfer['from_center_id'])["name"];
            $transfers[$index]['to_center'] = $cc_model->getCollectionCenterById($transfer['to_center_id'])["name"];
            $transfers[$index]['transfer_status'] = sale_status($transfer['transfer_status_id']);
            $purchases[$index]['delete'] = $deletable;
            $purchases[$index]['edit'] = $editable;
            $purchases[$index]['pay'] = $payable;
        }
        $data["data"] = $transfers;
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add transfer";

        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/transfers.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );


        $transfer_model = $this->model->load('transfer');
        $cc_model = $this->model->load('collectionCenter');
        $farmer_model = $this->model->load('farmer');
        $settings_model = $this->model->load('settings');
        if($_POST) {
            $this->createOrUpdateTransfer($transfer_model);
        }

        $this->data['record']['items'] = $this->defaultItem(null);

        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['farmers'] = $farmer_model->getFarmerDropdownData();
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->view->render("transfers/transfer_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update transfer";

        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/transfers.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );

        $transfer_model = $this->model->load('transfer');
        $cc_model = $this->model->load('collectionCenter');
        $settings_model = $this->model->load('settings');
        $farmer_model = $this->model->load('farmer');
        $vehicle_model = $this->model->load('vehicle');
        
        if($id > 0) {
            $this->data['record'] = $transfer_model->getTransferById($id);
        }
        if($_POST) {
            $this->createOrUpdateTransfer($transfer_model);
        }

        if(count($this->data['record']['items']) <= 0) {
            $this->data['record']['items'] = $this->defaultItem($this->data['record']['id']);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['farmers'] = $farmer_model->getFarmerDropdownData();
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->data['vehicles'] = $vehicle_model->getVehicles(100,0,null)['data'];
        $this->view->render("transfers/transfer_form", "template", $this->data);
    }

    private function defaultItem($id) {
        return array(array(
            'id'=>null,
            'transfer_id'=>$id,
            'paddy_category_id'=>null,
            'collected_amount'=>0,
            'collected_rate'=>0,
            'notes'=>''
        ));
    }

    private function createOrUpdateTransfer($model=null) {
        $data = array();
        $data['errors'] = array();
        $data['purchase'] = null;
        try {
            if(empty(get_post("from_center_id"))) {
                $data['errors']["from_center_id"] = "From center is required";
            } elseif(empty(get_post("to_center_id"))) {
                $data['errors']["to_center_id"] = "To center is required";
            } elseif(get_post("to_center_id") > 0 && get_post("to_center_id") === get_post("from_center_id")) {
                $data['errors']["to_center_id"] = "From and To center must be different.";
            } elseif(empty(get_post("transfer_date"))) {
                $data['errors']["transfer_date"] = "Date is required";
            } elseif(empty(get_post("status_id"))) {
                $data['errors']["status_id"] = "Transfer status is required";
            } elseif(empty(get_post("item")) || !is_array(get_post('item'))) {
                $data['errors']["item"] = "Add one or more items";
            } else {
                $res = $model->createOrUpdateRecord(get_post("_id"), $_POST);
                if($res) {
                    $message = "Transfer Successfully saved.";
                    $data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    $data['success'] = 1;
                    $data['error'] = 0;
                    $data['purchase'] = $res;
                } else {
                    $data['errors']['form_error'] = "Unable to save data, please try again.";
                    $data['success'] = 0;
                    $data['error'] = 1;
                }
            }
        } catch(Exception $e) {
            $data['errors']['form_error'] = $e;
            $data['success'] = 0;
            $data['error'] = 1;
        }

        if(count($data['errors']) > 0) {
            $data['success'] = 0;
            $data['error'] = 1;
        }
        echo json_encode($data);
        exit;
    }


    public function delete($id=NULL) {
        $this->data['title'] = "Delete transfer";
        $transfer_model = $this->model->load('transfer');
        if($id > 0) {
            $this->data['record'] = $transfer_model->getTransferById($id);
        }
        if(get_post('submit') && $this->data['record']) {
            $this->doDelete($transfer_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("transfers/view_transfer", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteTransferById($id);
            if($res) {
                $message = "Transfer successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: ".BASE_URL."/transfers");
            } else {
                $this->data['error_message'] = "Unable to delete transfer data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}