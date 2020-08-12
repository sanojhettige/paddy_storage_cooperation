<nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="/dashboard"><?= APP_NAME_SHORT; ?></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="navbar-nav px-3" style="width: 100%; display: contents;">
    <li class="nav-item text-nowrap" style="text-align: left;">
      <h4><?= get_session('role_name'); ?></h4>
    </li>
    <li class="nav-item text-nowrap" style="text-align: right; margin-right:20px;">
      <a class="nav-link" href="<?= '/auth/logout'; ?>">Sign out</a>
    </li>
  </ul>
</nav>