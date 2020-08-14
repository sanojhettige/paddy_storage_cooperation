<?php if(is_permitted('vehicles-add')) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/vehicles/add" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="table-responsive">
    <table id="vehicle_datatable" class="table table-striped table-sm" url="/vehicles/get_vehicles">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reg. No</th>
                <th>Vehicle Type</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Reg. No</th>
                <th>Vehicle Type</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>