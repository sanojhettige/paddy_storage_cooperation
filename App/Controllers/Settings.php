<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Settings extends Controller {
    
    public function index($param=null) {
        $this->view->render("settings/index", "template", $this->data);
    }

    public function prices() {
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
        $settings_model = $this->model->load('settings');
        $rate = $settings_model->getPaddyRateByCategoryAndDate($date, $category);

        echo json_encode($rate);
    }

    // Paddy Seasons
    public function paddy_seasons($id=null) {
        $this->data['title'] = "Paddy Seasons";
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

        if($id > 0) {
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
        $data["recordsFiltered"] = 0;
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
        if($id > 0) {
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
        $data["recordsFiltered"] = 0;
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
        if($id > 0) {
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
        $data["recordsFiltered"] = 0;
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

    // Money allocation
    
    public function money_allocation($id=null) {
        $this->data['title'] = "Money Allocation";
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
        if($id > 0) {
            $this->data['record'] = $settings_model->getCashRecordTypeById($id);
        }

        if(get_post('submit')) {
            $this->createOrUpdateCashRecord($settings_model);
        }
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("settings/money_allocation", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateCashRecord($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("collection_center_id"))) {
                $this->data['errors']["collection_center_id"] = "Collection center is required";
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
        $data["recordsFiltered"] = 0;
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
}