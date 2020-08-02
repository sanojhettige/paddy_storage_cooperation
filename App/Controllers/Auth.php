<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Auth extends Controller {
    
    public function index($param=null) {
        $view = new View();

        if(isset($_POST['do_login'])) {
            $user_model = $this->model->load('user');
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $res = $user_model->do_login($username, $password);
            if($res) {
                $_SESSION['user_id'] = $res['id'];
                $_SESSION['logged_in'] = true;
                $_SESSION['logged_in_time'] = date("Y-m-d h:i:s");
                header("Location: /dashboard");
            } else {
                $this->data['message'] = "Invalid username or password";
            }
        }

        if($_SESSION['logged_in'] && $user_model->getUserById($_SESSION['user_id'])) {
            header("Location: /dashboard");
        }
        
        $this->view->render("auth/login", "auth", $this->data);
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /");
    }
}