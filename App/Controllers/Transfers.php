<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Transfers extends Controller {
    
    public function index($param=null) {
        $view = new View();
        $view->render("transfers/index", "template", $this->data);
    }
}