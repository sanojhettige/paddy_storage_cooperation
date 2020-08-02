<?php
if ( ! defined('APP_PATH')) exit("Access denied");

class Model {
    public $db;

    public function __construct() {
        try {
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4;port=".DB_PORT;

            $this->db = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        } catch(\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function load($model) {
        $modelName = ucfirst($model);
        $modelFile = ucfirst($modelName).".php";
        $modelPath = MODEL_PATH . $modelFile;

        if(file_exists($modelPath)) {
            include $modelPath;

            return new $modelName;
        } else {
            App::ErrorPage("No Model Found");
        }
    }

    public function get_data() {

    }
}
