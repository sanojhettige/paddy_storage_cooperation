<form method="post" action="">
    <div class="form-group">
        <label for="registration_number">Reg. no</label>
        <input
            value="<?= get_post('registration_number') ? get_post('registration_number') : ($record ? $record['registration_number'] : ''); ?>"
            type="text" class="form-control" required id="registration_number" name="registration_number"
            placeholder="">
        <span
            class="error-message"><?= isset($errors["registration_number"]) ? $errors["registration_number"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="vehicle_type">Vehicle Type</label>
        <select class="form-control" name="vehicle_type" id="vehicle_type">
            <option value="">Select Type</option>
            <?php foreach($vehicle_types as $item) { ?>
            <?php if(get_post('vehicle_type') === $item['id'] || $record['vehicle_type'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
            <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
            <?php } ?>
            <?php } ?>

        </select>
        <span class="error-message"><?= isset($errors["vehicle_type"]) ? $errors["vehicle_type"]: ""; ?></span>
    </div>

    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
    <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-default">Reset</button>

</form>