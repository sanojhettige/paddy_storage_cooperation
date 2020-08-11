

<form method="post" action="">
  <div class="form-group">
    <label for="name">Collection Center</label>
    <select class="form-control" name="collection_center" id="collection_center">
      <option value="">Select Collection Center</option>
      <?php foreach($collection_centers as $item) { ?>
        <?php if(get_post('collection_center') === $item['id'] || $record['collection_center_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message"><?= isset($errors["collection_center"]) ? $errors["collection_center"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">User Role</label>
    <select class="form-control" name="role_id" id="role_id">
      <option value="">Select Role</option>
      <?php foreach($user_roles as $item) { ?>
        <?php if(get_post('role_id') === $item['id'] || $record['role_id'] === $item['id']) { ?>
            <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } else { ?>
            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
        <?php } ?>
      <?php } ?>
      
    </select>
    <span class="error-message"><?= isset($errors["role_id"]) ? $errors["role_id"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Full Name</label>
    <input value="<?= get_post('name') ? get_post('name') : ($record ? $record['name'] : ''); ?>" type="text" class="form-control" required id="name" name="name" placeholder="">
    <span class="error-message"><?= isset($errors["name"]) ? $errors["name"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Email Address</label>
    <input value="<?= get_post('email') ? get_post('email') : ($record ? $record['email'] : ''); ?>" type="email" class="form-control" required id="email" name="email" placeholder="">
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


  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>