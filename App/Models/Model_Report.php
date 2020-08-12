<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Report extends Model {

    function daily_paddy_collection($params=null) {
        $sql = "select po.id as pay_order_issued,pi.collected_amount,pi.collected_rate,p.id as purchase_id,f.name as farmer_name, pc.name as paddy_name from purchase_items pi";
        $sql .=" inner join purchases p on p.id = pi.purchase_id ";
        $sql .=" left join paddy_categories pc on pc.id = pi.paddy_category_id ";
        $sql .=" left join farmers f on f.id = p.farmer_id ";
        $sql .=" left join pay_orders po on po.purchase_id = p.id ";

        $sql .=" where p.status = 1";

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and p.collection_center_id = ".get_assigned_center();
        }

        if($params['from_date']) {
            $sql .=" and p.collection_date >= '".date("Y-m-d", strtotime(get_post('from_date')))."'";
        }

        if($params['to_date']) {
            $sql .=" and p.collection_date <= '".date("Y-m-d", strtotime(get_post('to_date')))."'";
        }

        $sql .=" order by p.collection_date asc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function cash_received() {
        $sql ="select sum(cb.amount) as total_received from collection_center_cash_book cb ";
        $sql .=" inner join bank_accounts ba on ba.id = cb.bank_account_id ";
        $sql .=" inner join collection_centers cc on cc.id = ba.collection_center_id ";

        $sql .=" where cb.status = 1";

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and cc.id = ".get_assigned_center();
        }

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute();
        $received = $query->fetch();
        return ($received['total_received']) ? $received['total_received']: 0;
    }

    function cash_issued() {
        $sql ="select sum(po.paid_amount) as total_issued from pay_orders po ";
        $sql .=" inner join purchases p on p.id = po.purchase_id ";
        
        $sql .=" where p.status = 1 and po.status = 1";

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and p.collection_center_id = ".get_assigned_center();
        }

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute();
        $issued =  $query->fetch();
        return ($issued['total_issued']) ? $issued['total_issued']: 0;
    }

}