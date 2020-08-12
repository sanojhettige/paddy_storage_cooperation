

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">

      <?php $userRole = get_user_role(); ?>
        <ul class="nav nav-list flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="/dashboard">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/collection-centers">
              <span data-feather="file"></span>
              Collection Centers
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2,4))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/farmers">
              <span data-feather="layers"></span>
              Farmers
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/customers">
              <span data-feather="layers"></span>
              Customers
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2,4,3))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/purchases">
              <span data-feather="shopping-cart"></span>
              Purchases
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(4,3))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/purchases/daily_prices">
              <span data-feather="shopping-cart"></span>
              Daily Prices
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/sales">
              <span data-feather="users"></span>
              Sales
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/transfers">
              <span data-feather="bar-chart-2"></span>
              Transfers
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/vehicles">
              <span data-feather="layers"></span>
              Vehicles
            </a>
          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" data-target="#reports">
              <span data-feather="layers"></span>
              Reports <span class="pull-right"><b class="caret"></b>
            </a>
            <ul class="nav-second-level collapse" id="reports">
            <li class="nav-item">
                <a class="nav-link" href="/reports/paddy_collection">
                  <span class="nav-link-text">Paddy Collection</span>
                </a>
              </li>
            <li class="nav-item">
                <a class="nav-link" href="/reports/cash_book">
                  <span class="nav-link-text">Cash Book</span>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>

          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" data-target="#settings">
              <span data-feather="layers"></span>
              Settings <span class="pull-right"><b class="caret"></b>
            </a>
            <ul class="nav-second-level collapse" id="settings">
            <li class="nav-item">
                <a class="nav-link" href="/settings/bank_accounts">
                  <span class="nav-link-text">Bank Accounts</span>
                </a>
              </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/money_allocation">
                  <span class="nav-link-text">Money Allocation</span>
                </a>
              </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/paddy_seasons">
                  <span class="nav-link-text">Seasons</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/settings/paddy_categories">
                  <span class="nav-link-text">Paddy Categories</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/settings/prices">
                  <span class="nav-link-text">Daily Prices</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/settings/vehicle_types">
                  <span class="nav-link-text">Vehicle Types</span>
                </a>
              </li>
              
            </ul>

          </li>
          <?php } ?>
          <?php if(in_array($userRole, array(1,2))) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/users">
              <span data-feather="layers"></span>
              Users
            </a>
          </li>
          <?php } ?>

        </ul>

      </div>
    </nav>