<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Users extends Controller {
    
    public function index($param=null) {
        $this->view->render("users/index", "template", $this->data);
    }
}