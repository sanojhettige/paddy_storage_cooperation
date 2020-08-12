<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Auth extends Controller {
    
    public function index($param=null) {
        $user_model = $this->model->load('user');
        if(isset($_POST['do_login'])) {
            $username = get_post('username');
            $password = get_post('password');
    
            $res = $user_model->do_login($username, $password);
            if($res) {
                $_SESSION['user_id'] = $res['id'];
                $_SESSION['role_id'] = $res['role_id'];
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
}