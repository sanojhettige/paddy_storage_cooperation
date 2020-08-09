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
                '/assets/js/dailyPrices.js'
            ),
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
                '/assets/css/fullcalendar.css'
            )
        );
        $this->data['categories'] = $settings_model->getPaddyCategories(100,0)['data'];
        $this->view->render("settings/daily_prices", "template", $this->data);
    }

    public function get_daily_prices() {
        $data = array();
        $start = $_POST['start'];
        $ends = $_POST['end'];
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
            if(empty($_POST["date"])) {
                $this->data['errors']["date"] = "Date is required";
            } elseif(empty($_POST["paddy_category_id"])) {
                $this->data['errors']["paddy_category_id"] = "Category is required";
            } elseif(empty($_POST["selling_price"])) {
                $this->data['errors']["selling_price"] = "Selling price is required";
            } elseif(empty($_POST["buying_price"])) {
                $this->data['errors']["buying_price"] = "buying_price is required";
            } else {
                $_POST['date'] = date("Y-m-d", strtotime($_POST['date']));
                $exists = $settings_model->priceExists($_POST['date'],$_POST['paddy_category_id']);
                if($exists && $exists['id'] != $_POST['_id']) {
                    $this->data['message'] = "Price is already in the calendar.";
                    $this->data['success'] = 0;
                    $this->data['error'] = 1;
                } else {
                    $res = $settings_model->createOrUpdatePrice($_POST["_id"], $_POST);

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

    // Paddy Seasons
    public function paddy_seasons($id=null) {
        $this->data['title'] = "Paddy Categories";
        $settings_model = $this->model->load('settings');
        $this->data['assets'] = array(
            'css'=>array(
                '/assets/css/datatables.min.css'
            ),
            'js'=>array(
                '/assets/js/datatables.min.js',
                '/assets/js/datatables.js'
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
            if(empty($_POST["name"])) {
                $this->data['errors']["name"] = "Name is required";
            } else {
                $res = $model->createOrUpdateSeason($_POST["_id"], $_POST);
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
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getPaddySeasons($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
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
        header("Location: /settings/paddy_seasons");
    }

    // Paddy Types
    public function paddy_categories($id=null) {
        $this->data['title'] = "Paddy Categories";
        $settings_model = $this->model->load('settings');
        $this->data['assets'] = array(
            'css'=>array(
                '/assets/css/datatables.min.css'
            ),
            'js'=>array(
                '/assets/js/datatables.min.js',
                '/assets/js/datatables.js'
            )
        );
        if($id > 0) {
            $this->data['record'] = $settings_model->getCategoryById($id);
        }

        if(isset($_POST['submit'])) {
            $this->createOrUpdateCategory($settings_model);
        }

        $this->view->render("settings/paddy_categories", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateCategory($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty($_POST["name"])) {
                $this->data['errors']["name"] = "Name is required";
            } else {
                $res = $model->createOrUpdateCategory($_POST["_id"], $_POST);
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
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getPaddyCategories($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
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
        header("Location: /settings/paddy_categories");
    }

    // Vehicle Types
    public function vehicle_types($id=null) {
        $this->data['title'] = "Vehicle Types";
        $settings_model = $this->model->load('settings');
        $this->data['assets'] = array(
            'css'=>array(
                '/assets/css/datatables.min.css'
            ),
            'js'=>array(
                '/assets/js/datatables.min.js',
                '/assets/js/datatables.js'
            )
        );
        if($id > 0) {
            $this->data['record'] = $settings_model->getVehicleTypeById($id);
        }

        if(isset($_POST['submit'])) {
            $this->createOrUpdateVehicleType($settings_model);
        }

        $this->view->render("settings/vehicle_types", "template", $this->data);
        clear_messages();
    }

    private function createOrUpdateVehicleType($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty($_POST["name"])) {
                $this->data['errors']["name"] = "Name is required";
            } else {
                $res = $model->createOrUpdateVehicleType($_POST["_id"], $_POST);
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
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $settings_model = $this->model->load('settings');

        $res = $settings_model->getVehicleTypes($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
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
        header("Location: /settings/vehicle_types");
    }
}