<?php if(is_permitted('customers-add')) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/customers/add" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="table-responsive">
<table id="customer_datatable" class="table table-striped table-sm" url="/customers/get_customers">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>