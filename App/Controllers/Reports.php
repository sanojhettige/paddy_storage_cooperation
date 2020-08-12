<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Reports extends Controller {
    
    public function index($param=null) {
        $this->view->render("reports/index", "template", $this->data);
    }

    public function paddy_collection($param=null) {
        $this->data['title'] = "Daily Paddy Collection";

        $this->data['assets'] = array(
            'css'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css',
            ),
            'js'=>array(
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js',
                BASE_URL.'/assets/js/reports.js'
            )
        );
        
        $this->view->render("reports/paddy_collection", "template", $this->data);
    }

    private function get_paddy_collection() {
        $report_model = $this->load->model('report');
        $data = $report_model->daily_paddy_collection($_POST);
    }

    public function cash_book($param=null) {
        $this->data['title'] = "Cash Book";
        $this->view->render("reports/cash_book", "template", $this->data);
    }
}