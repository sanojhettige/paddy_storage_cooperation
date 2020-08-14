<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Dashboard extends Controller {
    
    public function index($param=null) {
        $today = date("Y-m-d");
        $month_start = date("Y-m-01");
        $month_end = date("Y-m-31");
        $year_start = date("Y-01-01");
        $year_end = date("Y-12-31");

        $report_model = $this->model->load('report');
        $this->data['totalCenters'] = $report_model->getTotalCenters();
        $this->data['totalFarmers'] = $report_model->getTotalFarmers();
        $this->data['totalCategories'] = $report_model->getTotalFarmers();
        $this->data['availableStock'] = $report_model->getAvailableStock();
        $this->data['todayPurchase'] = $report_model->getPurchaseTotal($today, $today);
        $this->data['monthPurchase'] = $report_model->getPurchaseTotal($month_start, $month_end);
        $this->data['yearPurchase'] = $report_model->getPurchaseTotal($year_start, $year_end);
        $this->data['todaySales'] = $report_model->getSalesTotal($today, $today);
        $this->data['monthSales'] = $report_model->getSalesTotal($month_start, $month_end);
        $this->data['yearSales'] = $report_model->getSalesTotal($year_start, $year_end);
        $this->view->render("index", "template", $this->data);
    }
}