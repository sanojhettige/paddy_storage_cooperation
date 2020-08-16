<form action="" method="post">
    <div class="row component-header">

        <div class="col-md-4">
            <label for="collection_center_id">Collection Center</label>
            <select class="form-control" name="collection_center_id" id="collection_center_id">
                <option value="">All Centers</option>
                <?php foreach($collection_centers as $item) { ?>
                <?php if(get_post('collection_center_id') == $item['id']) { ?>
                <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } else { ?>
                <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } ?>
                <?php } ?>

            </select>
            <span
                class="error-message collection_center_id"><?= isset($errors["collection_center_id"]) ? $errors["collection_center_id"]: ""; ?></span>
        </div>
        <div class="col-md-4">
            <button style="margin-top: 30px;" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <?php if(get_post('collection_center_id') <= 0) { echo "<th>Collection Center</th>"; } ?>
                <th>Paddy Type</th>
                <th>Available Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($report as $item) { ?>
            <tr>

                <?php if(get_post('collection_center_id') <= 0) { echo "<td>".$item['collection_center']."</td>"; } ?>
                <td><?= $item['paddy_name']; ?></td>
                <td><?= $item['available_stock']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <?php if(get_post('collection_center_id') <= 0) { echo "<th>Collection Center</th>"; } ?>
                <th>Paddy Type</th>
                <th>Available Stock</th>
            </tr>
        </tfoot>
    </table>
</div>