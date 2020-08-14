<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/warehouse.png'; ?>" alt="Warehouse">
                <div class="card-block">
                    <h4 class="card-title">Total Centers</h4>
                    <p class="card-text">
                        <?= isset($totalCenters) ? $totalCenters : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/farmer.png'; ?>" alt="Farmer">
                <div class="card-block">
                    <h4 class="card-title">Total Farmers</h4>
                    <p class="card-text">
                        <?= isset($totalFarmers) ? $totalFarmers: 0; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-sm-down hidden-lg-up"></div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/category.png'; ?>" alt="Category">
                <div class="card-block">
                    <h4 class="card-title">Total Categories</h4>
                    <p class="card-text">
                        <?= isset($totalCategories) ? $totalCategories : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/stock.png'; ?>" alt="Stock">
                <div class="card-block">
                    <h4 class="card-title">Available Stock</h4>
                    <p class="card-text">
                        <?= isset($availableStock) ? $availableStock : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- Purchases -->
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/purchase.png'; ?>" alt="Purchase">
                <div class="card-block">
                    <h4 class="card-title">Purchases (Today)</h4>
                    <p class="card-text">
                        <?= isset($todayPurchase) ? $todayPurchase : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/purchase.png'; ?>" alt="Purchase">
                <div class="card-block">
                    <h4 class="card-title">Purchases (<?= date("M"); ?>)</h4>
                    <p class="card-text">
                        <?= isset($monthPurchase) ? $monthPurchase : 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/purchase.png'; ?>" alt="Purchase">
                <div class="card-block">
                    <h4 class="card-title">Purchases (<?= date("Y"); ?>)</h4>
                    <p class="card-text">
                        <?= isset($yearPurchase) ? $yearPurchase: 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/sales.png'; ?>" alt="Sales">
                <div class="card-block">
                    <h4 class="card-title">Sales (Today)</h4>
                    <p class="card-text">
                        <?= isset($todaySales) ? $todaySales: 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/sales.png'; ?>" alt="Sales">
                <div class="card-block">
                    <h4 class="card-title">Sales (<?= date("M"); ?>)</h4>
                    <p class="card-text">
                        <?= isset($monthSales) ? $monthSales: 0; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="card">
                <img class="card-img-top" src="<?= BASE_URL.'/assets/img/sales.png'; ?>" alt="Sales">
                <div class="card-block">
                    <h4 class="card-title">Sales (<?= date("Y"); ?>)</h4>
                    <p class="card-text">
                        <?= isset($yearSales) ? $yearSales: 0; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>