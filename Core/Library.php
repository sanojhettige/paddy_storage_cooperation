<?php
if ( ! defined('APP_PATH')) exit("Access denied");

class Library {
    
    public function load($library=null) {
        $libName = ucfirst($library);
        $libFile = ($libName).".php";
        $libPath = LIB_PATH . $libFile;

        if(file_exists($libPath)) {
            require_once $libPath;

            return new $libName;
        } else {
            App::ErrorPage(" No Library Found ". $libPath);
        }
    }
}