<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Reports extends Controller {
    
    public function index($param=null) {
        $this->view->render("reports/index", "template", $this->data);
    }

    public function paddy_collection($param=null) {
        $this->data['title'] = "Daily Paddy Collection";
        $this->data['report']= array();
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

        $report_model = $this->model->load('report');

        $data = $_POST;
        if(!$_POST) {
            $data['from_date'] = date("Y-m-01");
            $data['to_date'] = date("Y-m-31");
        }

        $this->data['dates'] = $data;

        $this->data['report'] = $report_model->daily_paddy_collection($data);
        
        $this->view->render("reports/paddy_collection", "template", $this->data);
    }


    public function cash_book($param=null) {
        $this->data['title'] = "Cash Book";
        $report_model = $this->model->load('report');
        $this->data['received_total'] = $report_model->cash_received();
        $this->data['cash_issued_total'] = $report_model->cash_issued();
        $this->data['balance'] = ($this->data['received_total'] - $this->data['cash_issued_total']);
        $this->data['received'] = $report_model->cash_received(null,null, true);
        $this->data['cash_issued'] = $report_model->cash_issued(false,null,null,true);
        $this->data['bf_amount'] = 0;
        $this->view->render("reports/cash_book", "template", $this->data);
    }

    public function stocks($centerId=null) {
        $this->data['title'] = "Stock Report";
        $report_model = $this->model->load('report');
        $cc_model = $this->model->load('collectionCenter');
        $this->data['collection_centers'] = $cc_model->getCollectionCentersDropdownData();

        $ccId = get_post('collection_center_id') ? get_post('collection_center_id'): ($centerId ? $centerId: null);
        $this->data['report'] = $report_model->getStocks($ccId);

        if($centerId != null) {
            $pdf = $this->library->load('tcpdf');
            $settings_model = $this->model->load('settings');
            $this->data['app_data'] = $settings_model->getAppData();
            $this->data['centerId'] = $centerId;
            $this->view->render("reports/print_stock_report", "print_template", $this->data);
        } else {
            $this->view->render("reports/stock_report", "template", $this->data);
        }
    }

    public function farmers() {
        
    }
}