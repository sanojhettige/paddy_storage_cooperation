<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Settings extends Controller {
    
    public function index($param=null) {
        $settings_model = $this->model->load('settings');
        $this->data['seasons'] = $settings_model->getPaddySeasons(10,0, '')['data'];
        $this->data['record'] = $settings_model->getAppData();

        if(isset($_POST['submit'])) {
            $this->saveSettings($settings_model);
        }
        $this->view->render("settings/index", "template", $this->data);
        clear_messages();
    }

    private function saveSettings($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("app_name"))) {
                $this->data['errors']["app_name"] = "App name is required";
            } elseif(empty(get_post("address"))) {
                $this->data['errors']["address"] = "Address is required";
            } elseif(empty(get_post("phone_number"))) {
                $this->data['errors']["phone_number"] = "Phone number(s) is required";
            } elseif(empty(get_post("email_address"))) {
                $this->data['errors']["email_address"] = "Email address is required";
            } elseif(empty(get_post("active_season_id"))) {
                $this->data['errors']["active_season_id"] = "Active Season is required";
            } else {
                $res = $model->updateAppData($_POST);
                if($res) {
                    $this->data['success_message'] = "App data Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save data, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }

    public function prices() {
        $settings_model = $this->model->load('settings');
        $this->data['title'] = "Daily Price";
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
        $this->data['categories'] = $settings_model->getPaddyCategories(100,0)['data'];
        $this->view->render("settings/daily_prices", "template", $this->data);
    }

    public function get_daily_prices() {
        $data = array();
        $start = get_post('start');
        $ends = get_post('end');
        $settings_model = $this->model->load('settings');

        $prices = $settings_model->getDailyPrices($start, $ends);

        foreach($prices as $index=>$row) {
            $category = $settings_model->getCategoryById($row['paddy_category_id']);
            $cname = $category ? $category['name']: "";
            $data[$index]['title'] = "Category - ".$cname." \r\n Buying - ".$row['buying_price']." \r\n Selling - ".$row['selling_price'];
            $data[$index]['start'] = date("Y-m-d 00:00:00", strtotime($row['date']));
            $data[$index]['end'] = date("Y-m-d 00:00:00", strtotime($row['date']));
            $data[$index]['className'] = "fc-bg-default";
            $data[$index]['id'] = $row['id'];
            $data[$index]['buying_price'] = $row['buying_price'];
            $data[$index]['selling_price'] = $row['selling_price'];
            $data[$index]['paddy_category_id'] = $row['paddy_category_id'];
        }
        echo json_encode($data);
    }

    public function save_price() {
        $settings_model = $this->model->load('settings');
        $this->data['errors'] = array();
        try {
            if(empty(get_post("date"))) {
                $this->data['errors']["date"] = "Date is required";
            } elseif(empty(get_post("paddy_category_id"))) {
                $this->data['errors']["paddy_category_id"] = "Category is required";
            } elseif(empty(get_post("selling_price"))) {
                $this->data['errors']["selling_price"] = "Selling price is required";
            } elseif(empty(get_post("buying_price"))) {
                $this->data['errors']["buying_price"] = "buying_price is required";
            } else {
                $_POST['date'] = date("Y-m-d", strtotime($_POST['date']));
                $exists = $settings_model->priceExists($_POST['date'],$_POST['paddy_category_id']);
                if($exists && $exists['id'] != $_POST['_id']) {
                    $this->data['message'] = "Price is already in the calendar.";
                    $this->data['success'] = 0;
                    $this->data['error'] = 1;
                } else {
                    $res = $settings_model->createOrUpdatePrice(get_post("_id"), $_POST);

                    if($res) {
                        $this->data['message'] = "Price Successfully saved.";
                        $this->data['success'] = 1;
                        $this->data['error'] = 0;
    
                    } else {
                        $this->data['message'] = "Unable to save price, please try again.";
                        $this->data['success'] = 0;
                        $this->data['error'] = 1;
                    }
                }
            }
        } catch(Exception $e) {
            $this->data['message'] = $e; // ? $e['errorInfo']: "Unable to save price, please try again.";
            $this->data['success'] = 0;
            $this->data['error'] = 1;
        }

        if(count($this->data['errors']) > 0) {
            $this->data['success'] = 0;
            $this->data['error'] = 1;
        }

        echo json_encode($this->data);
    }

    public function delete_price() {

    }

    public function get_paddy_rate() {
        $date = get_post('date');
        $category = get_post('paddy_type');
        $warehouse = get_post('warehouse');
        $settings_model = $this->model->load('settings');
        $sales_model = $this->model->load('sale');
        $rate = $settings_model->getPaddyRateByCategoryAndDate($date, $category);
        $avl_stock = $sales_model->getPaddyAvailableStock($warehouse, $category);
        $pendingSales = $sales_model->getPendingSaleStock($warehouse, $category);
        $sold_stock = $pendingSales;
        $available_stock = $avl_stock - $sold_stock;
        $stock = array('in_stock'=>$avl_stock,'sold_stock'=>$sold_stock,'available_stock'=>$available_stock);
        echo json_encode(array_merge($rate, $stock));
    }

    // Paddy Seasons
    public function paddy_seasons($id=null) {
        $this->data['title'] = "Paddy Seasons";
        $this->data['record'] = array();
        $settings_model = $this->model->load('settings');
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            ),
            'js'=>array(
                '/assets/js/datatables.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );

        if(is_numeric($id) && isset($id) && $id > 0) {
            $this->data['record'] = $settings_model->getSeasonById($id);
        }

        if(isset($_POST['submit'])) {
            $this->createOrUpdateSeason($settings_model);
        }

        $this->view->render("settings/paddy_seasons", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateSeason($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty(get_post("period"))) {
                $this->data['errors']["period"] = "Period is required";
            } else {
                $res = $model->createOrUpdateSeason(get_post("_id"), $_POST);
                if($res) {
                    $this->data['success_message'] = "Season Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save season, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }

    public function get_paddy_seasons() {
        $data = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getPaddySeasons($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = $res["count"];
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function delete_paddy_seasons($id=NULL) {
        $settings_model = $this->model->load('settings');
        try {
            $res = $settings_model->deleteSeasonById($id);
            if($res) {
                $_SESSION['success_message'] = "Season successfully deleted.";
            } else {
                $_SESSION['error_message'] = "Unable to delete season, please try again.";
            }
        } catch(Exception $e) {
            $_SESSION['error_message'] = $e;
        }
        header("Location: ".BASE_URL."/settings/paddy_seasons");
    }

    // Paddy Types
    public function paddy_categories($id=null) {
        $this->data['title'] = "Paddy Categories";
        $this->data['record'] = array();
        $settings_model = $this->model->load('settings');
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        if(is_numeric($id) && isset($id) && $id > 0) {
            $this->data['record'] = $settings_model->getCategoryById($id);
        }

        if(get_post('submit')) {
            $this->createOrUpdateCategory($settings_model);
        }

        $this->view->render("settings/paddy_categories", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateCategory($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } else {
                $res = $model->createOrUpdateCategory(get_post("_id"), $_POST);
                if($res) {
                    $this->data['success_message'] = "Category Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save category, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }

    public function get_paddy_categories() {
        $data = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getPaddyCategories($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = $res["count"];
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function delete_paddy_categories($id=NULL) {
        $settings_model = $this->model->load('settings');
        try {
            $res = $settings_model->deleteCategoryById($id);
            if($res) {
                $_SESSION['success_message'] = "Category successfully deleted.";
            } else {
                $_SESSION['error_message'] = "Unable to delete category, please try again.";
            }
        } catch(Exception $e) {
            $_SESSION['error_message'] = $e;
        }
        header("Location: ".BASE_URL."/settings/paddy_categories");
    }

    // Vehicle Types
    public function vehicle_types($id=null) {
        $this->data['title'] = "Vehicle Types";
        $this->data['record'] = array();
        $settings_model = $this->model->load('settings');
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        
        if(is_numeric($id) && isset($id) && $id > 0) {
            $this->data['record'] = $settings_model->getVehicleTypeById($id);
        }

        if(get_post('submit')) {
            $this->createOrUpdateVehicleType($settings_model);
        }

        $this->view->render("settings/vehicle_types", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateVehicleType($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } else {
                $res = $model->createOrUpdateVehicleType(get_post("_id"), $_POST);
                if($res) {
                    $this->data['success_message'] = "Vehicle type Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save vehicle type, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }

    public function get_vehicle_types() {
        $data = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getVehicleTypes($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = $res["count"];
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function delete_vehicle_type($id=NULL) {
        $settings_model = $this->model->load('settings');
        try {
            $res = $settings_model->deleteVehicleTypeById($id);
            if($res) {
                $_SESSION['success_message'] = "Vehicle type successfully deleted.";
            } else {
                $_SESSION['error_message'] = "Unable to delete vehicle type, please try again.";
            }
        } catch(Exception $e) {
            $_SESSION['error_message'] = $e;
        }
        header("Location: ".BASE_URL."/settings/vehicle_types");
    }

    // Bank accounts
    public function bank_accounts($id=null) {
        $this->data['title'] = "Bank Account";
        $this->data['record'] = array();
        $settings_model = $this->model->load('settings');
        $cc_model = $this->model->load('collectionCenter');
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        if(is_numeric($id) && isset($id) && $id > 0) {
            $this->data['record'] = $settings_model->getBankAccountById($id);
        }

        if(get_post('submit')) {
            $this->createOrUpdateBankAccount($settings_model);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("settings/bank_accounts", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateBankAccount($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("collection_center_id"))) {
                $this->data['errors']["collection_center_id"] = "Collection center is required";
            } elseif(empty(get_post("bank_account_no"))) {
                $this->data['errors']["bank_account_no"] = "Account No is required";
            } elseif(empty(get_post("bank_account_name"))) {
                $this->data['errors']["bank_account_name"] = "Account name is required";
            } elseif(empty(get_post("bank_and_branch"))) {
                $this->data['errors']["bank_and_branch"] = "Bank name is required";
            } else {
                $res = $model->createOrUpdateBankAccount(get_post("_id"), $_POST);
                if($res) {
                    $this->data['success_message'] = "Bank  Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save bank account, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }

    public function get_bank_accounts() {
        $data = array();
        $accounts = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getBankAccounts($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = $res["count"];

        foreach($res["data"] as $index=>$account) {
            $accounts[$index]['id'] = $account['id'];
            $accounts[$index]['collection_center'] = $account['collection_center'];
            $accounts[$index]['account_name'] = $account['bank_account_name'];
            $accounts[$index]['bank_name'] = $account['bank_and_branch'];
            $accounts[$index]['balance'] = 0;
        }
        $data["data"] = $accounts;

        $data['search'] = $search;
        echo json_encode($data);
    }

    public function delete_bank_account($id=NULL) {
        $settings_model = $this->model->load('settings');
        try {
            $res = $settings_model->deleteBankAccountById($id);
            if($res) {
                $_SESSION['success_message'] = "Bank account successfully deleted.";
            } else {
                $_SESSION['error_message'] = "Unable to delete record, please try again.";
            }
        } catch(Exception $e) {
            $_SESSION['error_message'] = $e;
        }
        header("Location: ".BASE_URL."/settings/bank_accounts");
    }

    // Money allocation
    public function money_allocation($id=null) {
        $this->data['title'] = "Money Allocation";
        $this->data['record'] = array();
        $settings_model = $this->model->load('settings');
        $cc_model = $this->model->load('collectionCenter');
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        if(is_numeric($id) && isset($id) && $id > 0) {
            $this->data['record'] = $settings_model->getCashRecordById($id);
        }

        if(get_post('submit')) {
            $this->createOrUpdateCashRecord($settings_model);
        }
        $this->data['bank_accounts'] = $settings_model->getBankAccounts(100,0)['data'];
        
        $this->view->render("settings/money_allocation", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateCashRecord($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("bank_account_id"))) {
                $this->data['errors']["bank_account_id"] = "Collection center is required";
            } elseif(empty(get_post("amount"))) {
                $this->data['errors']["amount"] = "Amount is required";
            } else {
                $res = $model->createOrUpdateCashRecord(get_post("_id"), $_POST);
                if($res) {
                    $this->data['success_message'] = "Cash record Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save record, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }

    public function get_money_allocations() {
        $data = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getCashRecords($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = $res["count"];
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function delete_money_allocation($id=NULL) {
        $settings_model = $this->model->load('settings');
        try {
            $res = $settings_model->deleteCashRecordById($id);
            if($res) {
                $_SESSION['success_message'] = "Record successfully deleted.";
            } else {
                $_SESSION['error_message'] = "Unable to delete record, please try again.";
            }
        } catch(Exception $e) {
            $_SESSION['error_message'] = $e;
        }
        header("Location: ".BASE_URL."/settings/money_allocation");
    }


    public function buying_limitation() {
        $this->data['title'] = "Paddy Buying Limitations";
        $settings_model = $this->model->load('settings');

        if(get_post("submit")) {
            $this->updateSeasonalBuying($settings_model);
        }

        $this->data['seasons'] = $settings_model->getPaddySeasons(20,0)['data'];
        $this->view->render("settings/buying_limitations", "template", $this->data);
        clear_messages();
    }

    private function updateSeasonalBuying($model=null) {
        $this->data['errors'] = array();
        try {
            $res = $model->updateSeasonalBuying($_POST);
            // print_r($res); exit;
                if($res) {
                    $this->data['success_message'] = "Limitations Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save record, please try again.";
                }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}