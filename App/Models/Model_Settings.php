<?php
if ( ! defined('APP_PATH')) exit("Access denied");

Class Model_Settings extends Model {

    function getAppData() {
        $query = $this->db->prepare("SELECT * from app_settings where id=1");
        $query->execute(); 
        return $query->fetch();
    }

    function updateAppData($data=null) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');
        $sql = "UPDATE `app_settings` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `app_name`='".$data['app_name']."', `address`='".$data['address']."', `phone_number`= '".$data['phone_number']."' , `fax_number` = '".$data['fax_number']."', `email_address` = '".$data['email_address']."',  `active_season_id` = '".$data['active_season_id']."',  `currency_symbol` = '".$data['currency_symbol']."'  WHERE `id` = 1" ;
        return $this->db->exec($sql);
    }

    
    function getDailyPrices($start=null, $end=null) {
        $sql = "SELECT id,date,buying_price,selling_price,modified_at,paddy_category_id from paddy_prices where status = 1";

        if($start && $end) {
            $sql .=" and date between '".$start."' and '".$end."'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return $records ? $records : [];
    }

    function getPriceById($id=null) {
        $query = $this->db->prepare("SELECT * from paddy_prices where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function deletePriceById($id=NULL) {
        $sql = "DELETE FROM paddy_prices WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    } 

    function createOrUpdatePrice($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        if($id > 0) {
            $sql = "UPDATE `paddy_prices` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `paddy_category_id`='".$data['paddy_category_id']."', `date`='".$data['date']."', `buying_price`= '".$data['buying_price']."' , `selling_price` = '".$data['selling_price']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO paddy_prices (paddy_category_id,date,buying_price,selling_price,created_by,created_at,modified_by,status) VALUES (:paddy_category_id, :date, :buying_price, :selling_price, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':paddy_category_id' => $data['paddy_category_id'],
                ':date' => $data['date'],
                ':buying_price' => $data['buying_price'], 
                ':selling_price' => $data['selling_price'],
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
                ':status' => 1
            ));
        }
    }

    function priceExists($date=null, $category=NULL) {
        $query = $this->db->prepare("SELECT * from paddy_prices where date='".$date."' and paddy_category_id='".$category."'");
        $query->execute(); 
        return $query->fetch();
    }

    function getPaddyCategories($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,modified_at from paddy_categories where status = 1";

        if($search) {
            $sql .=" and name like '%".$search."%'";
        }

        $sql .=" order by modified_at desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getCategoryById($id=null) {
        $query = $this->db->prepare("SELECT * from paddy_categories where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    public function createOrUpdateCategory($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        if($id > 0) {
            $sql = "UPDATE `paddy_categories` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `name`='".$data['name']."', `description`= '".$data['description']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO paddy_categories (name,description,created_by,created_at,modified_by,status) VALUES (:name, :description, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':name' => $data['name'],
                ':description' => $data['description'], 
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
                ':status' => 1
            ));
        }
    }

    function deleteCategoryById($id=NULL) {
        $sql = "DELETE FROM paddy_categories WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }

    function getPaddySeasons($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,description,period,max_allowed_amount from paddy_seasons";

        if($search) {
            $sql .=" and name like '%".$search."%'";
        }

        $sql .=" order by name desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getSeasonById($id=null) {
        $query = $this->db->prepare("SELECT * from paddy_seasons where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    public function createOrUpdateSeason($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');
        if($id > 0) {
            $sql = "UPDATE `paddy_seasons` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `name`='".$data['name']."', `period`='".$data['period']."', `description`= '".$data['description']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO paddy_seasons (name,period,description,created_by,created_at,modified_by,status) VALUES (:name, :period, :description, :created_by, :created_at, :modified_by, :status)") ;
            return $stm->execute(array(
                ':name' => $data['name'],
                ':period' => $data['period'],
                ':description' => $data['description'],
                ':created_by' => $user_id,
                ':created_at' => $date,
                ':modified_by' => $user_id,
                ':status' => 1
            ));
        }
    }
    
    function deleteSeasonById($id=NULL) {
        $sql = "DELETE FROM paddy_seasons WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }

    function getVehicleTypes($limit=20, $offset=0, $search=null) {
        $sql = "SELECT id,name,description from vehicle_types";

        if($search) {
            $sql .=" and name like '%".$search."%'";
        }

        $sql .=" order by name desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function getVehicleTypeById($id=null) {
        $query = $this->db->prepare("SELECT * from vehicle_types where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    public function createOrUpdateVehicleType($id=NULL, $data=[]) {
        if($id > 0) {
            $sql = "UPDATE `vehicle_types` SET `name`='".$data['name']."', `description`= '".$data['description']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO vehicle_types (name,description) VALUES (:name, :description)") ;
            return $stm->execute(array(
                ':name' => $data['name'],
                ':description' => $data['description']
            ));
        }
    }
    
    function deleteVehicleTypeById($id=NULL) {
        $sql = "DELETE FROM vehicle_types WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $idToDelete = $id;
        $stm->bindParam(':id', $idToDelete);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }

    function getPaddyRateByCategoryAndDate($date=NULL, $category=NULL) {
        $def_price = array("buying_price" => 0,"selling_price" => 0);
        $sql = "SELECT buying_price,selling_price from paddy_prices where paddy_category_id='".$category."' and date='".$date."'";
        $query = $this->db->prepare($sql);
        $query->execute(); 
        $row = $query->fetch();
        return $row ? $row : $def_price;
    }

    function getCashRecordById($id=NULL) {
        $query = $this->db->prepare("SELECT * from collection_center_cash_book where id='".$id."'");
        $query->execute(); 
        return $query->fetch();
    }

    function createOrUpdateCashRecord($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        if($id > 0) {
            $sql = "UPDATE `collection_center_cash_book` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `bank_account_id`='".$data['bank_account_id']."', `amount`= '".$data['amount']."', `notes`='".$data['notes']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO collection_center_cash_book (bank_account_id,amount, notes, created_at,created_by,modified_by, status) VALUES (:bank_account_id, :amount, :notes, :created_at, :created_by, :modified_by, :status)") ;
            return $stm->execute(array(
                ':bank_account_id' => $data['bank_account_id'],
                ':amount' => $data['amount'],
                ':notes' => $data['notes'],
                ':created_at' => $date,
                ':created_by' => $user_id,
                ':modified_by' => $user_id,
                ':status' => 0
            ));
        }
    }

    function getCashRecords($limit=20, $offset=0, $search=null) {
        $sql = "SELECT cc.name as collection_center,cb.id,cb.amount,cb.received_date,cb.modified_at,cb.status from collection_center_cash_book cb ";
        $sql .="left join bank_accounts ba on ba.id = cb.bank_account_id ";
        $sql .="left join collection_centers cc on cc.id = ba.collection_center_id where cb.status != 4";

        if($search) {
            $sql .=" and cb.amount like '%".$search."%'";
        }

        $sql .=" order by cb.id desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function deleteCashRecordById($id=NULL) {
        $sql = "DELETE FROM collection_center_cash_book WHERE id = :id and status <= 0";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':id', $id);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }



    function getBankAccountById($id=NULL) {
        if(isset($id) && $id > 0) {
            $query = $this->db->prepare("SELECT * from bank_accounts where id='".$id."'");
            $query->execute(); 
            return $query->fetch();
        }
        return array();
    }

    function createOrUpdateBankAccount($id=NULL, $data=[]) {
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');

        if($id > 0) {
            $sql = "UPDATE `bank_accounts` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `collection_center_id`='".$data['collection_center_id']."', `bank_account_no`= '".$data['bank_account_no']."', `bank_account_name`='".$data['bank_account_name']."', `bank_and_branch`='".$data['bank_and_branch']."'  WHERE `id` = ".$id ;
            return $this->db->exec($sql);
        } else {
            $stm = $this->db->prepare("INSERT INTO bank_accounts (collection_center_id,bank_account_no, bank_account_name, bank_and_branch, created_at,created_by,modified_by, status) VALUES (:collection_center_id, :bank_account_no, :bank_account_name, :bank_and_branch, :created_at, :created_by, :modified_by, :status)") ;
            return $stm->execute(array(
                ':collection_center_id' => $data['collection_center_id'],
                ':bank_account_no' => $data['bank_account_no'],
                ':bank_account_name' => $data['bank_account_name'],
                ':bank_and_branch' => $data['bank_and_branch'],
                ':created_at' => $date,
                ':created_by' => $user_id,
                ':modified_by' => $user_id,
                ':status' => 0
            ));
        }
    }

    function getBankAccounts($limit=20, $offset=0, $search=null) {
        $sql = "SELECT c.name as collection_center,ba.id,ba.bank_account_no,ba.bank_account_name,ba.bank_and_branch,ba.modified_at from bank_accounts ba ";
        $sql .="left join collection_centers c on c.id = ba.collection_center_id where ba.status != 4";

        if($search) {
            $sql .=" and ba.bank_account_no like '%".$search."%'";
        }

        $sql .=" order by ba.id desc";

        $query = $this->db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        $query->execute(array(":limit" => $limit));
        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        return array("count"=>$count, "data"=>$records);
    }

    function deleteBankAccountById($id=NULL) {
        $sql = "DELETE FROM bank_accounts WHERE id = :id and status <= 0";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':id', $id);
        $stm->execute();

        if(!$stm->rowCount()) {
            return false;
        }

        return true;
    }

    function updateSeasonalBuying($data=null) {
        $count = count($data['maxlimit']);
        $updated = [];
        $date = date("Y-m-d h:i:s");
        $user_id  = get_session('user_id');
        foreach($data['maxlimit'] as $index=>$row) {
            $limit = $row;
            $id = $data['id'][$index];
            $sql = "UPDATE `paddy_seasons` SET `modified_at`= '".$date."', `modified_by`='".$user_id."', `max_allowed_amount`='".$limit."'  WHERE `id` = ".$id ;
            $updated[$index] =  $this->db->exec($sql);
        }
        $upcount = count($updated);
        return $count === $upcount;
    }
}