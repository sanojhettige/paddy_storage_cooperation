<form method="post" action="">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input value="<?= get_post('name') ? get_post('name') : ($record ? $record['name'] : ''); ?>" type="text"
            class="form-control" required id="name" name="name" placeholder="">
        <span class="error-message"><?= isset($errors["name"]) ? $errors["name"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Email Address</label>
        <input readonly value="<?= get_post('email') ? get_post('email') : ($record ? $record['email'] : ''); ?>"
            type="email" class="form-control" required id="email" name="email" placeholder="">
        <span class="error-message"><?= isset($errors["email"]) ? $errors["email"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Password</label>
        <input value="" type="password" class="form-control" required id="password" name="password" placeholder="">
        <span class="error-message"><?= isset($errors["password"]) ? $errors["password"]: ""; ?></span>
    </div>
    <div class="form-group">
        <label for="name">Confirm Password</label>
        <input value="" type="password" class="form-control" required id="cpassword" name="cpassword" placeholder="">
        <span class="error-message"><?= isset($errors["cpassword"]) ? $errors["cpassword"]: ""; ?></span>
    </div>

    <button type="submit" name="submit" value="1" class="btn btn-primary">Update</button>
    <button type="reset" class="btn btn-default">Reset</button>

</form>