

<form method="post" action="">
  <div class="form-group">
    <label for="name">Collection Center Name</label>
    <input value="<?= isset($_POST['name']) ? $_POST['name'] : ($record ? $record['name'] : ''); ?>" type="text" class="form-control" required id="name" name="name" placeholder="">
    <span class="error-message"><?= isset($errors["name"]) ? $errors["name"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="address">Address</label>
    <textarea class="form-control" required id="address" name="address" rows="2"><?= isset($_POST['address']) ? $_POST['address'] : ($record ? $record['address'] : ''); ?></textarea>
    <span class="error-message"><?= isset($errors["address"]) ? $errors["address"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">City</label>
    <input value="<?= isset($_POST['city']) ? $_POST['city'] : ($record ? $record['city'] : ''); ?>" type="text" class="form-control" required id="city" name="city" placeholder="">
    <span class="error-message"><?= isset($errors["city"]) ? $errors["city"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Phone Number</label>
    <input value="<?= isset($_POST['phone']) ? $_POST['phone'] : ($record ? $record['phone_number'] : ''); ?>" type="text" class="form-control" required id="phone" name="phone" placeholder="">
    <span class="error-message"><?= isset($errors["phone"]) ? $errors["phone"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Capacity (Metric Tons)</label>
    <input value="<?= isset($_POST['capacity']) ? $_POST['capacity'] : ($record ? $record['capacity'] : ''); ?>" type="number" class="form-control" required id="capacity" name="capacity" placeholder="">
    <span class="error-message"><?= isset($errors["capacity"]) ? $errors["capacity"]: ""; ?></span>
  </div>

  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>