<form method="post" action="">
    <table class="table table-bordered">
        <tr>
            <td>Name</td>
            <td><?= ($record ? $record['name'] : ''); ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= ($record ? $record['email'] : ''); ?></td>
        </tr>
        <tr>
            <td>Collection Center</td>
            <td><?= ($record ? $record['collection_center']['name'] : ''); ?></td>
        </tr>
    </table>


    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
    <?php if($record['id'] > 0 && $canDelete) { ?>
    <button type="submit" name="submit" value="1" class="btn btn-danger">Delete</button>
    <?php } ?>
    <a href="/users" class="btn btn-default">Back To List</a>

</form>