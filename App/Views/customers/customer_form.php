<form method="post" action="">
    <div class="form-group">
        <label for="name">Customer Name</label>
        <input value="<?= get_post('name') ? get_post('name') : ($record ? $record['name'] : ''); ?>" type="text"
            class="form-control" required id="name" name="name" placeholder="">
        <span class="error-message"><?= isset($errors["name"]) ? $errors["name"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Compay Name</label>
        <input
            value="<?= get_post('company_name') ? get_post('company_name') : ($record ? $record['company_name'] : ''); ?>"
            type="text" class="form-control" required id="company_name" name="company_name" placeholder="">
        <span class="error-message"><?= isset($errors["company_name"]) ? $errors["company_name"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <textarea class="form-control" required id="address" name="address"
            rows="2"><?= get_post('address') ? get_post('address') : ($record ? $record['address'] : ''); ?></textarea>
        <span class="error-message"><?= isset($errors["address"]) ? $errors["address"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Email address</label>
        <input
            value="<?= get_post('email_address') ? get_post('email_address') : ($record ? $record['email_address'] : ''); ?>"
            type="email" class="form-control" required id="email_address" name="email_address" placeholder="">
        <span class="error-message"><?= isset($errors["email_address"]) ? $errors["email_address"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Phone Number</label>
        <input value="<?= get_post('phone') ? get_post('phone') : ($record ? $record['phone_number'] : ''); ?>"
            type="text" class="form-control" required id="phone" name="phone" placeholder="">
        <span class="error-message"><?= isset($errors["phone"]) ? $errors["phone"]: ""; ?></span>
    </div>


    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
    <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-default">Reset</button>

</form>