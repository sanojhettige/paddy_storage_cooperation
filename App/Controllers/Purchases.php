<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Purchases extends Controller {
    
    public function index($param=null) {
        $view = new View();
        $view->render("purchases/index", "template", $this->data);
    }
}