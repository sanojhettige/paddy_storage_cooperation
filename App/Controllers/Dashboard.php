<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Dashboard extends Controller {
    
    public function index($param=null) {
        $this->view->render("index", "template", $this->data);
    }
}