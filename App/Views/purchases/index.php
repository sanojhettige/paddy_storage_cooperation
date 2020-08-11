<?php if(is_permitted('purchases-add')) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/purchases/add" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="table-responsive">
<table id="purchase_datatable" class="table table-striped table-sm" url="/purchases/get_purchases">
        <thead>
            <tr>
                <th>ID</th>
                <th>Farmer Name</th>
                <th>Collection Center</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Farmer Name</th>
                <th>Collection Center</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>