<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Report extends Model {

    function daily_paddy_collection($params=null) {
        $sql = "select po.status as pay_order_issued, pi.collected_amount,pi.collected_rate,p.id as purchase_id,f.name as farmer_name, pc.name as paddy_name from purchase_items pi";
        $sql .=" inner join purchases p on p.id = pi.purchase_id ";
        $sql .=" left join paddy_categories pc on pc.id = pi.paddy_category_id ";
        $sql .=" left join farmers f on f.id = p.farmer_id ";
        $sql .=" left join pay_orders po on po.purchase_id = p.id ";

        $sql .=" where p.status = 1";

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and p.collection_center_id = ".get_assigned_center();
        }

        if($params['from_date']) {
            $sql .=" and p.collection_date >= '".date("Y-m-d", strtotime($params['from_date']))."'";
        }

        if($params['to_date']) {
            $sql .=" and p.collection_date <= '".date("Y-m-d", strtotime($params['to_date']))."'";
        }
        
        $sql .=" order by p.collection_date asc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function cash_received($date1=null, $date2=null, $detail=null) {
        $fields =" sum(cb.amount) as total_received ";
        if($detail) {
            $fields ="cb.amount, cb.received_date as date, cb.id as v_no, cb.notes as description";
        }
        $sql ="select ".$fields." from collection_center_cash_book cb ";
        
        $sql .=" inner join bank_accounts ba on ba.id = cb.bank_account_id ";
        $sql .=" inner join collection_centers cc on cc.id = ba.collection_center_id ";

        $sql .=" where cb.status = 1";

        if(isset($date1)) {
            $sql .=" and cb.received_date >= '".date("Y-m-d", strtotime($date1))."'";
        }

        if(isset($date2)) {
            $sql .=" and cb.received_date <= '".date("Y-m-d", strtotime($date2))."'";
        }

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and cc.id = ".get_assigned_center();
        }

        $query = $this->db->prepare($sql);
        $query->execute();
        if($detail) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $received =  $query->fetch();
            return ($received['total_received']) ? $received['total_received']: 0;
        }
    }

    function cash_issued($includePendingPayOrders=NULL, $date1=null ,$date2=null, $detail=null) {
        $fields =" sum(po.paid_amount) as total_issued ";
        if($detail) {
            $fields =" po.purchase_id as v_no, po.paid_amount as amount, po.paid_date as date, po.pay_notes as description";
        }
        $sql ="select ".$fields." from pay_orders po  ";
        
        $sql .=" right join purchases p on po.purchase_id = p.id";
        
        $sql .=" where p.status = 1";
        
        if(!$includePendingPayOrders) {
            $sql .=" and po.status = 1";
        }

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and p.collection_center_id = ".get_assigned_center();
        }

        if(isset($date1)) {
            $sql .=" and po.paid_date >= '".date("Y-m-d", strtotime($date1))."'";
        }

        if(isset($date2)) {
            $sql .=" and po.paid_date <= '".date("Y-m-d", strtotime($date2))."'";
        }
        
        $query = $this->db->prepare($sql);
        $query->execute();
        
        if($detail) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $issued =  $query->fetch();
            return ($issued['total_issued']) ? $issued['total_issued']: 0;
        }
        
    }


    public function getStocks($centerId=NULL) {
        $sql = "select paddy_categories.name as paddy_name,collection_centers.name as collection_center, collection_center_stocks.available_stock  from collection_center_stocks";
        $sql .=" inner join paddy_categories on paddy_categories.id = collection_center_stocks.paddy_category_id ";
        $sql .=" inner join collection_centers on collection_centers.id = collection_center_stocks.collection_center_id ";
        $sql .=" where paddy_categories.status = 1 and collection_centers.status = 1";

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and collection_center_stocks.collection_center_id = ".get_assigned_center();
        }
        // echo $centerId; exit;

        if(is_numeric($centerId)) {
            $sql .=" and collection_center_stocks.collection_center_id =".$centerId;
        }

        
        $sql .=" order by collection_center_stocks.paddy_category_id asc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    function getTotalCenters() {
        $sql = "SELECT * from collection_centers where status = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->rowCount();
    }

    function getTotalFarmers() {
        $sql = "SELECT * from farmers where status = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->rowCount();
    }

    function getAvailableStock() {
        $sql ="select sum(ccs.available_stock) as total from collection_center_stocks ccs ";
        $sql .=" inner join collection_centers cc on cc.id = ccs.collection_center_id ";
        $sql .=" where cc.status = 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        $data = $query->fetch();

        if($data['total'] > 1000) {
            return ($data['total']/1000)." Mt";
        }

        return $data['total']." Kgs";
    }

    function getPurchaseTotal($date1=null, $date2=null) {
        $sql ="select sum(total_qty) as stock, sum(total_amount) as amount from purchases where status = 1";
        
        if($date1) {
            $sql .=" and collection_date >= '".$date1."'";
        }

        if($date2) {
            $sql .=" and collection_date <= '".$date2."'";
        }
        
        $query = $this->db->prepare($sql);
        $query->execute();
        $data = $query->fetch();

        if($data['stock'] > 1000) {
            return ($data['stock']/1000)." Mt";
        }

        return $data['stock']." Kgs";
    }

    function getSalesTotal($date1=null, $date2=null) {
        $sql ="select sum(total_qty) as stock, sum(total_amount) as amount from sales where status = 1";
        if($date1) {
            $sql .=" and issue_date >= '".$date1."'";
        }

        if($date2) {
            $sql .=" and issue_date <= '".$date2."'";
        }
        
        $query = $this->db->prepare($sql);
        $query->execute();
        $data = $query->fetch();

        if($data['stock'] > 1000) {
            return ($data['stock']/1000)." Mt";
        }

        return $data['stock']." Kgs";
    }

    
}