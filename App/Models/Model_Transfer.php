<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Transfer extends Model {
    private $table = "transfers";

    function getTransfers($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,transfer_date,modified_at from ".$this->table." p ";
        $sql .=" where status = 1";

        if($search) {
            $sql .=" and p.id like '%".$search."%'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getTransferById($id=null) {
        $purchase = array();
        $query = $this->db->prepare("SELECT * from ".$this->table." where id='".$id."'");
        $query->execute(); 
        $purchase = $query->fetch();

        $items_query = $this->db->prepare("SELECT * from transfer_items where transfer_id='".$id."'");
        $items_query->execute();
        $items = $items_query->fetchAll(PDO::FETCH_ASSOC); 
        return array_merge($purchase,array('items'=>$items));
    }

    function deleteTransferById($id=NULL) {
        $date = date("Y-m-d h:i:s");
        $sql = "UPDATE `".$this->table."` SET `status`='4', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
        $saleUpdated = $this->db->exec($sql);
        $sale = $this->getTransferById($id);

        foreach($sale['items'] as $row) {
            $sql = "UPDATE transfer_items SET `status`='4' WHERE `id` = ".$row['id'] ;
            $updated = $this->db->exec($sql);
        }

        if(!$saleUpdated) {
            return false;
        }

        return true;
    }

    function createOrUpdateRecord($id=NULL, $data=[]) {
        if($id > 0) {
            $date = date("Y-m-d h:i:s");
            $sql = "UPDATE `".$this->table."` SET `to_center_id`='".$data['to_center_id']."', `from_center_id`= '".$data['from_center_id']."' , `transfer_date` = '".$data['transfer_date']."' , `transfer_notes` = '".$data['notes']."', `transfer_status_id`= '".$data['status_id']."', `vehicle_id`= '".$data['vehicle_id']."', `modified_at`= '".$date."'  WHERE `id` = ".$id ;
            $resp =  $this->db->exec($sql);
            if($resp) {
                $this->createOrUpdateItems($id, $data['item']);
                return $id;
            } else {
                return false;
            }
            
        } else {
            $stm = $this->db->prepare("INSERT INTO ".$this->table." (to_center_id,from_center_id,transfer_date,transfer_notes,transfer_status_id,vehicle_id,created_by,created_at,modified_by,status) VALUES (:to_center_id, :from_center_id, :transfer_date, :transfer_notes, :transfer_status_id, :vehicle_id, :created_by, :created_at, :modified_by, :status)") ;
            $resp = $stm->execute(array(
                ':to_center_id' => $data['to_center_id'],
                ':from_center_id' => $data['from_center_id'], 
                ':transfer_date' => $data['transfer_date'],  
                ':transfer_notes' => $data['notes'],
                ':vehicle_id' => $data['vehicle_id'],
                ':transfer_status_id' => $data['status_id'],
                ':created_by' => $_SESSION['user_id'],
                ':created_at' => date("Y-m-d h:i:s"),
                ':modified_by' => $_SESSION['user_id'],
                ':status' => 1
            ));
            if($resp) {
                $id = $this->db->lastInsertId();
                $this->createOrUpdateItems($id, $data['item'],$data['status_id'], $data['to_center_id'], $data['from_center_id']);
                return $id;
            } else {
                return false;
            }
        }
    }


    private function createOrUpdateItems($pId=NULL, $items=NULL, $status=null, $to_center=null, $from_center=null) {
        $sql = "DELETE FROM transfer_items WHERE transfer_id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':id', $pId);
        $stm->execute();
        $idata = array();
        
        $sql = "INSERT INTO transfer_items (transfer_id,paddy_category_id,transfer_amount) VALUES ";
        $n = 0;
        $query = array();
        $iData = array();
        $itemRows = array();
        foreach ($items['paddy_type'] as $index=>$item) {
            $query = '(:transfer_id' . $n . ', :paddy_category_id' . $n . ', :transfer_amount' . $n . ')';

            $iData['transfer_id' . $n] = $pId;
            $iData['paddy_category_id' . $n] = $item;
            $iData['transfer_amount' . $n] = $items['qty'][$index];

            $stmt = $this->db->prepare($sql." ".$query);
            $itemRows[$n] =  $stmt->execute($iData);
            if($itemRows && $status === 2) {
                $this->updateStock($items['qty_org'][$index],$items['qty'][$index], $item, $to_center,'add');
                $this->updateStock($items['qty_org'][$index],$items['qty'][$index], $item, $from_center,'remove');
            }
            $n += 1;
        }
        return $itemRows;
    }

    function updateStock($org_qty=0, $qty=0, $category=null, $center=null, $type="add") {
        $date = date("Y-m-d h:i:s");
        $newStock = 0;
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

}