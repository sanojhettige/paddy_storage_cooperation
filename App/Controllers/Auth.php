<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Auth extends Controller {
    
    public function index($param=null) {
        $user_model = $this->model->load('user');
        $user_role_model = $this->model->load('userRole');
        if(isset($_POST['do_login'])) {
            $username = get_post('username');
            $password = password_encrypt(get_post('password'));
    
            $res = $user_model->do_login($username, $password);
            if($res) {
                $role = $user_role_model->getUserRoleById($res['role_id']);
                $_SESSION['user_id'] = $res['id'];
                $_SESSION['role_id'] = $res['role_id'];
                $_SESSION['role_name'] = $role['name'];
                $_SESSION['assigned_center'] = $res['collection_center_id'];
                $_SESSION['logged_in'] = true;
                $_SESSION['logged_in_time'] = date("Y-m-d h:i:s");
                header("Location: ".BASE_URL."/dashboard");
            } else {
                $this->data['message'] = "Invalid username or password";
            }
        }

        if(get_session('logged_in') && $user_model->getUserById(get_session('user_id'))) {
            header("Location: ".BASE_URL."/dashboard");
        }
        
        $this->view->render("auth/login", "auth", $this->data);
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: ".BASE_URL);
    }

    public function profile() {
        $this->data['title'] = "Profile";
        $user_model = $this->model->load('user');
        $userId = get_session('user_id');
        $this->data['record'] = $user_model->getUserById($userId);
        if(get_post('submit')) {
            $this->updateProfile($user_model);
        }
        $this->view->render("auth/profile", "template", $this->data);
        clear_messages();
    }

    
    private function updateProfile($model=null) {
        $this->data['errors'] = array();
        $userId = get_session('user_id');
        try {
            if(empty(get_post("name"))) {
                $this->data['errors']["name"] = "Name is required";
            } elseif(empty(get_post("password"))) {
                $this->data['errors']["password"] = "Password is required";
            } elseif(empty(get_post("cpassword"))) {
                $this->data['errors']["cpassword"] = "Password confirmation is required";
            } elseif(get_post("cpassword") !== get_post("password")) {
                $this->data['errors']["cpassword"] = "Password confirmation not matched.";
            }  else {
                $res = $model->updateProfile($userId, $_POST);
                if($res) {
                    $message = "Profile Successfully saved.";
                    $this->data['success_message'] = $message;
                    $_SESSION['success_message'] = $message;
                } else {
                    $this->data['error_message'] = "Unable to save profile, please try again.";
                }
            }
        } catch(Exception $e) {
            $this->data['error_message'] = $e;
        }
    }
}