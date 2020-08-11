

<form method="post" action="" id="transferForm">
  <div class="row">
  <div class="form-group col-md-4">
    <label for="from_center_id">From</label>
    <select class="form-control" name="from_center_id" id="from_center_id">
      <option value="">Select</option>
      <?php foreach($collection_centers as $item) { ?>
        <?php if(get_post('from_center_id') === $item['id'] || $record['from_center_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message from_center_id"><?= isset($errors["from_center_id"]) ? $errors["from_center_id"]: ""; ?></span>
  </div>
  <div class="form-group col-md-4">
    <label for="to_center_id">To Center</label>
    <select class="form-control" name="to_center_id" id="to_center_id">
      <option value="">Select</option>
      <?php foreach($collection_centers as $item) { ?>
        <?php if(get_post('to_center_id') === $item['id'] || $record['to_center_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message to_center_id"><?= isset($errors["to_center_id"]) ? $errors["to_center_id"]: ""; ?></span>
  </div>
  <div class="form-group col-md-4">
    <label for="transfer_date">Transfer Date</label>
    <input type="text" required value="<?= get_post('transfer_date') ? get_post('transfer_date') : ($record['transfer_date'] ? $record['transfer_date'] : ''); ?>" class="form-control datetimepicker" id="transfer_date" data-date-format="yyyy-mm-dd" name="transfer_date">
    <span class="error-message transfer_date"><?= isset($errors["transfer_date"]) ? $errors["transfer_date"]: ""; ?></span>
  </div>
  <div class="form-group col-md-6">
    <label for="vehicle_id">Assigned Vehicle</label>
    <select class="form-control" name="vehicle_id" id="vehicle_id">
      <option value="">Select</option>
      <?php foreach($vehicles as $item) { ?>
        <?php if(get_post('vehicle_id') === $item['id'] || $record['vehicle_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['reg_no']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['reg_no']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message status_id"><?= isset($errors["status_id"]) ? $errors["status_id"]: ""; ?></span>
  </div>
  <div class="form-group col-md-6">
    <label for="status_id">Status</label>
    <select class="form-control" name="status_id" id="status_id">
      <option value="">Select</option>
      <?php foreach(sale_status() as $item) { ?>
        <?php if(get_post('status_id') === $item['id'] || $record['transfer_status_id'] === $item['id']) { ?>
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
              <th width="50%">Paddy Type</th>
              <th width="35%">Qty (Kg)</th>
              <th></th>
            </thead>
            <tbody class="itemList">
              <?php foreach($record['items'] as $row) { ?> 
              <tr class="transferItem">
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
                    <input class="form-control" value="<?= $row['transfer_amount']; ?>" type="number" name="item[qty][]">
                    <input type="hidden" name="item[id][]" value="<?= $row['id']; ?>">
                  <input class="form-control" value="<?= $row['transfer_amount']; ?>" type="hidden" name="item[qty_org][]">
                  
                  </td>
                  <td>
                  <td>
                  <button type="button" class="btn btn-sm btn-danger remove_row">Remove</button>
                  </td>
        </tr>
                    <?php } ?>
        </tbody>
          </table>
        </div>

        <div class="col-md-12">

        <label for="notes">Notes</label>
    <textarea class="form-control" id="notes" name="notes" rows="4"><?= get_post('notes') ? get_post('notes') : ($record ? $record['transfer_notes'] : ''); ?></textarea>

                    </div>
          </div>
          
          <br/><br />

          <span class="error-message item form_error"></span>
<br/><br/>
  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>