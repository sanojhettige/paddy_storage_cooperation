<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Purchases extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Purchases";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("purchases/index", "template", $this->data);
        clear_messages();
    }

    public function get_purchases() {
        $data = array();
        $purchases = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $purchase_model = $this->model->load('purchase');

        $res = $purchase_model->getPurchases($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;

        $editable = is_permitted('purchases-edit');
        $deletable = is_permitted('purchases-delete');
        $payable = is_permitted('purchases-pay');

        foreach($res["data"] as $index=>$item) {

            $isPaid = $purchase_model->getPayOrderByPurchaseId($item['id']);
            $purchases[$index]['id'] = $item['id'];
            $purchases[$index]['farmer_name'] = $item['farmer_name'];
            $purchases[$index]['collection_center'] = $item['collection_center'];
            $purchases[$index]['collection_date'] = $item['collection_date'];
            $purchases[$index]['is_paid'] = $isPaid ? "Yes": "No";
            $purchases[$index]['delete'] = !$isPaid && $deletable;
            $purchases[$index]['edit'] = !$isPaid && $editable;
            $purchases[$index]['pay'] = !$isPaid && $payable;
        }

        $data["data"] = $purchases;
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
                BASE_URL.'/assets/js/purchases.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );


        $purchase_model = $this->model->load('purchase');
        $cc_model = $this->model->load('collectionCenter');
        $farmer_model = $this->model->load('farmer');
        $settings_model = $this->model->load('settings');
        if($_POST) {
            $this->createOrUpdatePurcahse($purchase_model);
        }

        $this->data['record']['items'] = $this->defaultItem(null);

        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['farmers'] = $farmer_model->getFarmerDropdownData();
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->view->render("purchases/purchase_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update purchase";

        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/purchases.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );

        $purchase_model = $this->model->load('purchase');
        $cc_model = $this->model->load('collectionCenter');
        $settings_model = $this->model->load('settings');
        $farmer_model = $this->model->load('farmer');
        
        if($id > 0) {
            $this->data['record'] = $purchase_model->getPurchaseById($id);
        }
        if($_POST) {
            $this->createOrUpdatePurcahse($purchase_model);
        }

        if(count($this->data['record']['items']) <= 0) {
            $this->data['record']['items'] = $this->defaultItem($this->data['record']['id']);
        }
        // print_r($this->data['record']);exit;
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['farmers'] = $farmer_model->getFarmerDropdownData();
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->view->render("purchases/purchase_form", "template", $this->data);
    }

    private function defaultItem($id) {
        return array(array(
            'id'=>null,
            'purchase_id'=>$id,
            'paddy_category_id'=>null,
            'collected_amount'=>0,
            'collected_rate'=>0,
            'notes'=>''
        ));
    }

    private function createOrUpdatePurcahse($model=null) {
        $data = array();
        $data['errors'] = array();
        $data['purchase'] = null;
        try {
            if(empty(get_post("farmer_id"))) {
                $data['errors']["farmer_id"] = "Farmer is required";
            } elseif(empty(get_post("collection_center_id"))) {
                $data['errors']["collection_center_id"] = "Collection center is required";
            } elseif(empty(get_post("collection_date"))) {
                $data['errors']["collection_date"] = "Date is required";
            } elseif(empty(get_post("item")) || !is_array(get_post('item'))) {
                $data['errors']["item"] = "Add one or more items";
            } else {
                $res = $model->createOrUpdateRecord(get_post("_id"), $_POST);
                if($res) {
                    $message = "Purchase Successfully saved.";
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
        $this->data['title'] = "Delete purchase";
        $purchase_model = $this->model->load('purchase');
        if($id > 0) {
            $this->data['record'] = $purchase_model->getPurchaseById($id);
        }
        if(get_post('submit') && $this->data['record']) {
            $this->doDelete($purchase_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("purchases/view_purchase", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deletePurchaseById($id);
            if($res) {
                $message = "Purchase successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: ".BASE_URL."/purchases");
            } else {
                $this->data['error_message'] = "Unable to delete purchase data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }

    public function daily_prices() {
        $this->data['title'] = "Daily Prices";
        $settings_model = $this->model->load('settings');
        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/dailyPrices.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
                BASE_URL.'/assets/css/fullcalendar.css'
            )
        );
        $this->view->render("settings/daily_prices_calendar", "template", $this->data);
    }

    public function pay($id=NULL) {
        $this->data['title'] = "Pay Order";
        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/purchases.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );

        $purchase_model = $this->model->load('purchase');
        $cc_model = $this->model->load('collectionCenter');
        $settings_model = $this->model->load('settings');
        $farmer_model = $this->model->load('farmer');
        
        if($id > 0) {
            $this->data['record'] = $purchase_model->getPurchaseById($id);
        }
        if($_POST) {
            $this->createOrUpdatePayOrder($purchase_model, $this->data['record']);
        }

        if(count($this->data['record']['items']) <= 0) {
            $this->data['record']['items'] = $this->defaultItem($this->data['record']['id']);
        }
        $this->data['pay_order'] = $purchase_model->getPayOrderByPurchaseId($id);
        
        if($_GET['print']) {
            $this->view->render("purchases/print_pay_order", "print_template", $this->data);
        } else {
            $this->view->render("purchases/pay_form", "template", $this->data);
        }
        
    }

    private function createOrUpdatePayOrder($model=null, $purchase=null) {
        $data = array();
        $data['errors'] = array();
        $data['pay'] = null;
        try {
            if(empty($purchase)) {
                $data['errors']["form_error"] = "No purchase selected.";
            } elseif(empty(get_post('paid_amount'))) {
                $data['errors']["paid_amount"] = "Amount is required.";
            } elseif(empty(get_post('paid_date'))) {
                $data['errors']["paid_date"] = "Issue date is required.";
            } else {
                $res = $model->createOrUpdatePayOrder($purchase, $_POST);
                if($res) {
                    $message = "Pay order Successfully saved.";
                    $data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    $data['success'] = 1;
                    $data['error'] = 0;
                    $data['pay'] = $res;
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
}