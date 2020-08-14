<form method="post" action="">
    <div class="form-group">
        <label for="name">Collection Center Name</label>
        <input value="<?= get_post('name') ? get_post('name') : ($record ? $record['name'] : ''); ?>" type="text"
            class="form-control" required id="name" name="name" placeholder="">
        <span class="error-message"><?= isset($errors["name"]) ? $errors["name"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <textarea class="form-control" required id="address" name="address"
            rows="2"><?= get_post('address') ? get_post('address') : ($record ? $record['address'] : ''); ?></textarea>
        <span class="error-message"><?= isset($errors["address"]) ? $errors["address"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">City</label>
        <input value="<?= get_post('city') ? get_post('city') : ($record ? $record['city'] : ''); ?>" type="text"
            class="form-control" required id="city" name="city" placeholder="">
        <span class="error-message"><?= isset($errors["city"]) ? $errors["city"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Phone Number</label>
        <input value="<?= get_post('phone') ? get_post('phone') : ($record ? $record['phone_number'] : ''); ?>"
            type="text" class="form-control" required id="phone" name="phone" placeholder="">
        <span class="error-message"><?= isset($errors["phone"]) ? $errors["phone"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Capacity (Metric Tons)</label>
        <input value="<?= get_post('capacity') ? get_post('capacity') : ($record ? $record['capacity'] : ''); ?>"
            type="number" class="form-control" required id="capacity" name="capacity" placeholder="">
        <span class="error-message"><?= isset($errors["capacity"]) ? $errors["capacity"]: ""; ?></span>
    </div>

    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
    <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-default">Reset</button>

</form>