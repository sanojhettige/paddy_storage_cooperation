<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Sales extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Sales";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("sales/index", "template", $this->data);
        clear_messages();
    }

    public function get_sales() {
        $data = array();
        $sales = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $sale_model = $this->model->load('sale');

        $res = $sale_model->getSales($limit,$offset, $search);

        $editable = is_permitted('sales-edit');
        $deletable = is_permitted('sales-delete');
        $viewable = is_permitted('sales-view');

        foreach($res["data"] as $index=>$item) {
            $sales[$index]['id'] = $item['id'];
            $sales[$index]['buyer_name'] = $item['buyer_name'];
            $sales[$index]['collection_center'] = $item['collection_center'];
            $sales[$index]['issue_date'] = $item['issue_date'];
            $sales[$index]['delete'] = $deletable;
            $sales[$index]['edit'] = $editable;
            $sales[$index]['view'] = $viewable;
        }
        $data["data"] = $sales;


        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add sale";

        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/sales.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );

        $sale_model = $this->model->load('sale');
        $cc_model = $this->model->load('collectionCenter');
        $customer_model = $this->model->load('customer');
        $settings_model = $this->model->load('settings');
        if($_POST) {
            $this->createOrUpdateSale($sale_model);
        }

        $this->data['record']['items'] = $this->defaultItem(null);

        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['buyers'] = $customer_model->getCustomers(1000,0)['data'];
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->view->render("sales/sale_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update sale";

        $this->data['assets'] = array(
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/sales.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            )
        );

        $sale_model = $this->model->load('sale');
        $cc_model = $this->model->load('collectionCenter');
        $settings_model = $this->model->load('settings');
        $customer_model = $this->model->load('customer');
        
        if($id > 0) {
            $this->data['record'] = $sale_model->getSaleById($id);
        }
        if($_POST) {
            $this->createOrUpdateSale($sale_model);
        }

        if(count($this->data['record']['items']) <= 0) {
            $this->data['record']['items'] = $this->defaultItem($this->data['record']['id']);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->data['buyers'] = $customer_model->getCustomers(1000,0)['data'];
        $this->data['paddy_types'] = $settings_model->getPaddyCategories(100,0,null)['data'];
        $this->view->render("sales/sale_form", "template", $this->data);
    }

    private function defaultItem($id) {
        return array(array(
            'id'=>null,
            'sale_id'=>$id,
            'paddy_category_id'=>null,
            'collected_amount'=>0,
            'collected_rate'=>0,
            'notes'=>''
        ));
    }

    private function createOrUpdateSale($model=null) {
        $data = array();
        $data['errors'] = array();
        $data['sale'] = null;
        try {
            if(empty(get_post("buyer_id"))) {
                $data['errors']["buyer_id"] = "Buyer is required";
            } elseif(empty(get_post("status_id"))) {
                $data['errors']["status_id"] = "Status is required";
            } elseif(empty(get_post("collection_center_id"))) {
                $data['errors']["collection_center_id"] = "Collection center is required";
            } elseif(empty(get_post("collection_date"))) {
                $data['errors']["collection_date"] = "Date is required";
            } elseif(empty(get_post("item")) || !is_array(get_post('item'))) {
                $data['errors']["item"] = "Add one or more items";
            } else {
                $res = $model->createOrUpdateRecord(get_post("_id"), $_POST);
                if($res) {
                    $message = "Sale Successfully saved.";
                    $data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    $data['success'] = 1;
                    $data['error'] = 0;
                    $data['sale'] = $res;
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
        $this->data['title'] = "Delete sale";
        $sale_model = $this->model->load('sale');
        if($id > 0) {
            $this->data['record'] = $sale_model->getSaleById($id);
        }
        if(get_post('submit') && $this->data['record']) {
            $this->doDelete($sale_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("sales/view_sale", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteSaleById($id);
            if($res) {
                $message = "Sale successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: ".BASE_URL."/sales");
            } else {
                $this->data['error_message'] = "Unable to delete data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function view($id=NULL) {
        $this->data['title'] = "View sale";
        $sale_model = $this->model->load('sale');
        if($id > 0) {
            $this->data['record'] = $sale_model->getSaleById($id);
        }
        $this->view->render("sales/view_sale", "template", $this->data);
    }
}