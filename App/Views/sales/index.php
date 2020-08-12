<?php if(is_permitted('sales-add')) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/sales/add" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="table-responsive">
<table id="sale_datatable" class="table table-striped table-sm" url="/sales/get_sales">
        <thead>
            <tr>
                <th>ID</th>
                <th>Buyer Name</th>
                <th>Collection Center</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Buyer Name</th>
                <th>Collection Center</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>