

<form method="post" action="">
<div class="form-group">
    <label for="name">Collection Center</label>
    <select class="form-control" name="collection_center" id="collection_center">
      <option value="">Select Collection Center</option>
      <?php foreach($collection_centers as $item) { ?>
        <?php if($_POST['collection_center'] === $item['id'] || $record['collection_center_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message"><?= isset($errors["collection_center"]) ? $errors["collection_center"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Farmer Name</label>
    <input value="<?= isset($_POST['name']) ? $_POST['name'] : ($record ? $record['name'] : ''); ?>" type="text" class="form-control" required id="name" name="name" placeholder="">
    <span class="error-message"><?= isset($errors["name"]) ? $errors["name"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="address">Address</label>
    <textarea class="form-control" required id="address" name="address" rows="2"><?= isset($_POST['address']) ? $_POST['address'] : ($record ? $record['address'] : ''); ?></textarea>
    <span class="error-message"><?= isset($errors["address"]) ? $errors["address"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">NIC No</label>
    <input value="<?= isset($_POST['nic_no']) ? $_POST['nic_no'] : ($record ? $record['nic_no'] : ''); ?>" type="text" class="form-control" required id="nic_no" name="nic_no" placeholder="">
    <span class="error-message"><?= isset($errors["nic_no"]) ? $errors["nic_no"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Phone Number</label>
    <input value="<?= isset($_POST['phone']) ? $_POST['phone'] : ($record ? $record['phone_number'] : ''); ?>" type="text" class="form-control" required id="phone" name="phone" placeholder="">
    <span class="error-message"><?= isset($errors["phone"]) ? $errors["phone"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Land Size</label>
    <input value="<?= isset($_POST['land_size']) ? $_POST['land_size'] : ($record ? $record['land_size'] : ''); ?>" type="text" class="form-control" required id="land_size" name="land_size" placeholder="">
    <span class="error-message"><?= isset($errors["land_size"]) ? $errors["land_size"]: ""; ?></span>
  </div>

  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>