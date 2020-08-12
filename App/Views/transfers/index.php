<?php if(is_permitted('transfers-add')) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/transfers/add" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="table-responsive">
<table id="transfer_datatable" class="table table-striped table-sm" url="/transfers/get_transfers">
        <thead>
            <tr>
                <th>ID</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>