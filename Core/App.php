<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class App {
    public $load;

    public static function start() {
        // Set default controller and method
        $controller = "Auth";
        $method = "index";
        $params = [];
        $routes = explode("/", $_SERVER["REQUEST_URI"]);

        if(!empty($routes[1])) {
            $controller = $routes[1];
        }

        if(!empty($routes[2])) {
            $method = $routes[2];
        }

        if(!empty($routes[3])) {
            $params = $routes[3];
        }
        $url_ctrl = $controller;
        $controller = str_replace(" ","",ucwords(str_replace('-', ' ', $controller)));

        $ctrlFile = $controller.".php";
        
        $ctrlPath = "App/Controllers/" . $ctrlFile;
        if(file_exists($ctrlPath)) {
            include $ctrlPath;
        } else {
            // Redirect to error page if controller not found
            App::ErrorPage("No Controller Found");
        }

        // Create Cotroller
        $ctrl = new $controller;
        
        if(method_exists($ctrl, $method)) {
            if(is_permitted($url_ctrl.'-'.$method) || $url_ctrl === "dashboard" || ($url_ctrl === "Auth" || $url_ctrl === "auth")) {
                $ctrl->$method($params);
            } else {
                App::ErrorPage("No Permission");
            }
            
        } else {
            // Redirect to error page if method not found
            App::ErrorPage("No Method Found ".($method));
        }
    }

    // Error display page for main app view
    static function ErrorPage($message) {
        $view  = new View;
        $view->render("errors/404","template",array("message"=>$message));
        die();

        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

}