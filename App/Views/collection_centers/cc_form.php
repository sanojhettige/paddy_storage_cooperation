

<form method="post" action="">
  <div class="form-group">
    <label for="name">Collection Center Name</label>
    <input value="<?= $record ? $record['name'] : ''; ?>" type="text" class="form-control" required id="name" name="name" placeholder="">
  </div>
  <div class="form-group">
    <label for="address">Address</label>
    <textarea class="form-control" required id="address" name="address" rows="2"><?= $record ? $record['address'] : ''; ?></textarea>
  </div>
  <div class="form-group">
    <label for="name">City</label>
    <input value="<?= $record ? $record['city'] : ''; ?>" type="text" class="form-control" required id="city" name="city" placeholder="">
  </div>
  <div class="form-group">
    <label for="name">Phone Number</label>
    <input value="<?= $record ? $record['phone_number'] : ''; ?>" type="text" class="form-control" required id="phone" name="phone" placeholder="">
  </div>
  <div class="form-group">
    <label for="name">Capacity (Metric Tons)</label>
    <input value="<?= $record ? $record['capacity'] : ''; ?>" type="number" class="form-control" required id="capacity" name="capacity" placeholder="">
  </div>

  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
  
</form>