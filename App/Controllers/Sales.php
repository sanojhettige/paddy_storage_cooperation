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
        $this->data['type'] = "all";
        $this->view->render("sales/index", "template", $this->data);
        clear_messages();
    }

    public function collection_orders($param=null) {
        $this->data['title'] = "Collection Orders";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );

        $this->data['type'] = "collections";
        $this->view->render("sales/index", "template", $this->data);
        clear_messages();
    }

    public function get_sales($type=null) {
        $data = array();
        $sales = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $sale_model = $this->model->load('sale');

        $res = $sale_model->getSales($limit,$offset, $search, $type);

        $editable = is_permitted('sales-edit');
        $deletable = is_permitted('sales-delete');
        $viewable = is_permitted('sales-view');

        foreach($res["data"] as $index=>$item) {
            $canIssue = ($item['collection_center_id'] === get_session('assigned_center'));
            $sales[$index]['id'] = $item['id'];
            $sales[$index]['buyer_name'] = $item['buyer_name'];
            $sales[$index]['collection_center'] = $item['collection_center'];
            $sales[$index]['issue_date'] = $item['issue_date'];
            $sales[$index]['sale_status'] = sale_status($item['sale_status_id']);
            $sales[$index]['delete'] = $deletable;
            $sales[$index]['edit'] = $editable;
            $sales[$index]['view'] = $viewable;
            $sales[$index]['can_issue'] = $canIssue;
            $sales[$index]['print'] = $viewable;
        }
        $data["data"] = $sales;


        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = $res["count"];
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
            if(empty(get_post("customer_id"))) {
                $data['errors']["customer_id"] = "Buyer is required";
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
        $this->data['redirect'] = "/sales";
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
        $this->data['redirect'] = "/sales";
        $sale_model = $this->model->load('sale');
        if($id > 0) {
            $this->data['record'] = $sale_model->getSaleById($id);
        }
        
        $this->data['canPrint'] = true;

        if(isset($_GET['print'])) {
            $pdf = $this->library->load('tcpdf');
            $settings_model = $this->model->load('settings');
            $this->data['app_data'] = $settings_model->getAppData();
            $this->view->render("sales/print_sale", "print_template", $this->data);
        } else {
            $this->view->render("sales/view_sale", "template", $this->data);
        }
        
    }

    public function issue($id=NULL) {
        $this->data['title'] = "Issue sale";
        $this->data['redirect'] = "/sales/collection_orders";
        $sale_model = $this->model->load('sale');
        if($id > 0) {
            $this->data['record'] = $sale_model->getSaleById($id);
        }
        if(get_post('submit') && $this->data['record']) {
            $this->doUpdateSaleStatus($sale_model, $id, 2);
        }
        if($this->data['record']['collection_center_id'] === get_session('assigned_center') && $this->data['record']['sale_status_id'] === 1)
            $this->data['canIssue'] = true;
        
        $this->view->render("sales/view_sale", "template", $this->data);
    }

    private function doUpdateSaleStatus($model=null, $id=null, $status=null) {
        $data = array();
        $data['errors'] = array();
        try {
            if(!in_array($status, array(2,3))) {
                $this->data['error_message'] = "Invalid sale status";
            } elseif(!$id) {
                $this->data['error_message'] = "Invalid sale ID";
            } else {
                $res = $model->doUpdateSaleStatus($id, $status);
                if($res) {
                    $message = "Sale Successfully Updated.";
                    $this->data['success_message'] = $message;
                } else {
                    $this->data['error_message'] = "Unable to save data, please try again.";
                }
            }
        } catch(Exception $e) {
            $data['error_message'] = $e;
        }
    }
    


    public function check_max_limits() {
        $report_model = $this->model->load('report');
        $center_model = $this->model->load('collectionCenter');
        $sales_model = $this->model->load('sale');
        $purchase = array();
        $sId = get_post('update');
        $json = get_post('json');
        $qty = get_post('total_qty');
        $category = get_post('category');
        $warehouse = get_post('warehouse');
        $itemSoldAmount = 0;
        $can_proceed = false;
        if($sId > 0)
            $itemSoldAmount = $sales_model->itemSoldAmount($sId, $category);

        $avl_stock = $sales_model->getPaddyAvailableStock($warehouse, $category);
        $pendingSales = $sales_model->getPendingSaleStock($warehouse, $category);
        $sold_stock = $pendingSales;
        $available_stock = ($avl_stock + $itemSoldAmount) - $sold_stock;

        if($qty <= $available_stock) {
            $can_proceed = true;
        }
        $stock = array('in_stock'=>$avl_stock,'sold_stock'=>$sold_stock,'available_stock'=>$available_stock, 'can_proceed' => $can_proceed);
        
        if($json === "1") {
            echo json_encode($stock);
            exit;
        } else {
            return $stock;
        }
    }
}