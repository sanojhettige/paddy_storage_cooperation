<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Vehicles extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Vehicles";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("vehicles/index", "template", $this->data);
        clear_messages();
    }

    public function get_vehicles() {
        $data = array();
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $vehicle_model = $this->model->load('vehicle');

        $res = $vehicle_model->getVehicles($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add vehicle";
        $vehicle_model = $this->model->load('vehicle');
        $setting_model = $this->model->load('settings');
        if(isset($_POST['submit'])) {
            $this->createOrUpdateVehicle($vehicle_model);
        }
        $this->data['vehicle_types'] = $setting_model->getVehicleTypes(100,0)['data'];
        $this->view->render("vehicles/vehicle_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update vehicle";
        $vehicle_model = $this->model->load('vehicle');
        $setting_model = $this->model->load('settings');
        if($id > 0) {
            $this->data['record'] = $vehicle_model->getVehicleById($id);
        }
        if(isset($_POST['submit'])) {
            $this->createOrUpdateVehicle($vehicle_model);
        }
        $this->data['vehicle_types'] = $setting_model->getVehicleTypes(100,0)['data'];
        $this->view->render("vehicles/vehicle_form", "template", $this->data);
    }

    private function createOrUpdateVehicle($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty($_POST["registration_number"])) {
                $this->data['errors']["registration_number"] = "Vehicle registraion no is required";
            } elseif(empty($_POST["vehicle_type"])) {
                $this->data['errors']["vehicle_type"] = "Vehicle type is required";
            } else {
                $res = $model->createOrUpdateRecord($_POST["_id"], $_POST);
                if($res) {
                    $message = "Vehicle Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    header("Location: ".BASE_URL."/vehicles");
                } else {
                    $this->data['error_message'] = "Unable to save vehicle data, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function delete($id=NULL) {
        $this->data['title'] = "Delete vehicle";
        $vehicle_model = $this->model->load('vehicle');
        if($id > 0) {
            $this->data['record'] = $vehicle_model->getVehicleById($id);
        }
        if(isset($_POST['submit']) && $this->data['record']) {
            $this->doDelete($vehicle_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("vehicles/view_vehicle", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteVehicleById($id);
            if($res) {
                $message = "Vehicle successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: ".BASE_URL."/vehicles");
            } else {
                $this->data['error_message'] = "Unable to delete vehicle data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}