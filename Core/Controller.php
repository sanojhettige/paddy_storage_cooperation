<?php
if ( ! defined('APP_PATH')) exit("Access denied");

class Controller {
    public $model;
    public $view;
    public $data = array();

    public function __construct() {
        $this->view = new View();
        $this->model = new Model();
    }

    function index() {
        
    }
}