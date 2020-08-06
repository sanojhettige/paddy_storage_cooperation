<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Users extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Users";
        $this->view->render("users/index", "template", $this->data);
    }

    public function get_users() {
        $data = array();
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        $search = $_POST['search']['value'];
        $user_model = $this->model->load('user');

        $res = $user_model->getUsers($limit,$offset, $search);
        $data["draw"] = $_POST["draw"];
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = 0;
        $data["data"] = $res["data"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add User";
        $user_model = $this->model->load('user');
        $role_model = $this->model->load('userRole');
        $cc_model = $this->model->load("collectionCenter");
        if(isset($_POST['submit'])) {
            $this->createOrUpdateUser($user_model);
        }
        $this->data['user_roles'] = $role_model->getUserRoles();
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("users/user_form", "template", $this->data);
    }

    public function edit($id=null) {
        $this->data['title'] = "Update User";
        $user_model = $this->model->load('user');
        $role_model = $this->model->load('userRole');
        $cc_model = $this->model->load("collectionCenter");
        if($id > 0) {
            $this->data['record'] = $user_model->getUserById($id);
        }
        if(isset($_POST['submit'])) {
            $this->createOrUpdateUser($user_model);
        }
        $this->data['user_roles'] = $role_model->getUserRoles();
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("users/user_form", "template", $this->data);
    }

    private function createOrUpdateUser($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty($_POST["name"])) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty($_POST["role_id"])) {
                $this->data['errors']["address"] = "User role is required";
            } elseif(empty($_POST["email"])) {
                $this->data['errors']["email"] = "Email is required";
            } elseif(empty($_POST["password"])) {
                $this->data['errors']["password"] = "Password is required";
            } elseif(empty($_POST["cpassword"])) {
                $this->data['errors']["cpassword"] = "Password confirmation is required";
            } elseif($_POST["cpassword"] !== $_POST["password"]) {
                $this->data['errors']["cpassword"] = "Password confirmation not matched.";
            }  else {
                $res = $model->createOrUpdateRecord($_POST["_id"], $_POST);
                if($res) {
                    $this->data['success_message'] = "User Successfully saved.";
                } else {
                    $this->data['error_message'] = "Unable to save user data, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }


    public function delete($id=NULL) {
        $this->data['title'] = "Delete User";
        $user_model = $this->model->load('user');
        if($id > 0) {
            $this->data['record'] = $user_model->getUserById($id);
        }
        if(isset($_POST['submit']) && $this->data['record']) {
            $this->doDelete($user_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("users/view_user", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteUserById($id);
            if($res) {
                $this->data['success_message'] = "User successfully deleted.";
            } else {
                $this->data['error_message'] = "Unable to delete user data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}