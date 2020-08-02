<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Vehicles extends Controller {
    
    public function index($param=null) {
        $view = new View();
        $view->render("vehicles/index", "template", $this->data);
    }
}