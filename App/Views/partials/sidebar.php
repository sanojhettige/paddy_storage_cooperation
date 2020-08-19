<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">

        <?php $userRole = get_user_role(); ?>
        <ul class="nav nav-list flex-column">
            <?php if(in_array($userRole, array(1,2, 3, 4, 5, 6))) { ?>
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <?php } ?>
            <?php if(in_array($userRole, array(1))) { ?>
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
            <?php if(in_array($userRole, array(1))) { ?>
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
            <?php if(in_array($userRole, array(4,3,2))) { ?>
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
            <?php if(in_array($userRole, array(4))) { ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" data-target="#sales">
                    <span data-feather="layers"></span>
                    Sales<span class="pull-right"><b class="caret"></b>
                </a>
                <ul class="nav-second-level collapse" id="sales">
                    <li class="nav-item">
                        <a class="nav-link" href="/sales/collection_orders">
                            <span data-feather="bar-chart-2"></span>
                            Collection Orders
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <?php if(in_array($userRole, array(4))) { ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" data-target="#transfers">
                    <span data-feather="layers"></span>
                    Transfers<span class="pull-right"><b class="caret"></b>
                </a>
                <ul class="nav-second-level collapse" id="transfers">

                    <li class="nav-item">
                        <a class="nav-link" href="/transfers/issue_orders">
                            <span data-feather="bar-chart-2"></span>
                            Issued Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transfers/collection_orders">
                            <span data-feather="bar-chart-2"></span>
                            Collection Orders
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <?php if(in_array($userRole, array(1))) { ?>
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
                    <?php if(in_array($userRole, array(2))) { ?>
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
                    <?php } ?>
                    <?php if(in_array($userRole, array(1))) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/reports/stocks">
                            <span class="nav-link-text">Stock Report</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if(in_array($userRole, array(1))) { ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" data-target="#settings">
                    <span data-feather="layers"></span>
                    Settings <span class="pull-right"><b class="caret"></b>
                </a>
                <ul class="nav-second-level collapse" id="settings">
                    <li class="nav-item">
                        <a class="nav-link" href="/settings">
                            <span class="nav-link-text">System Settings</span>
                        </a>
                    </li>
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
                        <a class="nav-link" href="/settings/buying_limitation">
                            <span class="nav-link-text">Buying Limitations</span>
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
            <?php if(in_array($userRole, array(1,2, 3, 4, 5, 6))) { ?>
            <li class="nav-item">
                <a class="nav-link" href="/auth/profile">
                    <span data-feather="layers"></span>
                    Profile
                </a>
            </li>
            <?php } ?>

        </ul>

    </div>
</nav>