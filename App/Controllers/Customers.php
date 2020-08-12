<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Customers extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Customers";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("customers/index", "template", $this->data);
        clear_messages();
    }

    public function get_customers() {
        $data = array();
        $customers = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $customer_model = $this->model->load('customer');

        $res = $customer_model->getCustomers($limit,$offset, $search);
        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        
        $editable = is_permitted('customers-edit');
        $deletable = is_permitted('customers-delete');

        foreach($res["data"] as $index=>$item) {
            $customers[$index]['id'] = $item['id'];
            $customers[$index]['name'] = $item['name'];
            $customers[$index]['phone_number'] = $item['phone_number'];
            $customers[$index]['company_name'] = $item['company_name'];
            $customers[$index]['email_address'] = $item['email_address'];
            $customers[$index]['modified_at'] = $item['modified_at'];
            $customers[$index]['delete'] = $deletable;
            $customers[$index]['edit'] = $editable;
        }
        $data["data"] = $customers;

        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add customer";
        $customer_model = $this->model->load('customer');
        if(get_post('submit')) {
            $this->createOrUpdateCustomer($customer_model);
        }
        $this->view->render("customers/customer_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update customer";
        $customer_model = $this->model->load('customer');
        if($id > 0) {
            $this->data['record'] = $customer_model->getCustomerById($id);
        }
        if(get_post('submit')) {
            $this->createOrUpdateCustomer($customer_model);
        }
        $this->view->render("customers/customer_form", "template", $this->data);
    }

    private function createOrUpdateCustomer($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty(get_post("company_name"))) {
                $this->data['errors']["company_name"] = "Company is required";
            } elseif(empty(get_post("address"))) {
                $this->data['errors']["address"] = "Address is required";
            } elseif(empty(get_post("email_address"))) {
                $this->data['errors']["email_address"] = "Email address is required";
            } elseif(empty(get_post("phone"))) {
                $this->data['errors']["phone"] = "Phone Number is required";
            } elseif(!preg_match("/^[0]{1}[7]{1}[0-9]{8}$/", get_post("phone"))) {
                $this->data['errors']["phone"] = "Invalid phone number format (Ex: 07xxxxxxxx)";
            } else {
                $res = $model->createOrUpdateRecord(get_post("_id"), $_POST);
                if($res) {
                    $message = "Customer Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    header("Location: ".BASE_URL."/customers");
                } else {
                    $this->data['error_message'] = "Unable to save data, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function delete($id=NULL) {
        $this->data['title'] = "Delete customer";
        $customer_model = $this->model->load('customer');
        if($id > 0) {
            $this->data['record'] = $customer_model->getCustomerById($id);
        }
        if(get_post('submit') && $this->data['record']) {
            $this->doDelete($customer_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("customers/view_customer", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteCustomerById($id);
            if($res) {
                $message = "Customer successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: ".BASE_URL."/customers");
            } else {
                $this->data['error_message'] = "Unable to delete customer, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}