<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Sales extends Controller {
    
    public function index($param=null) {
        $view = new View();
        $view->render("sales/index", "template", $this->data);
    }
}