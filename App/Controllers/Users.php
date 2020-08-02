<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Users extends Controller {
    
    public function index($param=null) {
        $view = new View();
        $view->render("users/index", "template", $this->data);
    }
}