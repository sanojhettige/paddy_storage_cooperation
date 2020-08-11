

<form method="post" action="" id="saleForm">
  <div class="row">
  <div class="form-group col-md-3">
    <label for="buyer_id">Buyer</label>
    <select class="form-control" name="buyer_id" id="buyer_id">
      <option value="">Select Buyer</option>
      <?php foreach($buyers as $item) { ?>
        <?php if(get_post('buyer_id') === $item['id'] || $record['buyer_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message buyer_id"><?= isset($errors["buyer_id"]) ? $errors["buyer_id"]: ""; ?></span>
  </div>

  <div class="form-group col-md-3">
    <label for="collection_center_id">Issue Center</label>
    <select class="form-control" name="collection_center_id" id="collection_center_id">
      <option value="">Select Type</option>
      <?php foreach($collection_centers as $item) { ?>
        <?php if(get_post('collection_center_id') === $item['id'] || $record['collection_center_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message collection_center_id"><?= isset($errors["collection_center_id"]) ? $errors["collection_center_id"]: ""; ?></span>
  </div>
  <div class="form-group col-md-3">
    <label for="collection_date">Issue Date</label>
    <input type="text" required value="<?= get_post('collection_date') ? get_post('collection_date') : ($record['issue_date'] ? date("Y-m-d", strtotime($record['issue_date'])) : ''); ?>" class="form-control datetimepicker" id="collection_date" data-date-format="yyyy-mm-dd" name="collection_date">
    <span class="error-message collection_date"><?= isset($errors["collection_date"]) ? $errors["collection_date"]: ""; ?></span>
  </div>
  <div class="form-group col-md-3">
    <label for="status_id">Sale Status</label>
    <select class="form-control" name="status_id" id="status_id">
      <option value="">Select Type</option>
      <?php foreach(sale_status() as $item) { ?>
        <?php if(get_post('status_id') === $item['id'] || $record['sale_status_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message status_id"><?= isset($errors["status_id"]) ? $errors["status_id"]: ""; ?></span>
  </div>

        </div>

        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-primary pull-right addItem">Add Item</button>
            <br/>
            <br/>
        </div>
        
        <div class="col-md-12">
          <table class="table">
            <thead>
              <th width="5%">#</th>
              <th width="30%">Paddy Type</th>
              <th width="20%">Qty (Kg)</th>
              <th width="20%">Selling price</th>
              <th width="25%">Total</th>
              <th></th>
            </thead>
            <tbody class="itemList">
              <?php foreach($record['items'] as $row) { ?> 
              <tr class="saleItem">
                  <td></td>
                  <td>
                    
                    <select class="form-control paddy_type" name="item[paddy_type][]">
                      <?php foreach($paddy_types as $paddy) {
                          if($row['paddy_category_id'] == $paddy['id'])
                          echo "<option selected value='".$paddy['id']."'>".$paddy['name']."</option>";
                          else
                            echo "<option value='".$paddy['id']."'>".$paddy['name']."</option>";
                      } ?>
                    </select>

                  </td>
                  <td>
                    <input class="form-control" value="<?= $row['sold_amount']; ?>" type="number" name="item[qty][]">
                  </td>
                  <td>
                  <span class="input-group-prepend">
                    <input class="form-control" value="<?= $row['sold_rate']; ?>" readonly type="number" name="item[price][]">
                    <div class="input-group-text price-reload">
                      <i class="fa fa-refresh"></i>
                    </div>          
                  </span>

                  <input type="hidden" name="item[id][]" value="<?= $row['id']; ?>">
                  <input class="form-control" value="<?= $row['sold_amount']; ?>" type="hidden" name="item[qty_org][]">
                  </td>
                  <td></td>
                  <td>
                  <button type="button" class="btn btn-sm btn-danger remove_row">Remove</button>
                  </td>
        </tr>
                    <?php } ?>
        </tbody>
        <tfooter>
                      <tr class="total">
                      <td colspan="4"></td>
                        <td>00.00</td>
                      </tr>
        </tfooter>
          </table>
        </div>

        <div class="col-md-12">

        <label for="notes">Notes</label>
    <textarea class="form-control" id="notes" name="notes" rows="4"><?= get_post('notes') ? get_post('notes') : ($record ? $record['sales_notes'] : ''); ?></textarea>

                    </div>
          </div>
          
          <br/><br />

          <span class="error-message item form_error"></span>
<br/><br/>
  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>