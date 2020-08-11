<?php if(is_permitted('farmers-add')) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/farmers/add" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="table-responsive">
<table id="farmer_datatable" class="table table-striped table-sm" url="/farmers/get_farmers">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>NIC No</th>
                <th>Address</th>
                <th>Land Size</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>NIC No</th>
                <th>Address</th>
                <th>Land Size</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>