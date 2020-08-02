<?php
if ( ! defined('APP_PATH')) exit("Access denied");

class View {

    // Define Variables
    protected static $data;
    
    public static function render($content, $template, $data = null) {
       if($data) {
           extract($data);
       }

        include "App/Views/templates/". $template.".php";
    }
    
}