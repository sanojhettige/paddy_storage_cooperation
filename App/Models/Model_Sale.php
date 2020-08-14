<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Sale extends Model {
    private $table = "sales";

    function getSales($limit=20, $offset=0, $search=null, $type=null) {
        $center_id = get_assigned_center();
        $sql = "SELECT s.id,s.customer_id,c.name as buyer_name, cc.name as collection_center, s.collection_center_id,s.issue_date,s.modified_at,s.sale_status_id from ".$this->table." s ";
        $sql .=" left join customers c on c.id = s.customer_id";
        $sql .=" left join collection_centers cc on cc.id = s.collection_center_id";

        $sql .=" where s.status = 1";

        if($search) {
            $sql .=" and f.name like '%".$search."%' or c.name like '%".$search."%' or s.id like '%".$search."%'";
        }

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            if($type === "collections") {
                $sql .=" and s.collection_center_id = ".$center_id;
            } elseif($type === "issues") {
                $sql .=" and s.collection_center_id = ".$center_id;
            }
        }

        $sql .=" order by s.modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getSaleById($id=null) {
        $sale = array();
        $sql1 ="SELECT s.*, c.name as customer_name, cc.name as collection_center from ".$this->table." s ";
        $sql1 .=" left join customers c on c.id = s.customer_id ";
        $sql1 .=" left join collection_centers cc on cc.id = s.collection_center_id ";
        $sql1 .=" where s.id='".$id."'";
        $query = $this->db->prepare($sql1);
        $query->execute(); 
        $sale = $query->fetch();

        $sql = "SELECT si.*, pc.name as paddy_name from sale_items si ";
        $sql .=" left join paddy_categories pc on pc.id = si.paddy_category_id";
        $sql .=" where si.sale_id='".$id."'";
        $items_query = $this->db->prepare($sql);
        $items_query->execute();
        $items = $items_query->fetchAll(PDO::FETCH_ASSOC); 
        return array_merge($sale,array('items'=>$items));
    }

    function deleteSaleById($id=NULL) {
        
        $date = date("Y-m-d h:i:s");
        $sql = "UPDATE `".$this->table."` SET `status`='4', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
        $saleUpdated = $this->db->exec($sql);
        $sale = $this->getSaleById($id);

        foreach($sale['items'] as $row) {
            $sql = "UPDATE sale_items SET `status`='4' WHERE `id` = ".$row['id'] ;
            $updated = $this->db->exec($sql);

            if($updated) {
                $this->updateStock(0, $row['sold_amount'], $row['paddy_category_id'], $sale['collection_center_id'],'add');
            }
        }

        if(!$saleUpdated) {
            return false;
        }

        return true;
    }

    function createOrUpdateRecord($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        if($id > 0) {
            $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `customer_id`='".$data['buyer_id']."', `collection_center_id`= '".$data['collection_center_id']."' , `issue_date` = '".$data['collection_date']."' , `sale_notes` = '".$data['notes']."', `sale_status_id`='".$data['status_id']."', `total_amount`='".$data['total_amount']."', `total_qty`='".$data['total_qty']."'  WHERE `id` = ".$id ;
            $resp =  $this->db->exec($sql);
            if($resp) {
                $this->createOrUpdateItems($id, $data['item'], $data['collection_center_id']);
                return $id;
            } else {
                return false;
            }
            
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (customer_id,collection_center_id,issue_date,sale_notes,total_amount,total_qty,sale_status_id,created_by,created_at,modified_by,status) VALUES (:customer_id, :collection_center_id, :issue_date, :sale_notes, :total_amount, :total_qty, :sale_status_id, :created_by, :created_at, :modified_by, :status)") ;
            $resp = $stm->execute(array(
                ':customer_id' => $data['buyer_id'],
                ':collection_center_id' => $data['collection_center_id'], 
                ':issue_date' => $data['collection_date'],  
                ':sale_notes' => $data['notes'],
                ':sale_status_id' => $data['status_id'],
                ':total_amount' => $data['total_amount'],
                ':total_qty' => $data['total_qty'],
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
                ':status' => 1
            ));
            if($resp) {
                $id = $this->db->lastInsertId();
                $this->createOrUpdateItems($id, $data['item'], $data['status_id'], $data['collection_center_id']);
                return $id;
            } else {
                return false;
            }
        }
    }


    private function createOrUpdateItems($sId=NULL, $items=NULL, $status =null, $center_id=null) {
        $sql = "DELETE FROM sale_items WHERE sale_id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':id', $sId);
        $stm->execute();
        $idata = array();
        
        $sql = "INSERT INTO sale_items (sale_id,paddy_category_id,sold_amount,sold_rate,notes) VALUES ";
        $n = 0;
        $query = array();
        $iData = array();
        foreach ($items['paddy_type'] as $index=>$item) {
            $query = '(:sale_id' . $n . ', :paddy_category_id' . $n . ', :sold_amount' . $n . ', :sold_rate' . $n . ', :notes' . $n . ')';

            $iData['sale_id' . $n] = $sId;
            $iData['paddy_category_id' . $n] = $item;
            $iData['sold_amount' . $n] = $items['qty'][$index];
            $iData['sold_rate' . $n] = $items['price'][$index];
            $iData['notes' . $n] = "";

            $stmt = $this->db->prepare($sql." ".$query);
            $itemRows[$n] =  $stmt->execute($iData);
            if($itemRows && $status === 2) {
                $this->updateStock($items['qty_org'][$index], $items['qty'][$index], $item, $center_id, 'remove');
            }
            $n += 1;
        }
    }


    function updateStock($org_qty=0, $qty=0, $category=null, $center=null, $type='remove') {
        $date = date("Y-m-d h:i:s");
        $newStock = 0;
        if($category > 0 && $qty > 0) {
            $query = $this->db->prepare("SELECT * from paddy_categories where id='".$category."'");
            $query->execute(); 
            $stock = $query->fetch();
            if($type === "add") {
                $newStock = ($stock) ? (($stock['available_stock'] - $org_qty) + $qty) : $qty;
            } else {
                $newStock = ($stock) ? (($stock['available_stock'] + $org_qty) - $qty) : $qty;
            }

            $sql = "UPDATE `paddy_categories` SET `available_stock`='".$newStock."', `modified_at`= '".$date."'  WHERE `id` = ".$category ;
            $this->db->exec($sql);

        }

        if($category > 0 && $qty > 0 && $center > 0) {
            $query = $this->db->prepare("SELECT * from collection_center_stocks where collection_center_id='".$center."' and paddy_category_id='".$category."'");
            $query->execute(); 
            $stock = $query->fetch();

            if($newStock <= 0) {
                if($type === "add") {
                    $newStock = ($stock) ? (($stock['available_stock'] - $org_qty) + $qty) : $qty;
                } else {
                    $newStock = ($stock) ? (($stock['available_stock'] + $org_qty) - $qty) : -$qty;
                }
            }

            if($stock) {
                $sql = "UPDATE `collection_center_stocks` SET `available_stock`='".$newStock."'  WHERE `collection_center_id`='".$center."' and `paddy_category_id` = ".$category ;
                $this->db->exec($sql);
            } else {
                $stm = $this->db->prepare("INSERT INTO collection_center_stocks (available_stock,collection_center_id,paddy_category_id) VALUES (:available_stock, :collection_center_id, :paddy_category_id)") ;
                $resp = $stm->execute(array(
                    ':available_stock' => $newStock,
                    ':collection_center_id' => $center, 
                    ':paddy_category_id' => $category
                ));
            }
        }
    }


    public function doUpdateSaleStatus($id=NULL, $status_id=NULL) {
        $date = date("Y-m-d h:i:s");
        $user_id = get_session('user_id');
        $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `sale_status_id`= '".$status_id."'  WHERE `id` = ".$id ;
        $resp =  $this->db->exec($sql);
        if($resp) {
            $sale = $this->getSaleById($id);
            
            foreach($trf['items'] as $item) {
                $this->updateStock($item['sold_amount'],$item['sold_amount'], $item['paddy_category_id'], $sale['collection_center_id'],'remove');
            }

            return true;
        }
        return false;
    }

}