

<form method="post" action="">
    <table class="table table-bordered">
    <tr>
        <td>Collection Center Name</td>
        <td><?= ($record ? $record['name'] : ''); ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?= ($record ? $record['address'] : ''); ?></td>
    </tr>
    <tr>
        <td>City</td>
        <td><?= ($record ? $record['city'] : ''); ?></td>
    </tr>
    <tr>
        <td>Phone Number</td>
        <td><?= ($record ? $record['phone_number'] : ''); ?></td>
    </tr>
    <tr>
        <td>Capacity</td>
        <td><?= ($record ? $record['capacity'] : ''); ?></td>
    </tr>
</table>


  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <?php if($record['id'] > 0 && $canDelete) { ?>
  <button type="submit" name="submit" value="1" class="btn btn-danger">Delete</button>
  <?php } ?>
  <a href="/collection-centers" class="btn btn-default">Back To List</a>
  
</form>