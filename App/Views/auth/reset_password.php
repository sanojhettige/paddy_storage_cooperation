<div class="auth-container">
    <h1 class="app-title"><?= APP_NAME ?></h1>

    <?php
if(isset($success_message) || get_session('success_message')) {
    $s_message = isset($success_message) ? $success_message : get_session('success_message');
    echo '<div class="alert alert-success" role="alert">'.$s_message.'</div>';
}

if(isset($error_message) || get_session('error_message')) {
    $e_message = isset($error_message) ? $error_message : get_session('error_message');
    echo '<div class="alert alert-danger" role="alert">'.$e_message.'</div>';
}
?>

    <div class="auth-form-container">
        <form class="paddy-signin-form" action="" method="post">
            <img class="mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Reset Your Password</h1>
            <div class="form-group">
                <label for="username" class="sr-only">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required
                    autofocus>
            </div>
            <div class="form-group">
                <label for="pin" class="sr-only">Security PIN</label>
                <input type="text" id="pin" name="pin" class="form-control" placeholder="PIN" required autofocus>
            </div>
            <div class="form-group">
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
                <span
                    class="error-message"><?= isset($errors["collection_center"]) ? $errors["collection_center"]: ""; ?></span>
            </div>

            <div class="form-group">
                <label for="password" class="sr-only">New Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                    required>
            </div>
            <div class="form-group">
                <p class="error-message"><?= isset($message) ? $message: ""; ?></p>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="do_reset">Reset</button>
            <a href="<?= BASE_URL."/auth"; ?>">Sign In</a>
            <p class="mt-5 mb-3 text-muted">&copy; <?= date("Y"). " ". APP_NAME; ?></p>
        </form>
    </div>
</div>