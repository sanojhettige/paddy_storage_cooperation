<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Users extends Controller {

    public function index($param=null) {
        $this->data['title'] = "Users";
        $this->data['assets'] = array(
            'css'=>array(
                BASE_URL.'/assets/css/datatables.min.css'
            ),
            'js'=>array(
                BASE_URL.'/assets/js/datatables.min.js',
                BASE_URL.'/assets/js/datatables.js'
            )
        );
        $this->view->render("users/index", "template", $this->data);
        clear_messages();
    }

    public function get_users() {
        $data = array();
        $users = array();
        $offset = get_post('start');
        $limit = get_post('length');
        $search = get_post('search')['value'];
        $user_model = $this->model->load('user');

        $res = $user_model->getUsers($limit,$offset, $search);

        $editable = is_permitted('users-edit');
        $deletable = is_permitted('users-delete');

        foreach($res["data"] as $index=>$item) {
            $users[$index]['id'] = $item['id'];
            $users[$index]['name'] = $item['name'];
            $users[$index]['email'] = $item['email'];
            $users[$index]['user_role'] = $item['user_role'];
            $users[$index]['collection_center'] = $item['collection_center'];
            $users[$index]['modified_at'] = $item['modified_at'];
            $users[$index]['delete'] = $deletable;
            $users[$index]['edit'] = $editable;
        }
        $data["data"] = $users;


        $data["draw"] = get_post("draw");
        $data["recordsTotal"] = $res["count"];
        $data["recordsFiltered"] = $res["count"];
        $data['search'] = $search;
        echo json_encode($data);
    }

    public function add() {
        $this->data['record'] = array();
        $this->data['title'] = "Add User";
        $user_model = $this->model->load('user');
        $role_model = $this->model->load('userRole');
        $cc_model = $this->model->load("collectionCenter");
        if(get_post('submit')) {
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
        if(get_post('submit')) {
            $this->createOrUpdateUser($user_model);
        }
        $this->data['user_roles'] = $role_model->getUserRoles();
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();
        $this->view->render("users/user_form", "template", $this->data);
    }

    private function createOrUpdateUser($model=null) {
        $this->data['errors'] = array();
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty(get_post("role_id"))) {
                $this->data['errors']["address"] = "User role is required";
            } elseif(empty(get_post("email"))) {
                $this->data['errors']["email"] = "Email is required";
            } elseif(empty(get_post("password"))) {
                $this->data['errors']["password"] = "Password is required";
            } elseif(empty(get_post("cpassword"))) {
                $this->data['errors']["cpassword"] = "Password confirmation is required";
            } elseif(get_post("cpassword") !== get_post("password")) {
                $this->data['errors']["cpassword"] = "Password confirmation not matched.";
            }  else {
                $res = $model->createOrUpdateRecord(get_post("_id"), $_POST);
                if($res) {
                    $message = "User Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                    header("Location: ".BASE_URL."/users");
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
        $center_model = $this->model->load('collectionCenter');
        
        if($id > 0) {
            $this->data['record'] = $user_model->getUserById($id);
            if($this->data['record']['collection_center_id'] > 0) {
                $this->data['record']['collection_center'] = $center_model->getCollectionCenterById($this->data['record']['collection_center_id']);
            }
        }
        if(get_post('submit') && $this->data['record']) {
            $this->doDelete($user_model, $id);
        }
        $this->data['canDelete'] = true;
        $this->view->render("users/view_user", "template", $this->data);
    }

    private function doDelete($model=null, $id=NULL) {
        try {
            $res = $model->deleteUserById($id);
            if($res) {
                $message = "User successfully deleted.";
                $this->data['success_message'] = $message;
                $_SESSION['success_message'] = $message;
                header("Location: ".BASE_URL."/users");
            } else {
                $this->data['error_message'] = "Unable to delete user data, please try again.";
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}