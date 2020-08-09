

<form method="post" action="" id="purchaseForm">
  <div class="row">
  <div class="form-group col-md-4">
    <label for="farmer_id">Farmer</label>
    <select class="form-control" name="farmer_id" id="farmer_id">
      <option value="">Select Type</option>
      <?php foreach($farmers as $item) { ?>
        <?php if($_POST['farmer_id'] === $item['id'] || $record['farmer_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message"><?= isset($errors["farmer_id"]) ? $errors["farmer_id"]: ""; ?></span>
  </div>
  <div class="form-group col-md-4">
    <label for="collection_center_id">Collection Center</label>
    <select class="form-control" name="collection_center_id" id="collection_center_id">
      <option value="">Select Type</option>
      <?php foreach($collection_centers as $item) { ?>
        <?php if($_POST['collection_center_id'] === $item['id'] || $record['collection_center_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message"><?= isset($errors["collection_center_id"]) ? $errors["collection_center_id"]: ""; ?></span>
  </div>
  <div class="form-group col-md-4">
    <label for="collection_date">Collection Date</label>
    <input type="text" required class="form-control datetimepicker" id="collection_date" data-date-format="yyyy-mm-dd" name="collection_date">
    <span class="error-message"><?= isset($errors["collection_center_id"]) ? $errors["collection_center_id"]: ""; ?></span>
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
              <th width="20%">Weight</th>
              <th width="20%">Buying price</th>
              <th width="25%">Total</th>
            </thead>
            <tbody class="itemList">
              <tr class="purchaseItem">
                  <td></td>
                  <td>
                    <select class="form-control">
                      <?php foreach($paddy_types as $paddy) {
                        echo "<option value='".$paddy['id']."'>".$paddy['name']."</option>";
                      } ?>
                    </select>

                  </td>
                  <td>
                    <input class="form-control" type="number">
                  </td>
                  <td>
                  <input class="form-control" type="number">
                  </td>
                  <td></td>
        </tr>
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
    <textarea class="form-control" id="notes" name="notes" rows="4"></textarea>

                    </div>
          </div>
          


  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>