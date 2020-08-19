<div class="auth-container">
    <h1 class="app-title"><?= APP_NAME ?></h1>

    <div class="auth-form-container">
        <form class="paddy-signin-form" action="" method="post">
            <img class="mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Sign-in to your account</h1>
            <div class="form-group">
                <label for="username" class="sr-only">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required
                    autofocus>
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                    required>
            </div>
            <div class="form-group">
                <p class="error-message"><?= isset($message) ? $message: ""; ?></p>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="do_login">Sign in</button>
            <a href="<?= BASE_URL."/auth/reset_password"; ?>">Reset Password</a>
            <p class="mt-5 mb-3 text-muted">&copy; <?= date("Y"). " ". APP_NAME; ?></p>
        </form>
    </div>
</div>