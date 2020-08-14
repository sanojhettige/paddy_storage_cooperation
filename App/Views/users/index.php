<?php if(is_permitted('users-add')) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/users/add" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="table-responsive">
    <table id="users_datatable" class="table table-striped table-sm" url="/users/get_users">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Collection Center</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Collection Center</th>
                <th>Last Update Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>