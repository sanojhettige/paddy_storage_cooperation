<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Transfer extends Model {
    private $table = "transfers";

    function getTransfers($limit=20, $offset=0, $search=null, $type=null) {
        $center_id = get_session("assigned_center");
        $sql = "SELECT id,transfer_date,modified_at,from_center_id,to_center_id,transfer_status_id from ".$this->table." p ";
        $sql .=" where status = 1";

        if($search) {
            $sql .=" and id like '%".$search."%'";
        }

        if(in_array(get_user_role(), array(2,3,4,5,6))) {
            if($type === "collections") {
                $sql .=" and to_center_id = ".$center_id;
            } elseif($type === "issues") {
                $sql .=" and from_center_id = ".$center_id;
            }
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
        $transfer = array();
        $sql1 = "SELECT t.*, v.registration_number, cc1.name from_center, cc2.name as to_center from ".$this->table." t";
        $sql1 .=" left join vehicles v on v.id = t.vehicle_id ";
        $sql1 .=" left join collection_centers cc1 on cc1.id = t.from_center_id ";
        $sql1 .=" left join collection_centers cc2 on cc2.id = t.to_center_id ";
        $sql1 .=" where t.id='".$id."'";
        $query = $this->db->prepare($sql1);
        $query->execute(); 
        $transfer = $query->fetch();

        $sql2 = "SELECT ti.*, pc.name as paddy_name from transfer_items ti ";
        $sql2 .=" left join paddy_categories pc on pc.id = ti.paddy_category_id";
        $sql2 .=" where ti.transfer_id='".$id."'";
        $items_query = $this->db->prepare($sql2);
        $items_query->execute();
        $items = $items_query->fetchAll(PDO::FETCH_ASSOC);
        return array_merge($transfer,array('items'=>$items));
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
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        if($id > 0) {
            $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `to_center_id`='".$data['to_center_id']."', `from_center_id`= '".$data['from_center_id']."' , `transfer_date` = '".$data['transfer_date']."' , `transfer_notes` = '".$data['notes']."', `transfer_status_id`= '".$data['status_id']."', `vehicle_id`= '".$data['vehicle_id']."'  WHERE `id` = ".$id ;
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
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
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
            if($itemRows && $status === 3)  // 3 = stock received
            {
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

    public function doUpdateTransferStatus($id=NULL, $status_id=NULL) {
        $date = date("Y-m-d h:i:s");
        $user_id = get_session('user_id');
        $sql = "UPDATE `".$this->table."` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `transfer_status_id`= '".$status_id."'  WHERE `id` = ".$id ;
        $resp =  $this->db->exec($sql);
        if($resp) {
            $trf = $this->getTransferById($id);
            
            foreach($trf['items'] as $item) {
                $this->updateStock($item['transfer_amount'],$item['transfer_amount'], $item['paddy_category_id'], $trf['to_center_id'],'add');
                $this->updateStock($item['transfer_amount'],$item['transfer_amount'], $item['paddy_category_id'], $trf['from_center_id'],'remove');
            }

            return true;
        }
        return false;
    }

}