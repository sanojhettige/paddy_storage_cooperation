<form method="post" action="">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="app_name">App Name</label>
            <input value="<?= get_post('app_name') ? get_post('app_name') : ($record ? $record['app_name'] : ''); ?>"
                type="text" class="form-control" required id="app_name" name="app_name" placeholder="">
            <span class="error-message"><?= isset($errors["app_name"]) ? $errors["app_name"]: ""; ?></span>
        </div>
        <div class="form-group col-md-6">
            <label for="fax_number">Email Address</label>
            <input
                value="<?= get_post('email_address') ? get_post('email_address') : ($record ? $record['email_address'] : ''); ?>"
                type="text" class="form-control" required id="email_address" name="email_address" placeholder="">
            <span class="error-message"><?= isset($errors["email_address"]) ? $errors["email_address"]: ""; ?></span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="address">Address</label>
            <textarea class="form-control" required id="address" name="address"
                rows="2"><?= get_post('address') ? get_post('address') : ($record ? $record['address'] : ''); ?></textarea>
            <span class="error-message"><?= isset($errors["address"]) ? $errors["address"]: ""; ?></span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="phone_number">Phone Number</label>
            <input
                value="<?= get_post('phone_number') ? get_post('phone_number') : ($record ? $record['phone_number'] : ''); ?>"
                type="text" class="form-control" required id="phone_number" name="phone_number" placeholder="">
            <span class="error-message"><?= isset($errors["phone_number"]) ? $errors["phone_number"]: ""; ?></span>
        </div>
        <div class="form-group col-md-6">
            <label for="fax_number">Fax Number</label>
            <input
                value="<?= get_post('fax_number') ? get_post('fax_number') : ($record ? $record['fax_number'] : ''); ?>"
                type="text" class="form-control" required id="fax_number" name="fax_number" placeholder="">
            <span class="error-message"><?= isset($errors["fax_number"]) ? $errors["fax_number"]: ""; ?></span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="name">Active Season</label>
            <select class="form-control" name="active_season_id" id="active_season_id">
                <option value="">Select Season</option>
                <?php foreach($seasons as $item) { ?>
                <?php if(get_post('active_season_id') == $item['id'] || $record['active_season_id'] == $item['id']) { ?>
                <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } else { ?>
                <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } ?>
                <?php } ?>

            </select>
            <span
                class="error-message"><?= isset($errors["active_season_id"]) ? $errors["active_season_id"]: ""; ?></span>
        </div>
        <div class="form-group col-md-6">
            <label for="currency_symbol">Currency Symbol</label>
            <input
                value="<?= get_post('currency_symbol') ? get_post('currency_symbol') : ($record ? $record['currency_symbol'] : ''); ?>"
                type="text" class="form-control" required id="currency_symbol" name="currency_symbol" placeholder="">
            <span
                class="error-message"><?= isset($errors["currency_symbol"]) ? $errors["currency_symbol"]: ""; ?></span>
        </div>
    </div>

    </div>



    <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-default">Reset</button>

</form>