<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Purchase extends Model {
    private $table = "purchases";

    function getPurchases($limit=20, $offset=0, $search=null) {
        $sql = "SELECT p.id,p.farmer_id,f.name as farmer_name, c.name as collection_center, p.collection_center_id,p.collection_date,p.modified_at from ".$this->table." p ";
        $sql .=" left join farmers f on f.id = p.farmer_id";
        $sql .=" left join collection_centers c on c.id = p.collection_center_id";

        $sql .=" where p.status = 1";

        if($search) {
            $sql .=" and f.name like '%".$search."%' or c.name like '%".$search."%' or p.id like '%".$search."%'";
        }

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            $sql .=" and p.collection_center_id = ".get_assigned_center();
        }

        $sql .=" order by p.modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getPurchaseById($id=null) {
        $purchase = array();
        $sql1 ="SELECT p.*, f.name as farmer_name,f.nic_no,f.address, cc.name as collection_center from ".$this->table." p ";
        $sql1 .=" left join farmers f on f.id = p.farmer_id ";
        $sql1 .=" left join collection_centers cc on cc.id = p.collection_center_id ";
        $sql1 .=" where p.id='".$id."'";
        $query = $this->db->prepare($sql1);
        $query->execute(); 
        $purchase = $query->fetch();

        $sql2 = "SELECT pi.*, pc.name as paddy_name from purchase_items pi ";
        $sql2 .=" left join paddy_categories pc on pc.id = pi.paddy_category_id";
        $sql2 .=" where pi.purchase_id='".$id."'";
        $items_query = $this->db->prepare($sql2);
        $items_query->execute();
        $items = $items_query->fetchAll(PDO::FETCH_ASSOC);
        return array_merge($purchase,array('items'=>$items));
    }

    function deletePurchaseById($id=NULL) {
        $date = date("Y-m-d h:i:s");
        $sql = "UPDATE `".$this->table."` SET `status`='4', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
        $saleUpdated = $this->db->exec($sql);
        $sale = $this->getPurchaseById($id);

        foreach($sale['items'] as $row) {
            $sql = "UPDATE purchase_items SET `status`='4' WHERE `id` = ".$row['id'] ;
            $updated = $this->db->exec($sql);

            if($updated) {
                $this->updateStock(0, $row['collected_amount'], $row['paddy_category_id'], $sale['collection_center_id'],'remove');
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
            $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `farmer_id`='".$data['farmer_id']."', `collection_center_id`= '".$data['collection_center_id']."' , `collection_date` = '".$data['collection_date']."' , `purchase_notes` = '".$data['notes']."', `total_amount`='".$data['total_amount']."', `total_qty`='".$data['total_qty']."'  WHERE `id` = ".$id ;
            $resp =  $this->db->exec($sql);
            if($resp) {
                $this->createOrUpdateItems($id, $data['item']);
                return $id;
            } else {
                return false;
            }
            
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (farmer_id,collection_center_id,collection_date,purchase_notes,total_amount,total_qty,created_by,created_at,modified_by,status) VALUES (:farmer_id, :collection_center_id, :collection_date, :purchase_notes,:total_amount, :total_qty, :created_by, :created_at, :modified_by, :status)") ;
            $resp = $stm->execute(array(
                ':farmer_id' => $data['farmer_id'],
                ':collection_center_id' => $data['collection_center_id'], 
                ':collection_date' => $data['collection_date'],  
                ':purchase_notes' => $data['notes'],
                ':total_amount' => $data['total_amount'],
                ':total_qty' => $data['total_qty'],
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
                ':status' => 1
            ));
            if($resp) {
                $id = $this->db->lastInsertId();
                $purchase = $this->getPurchaseById($id);
                $this->createOrUpdateItems($id, $data['item'], $data['collection_center_id']);
                $this->createOrUpdatePayOrder($purchase, array(
                    'paid_amount'=>$data['total_amount'],
                    'paid_date'=>$date,
                    'pay_notes'=>""
                ), 0);
                return $id;
            } else {
                return false;
            }
        }
    }


    private function createOrUpdateItems($pId=NULL, $items=NULL, $center_id=null) {
        $sql = "DELETE FROM purchase_items WHERE purchase_id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':id', $pId);
        $stm->execute();
        $idata = array();
        
        $sql = "INSERT INTO purchase_items (purchase_id,paddy_category_id,collected_amount,collected_rate,notes) VALUES ";
        $n = 0;
        $query = array();
        $iData = array();
        $itemRows = array();
        foreach ($items['paddy_type'] as $index=>$item) {
            $query = '(:purchase_id' . $n . ', :paddy_category_id' . $n . ', :collected_amount' . $n . ', :collected_rate' . $n . ', :notes' . $n . ')';

            $iData['purchase_id' . $n] = $pId;
            $iData['paddy_category_id' . $n] = $item;
            $iData['collected_amount' . $n] = $items['qty'][$index];
            $iData['collected_rate' . $n] = $items['price'][$index];
            $iData['notes' . $n] = "";

            $stmt = $this->db->prepare($sql." ".$query);
            $itemRows[$n] =  $stmt->execute($iData);
            if($itemRows) {
                $this->updateStock($items['qty_org'][$index],$items['qty'][$index], $item, $center_id,'add');
            }
            $n += 1;
        }
        return $itemRows;
    }

    function updateStock($org_qty=0, $qty=0, $category=null, $center=null, $type="add") {
        $date = date("Y-m-d h:i:s");
        $newStock = 0;
        if($category > 0 && $qty > 0) {
            $query = $this->db->prepare("SELECT * from paddy_categories where id='".$category."'");
            $query->execute(); 
            $stock = $query->fetch();
            if($type === "add") {
                $newStock = ($stock) ? (($stock['available_stock'] - $org_qty) + $qty) : $qty;
            } else {
                $newStock = ($stock) ? (($stock['available_stock'] + $org_qty) - $qty) : -$qty;
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

    function createOrUpdatePayOrder($purchase=null, $data=null, $status=1) {
        $exists = $this->getPayOrderByPurchaseId($purchase['id']);
        if($exists) {
            $date = date("Y-m-d h:i:s");
            $sql = "UPDATE `pay_orders` SET `farmer_user_id`='".$purchase['farmer_id']."', `purchase_id`= '".$purchase['id']."' , `paid_amount` = '".$data['paid_amount']."' , `paid_date` = '".$data['paid_date']."',`pay_notes`= '".$data['pay_notes']."',  `modified_at`= '".$date."', `status`='".$status."' WHERE `purchase_id` = ".$purchase['id'] ;
            $resp =  $this->db->exec($sql);
            return $purchase['id'];
            
        } else {
            $stm = $this->db->prepare("INSERT INTO pay_orders (farmer_user_id,purchase_id,paid_amount,paid_date,pay_notes,created_by,created_at,modified_by,status) VALUES (:farmer_user_id, :purchase_id, :paid_amount, :paid_date,  :pay_notes, :created_by, :created_at, :modified_by, :status)") ;
            $resp = $stm->execute(array(
                ':farmer_user_id' => $purchase['farmer_id'],
                ':purchase_id' => $purchase['id'], 
                ':paid_amount' => $data['paid_amount'],  
                ':paid_date' => $data['paid_date'],
                ':pay_notes' => $data['pay_notes'],
                ':created_by' => get_session('user_id'),
                ':created_at' => date("Y-m-d h:i:s"),
                ':modified_by' => get_session('user_id'),
                ':status' => $status
            ));
            if($resp) {
                return $this->db->lastInsertId();
            } else {
                return false;
            }
        }
    }

    function getPayOrderByPurchaseId($id=NULL) {
        $query = $this->db->prepare("SELECT * from pay_orders where purchase_id='".$id."'");
        $query->execute();
        return $query->fetch();
    }

}