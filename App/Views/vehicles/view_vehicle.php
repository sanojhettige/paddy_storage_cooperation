<form method="post" action="">
    <table class="table table-bordered">
        <tr>
            <td>Vehicle Reg. Number</td>
            <td><?= ($record ? $record['registration_number'] : ''); ?></td>
        </tr>
        <tr>
            <td>Vehicle Type</td>
            <td><?= ($record ? $record['vehicle_type'] : ''); ?></td>
        </tr>
    </table>


    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
    <?php if($record['id'] > 0 && $canDelete) { ?>
    <button type="submit" name="submit" value="1" class="btn btn-danger">Delete</button>
    <?php } ?>
    <a href="/vehicles" class="btn btn-default">Back To List</a>

</form>