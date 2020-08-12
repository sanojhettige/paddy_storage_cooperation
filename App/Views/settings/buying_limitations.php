<form action="" method="post">
<div class="row">
    <div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption class="error-message">*** Set the limit as 0 (Zero) if buying unlimited of paddy on each season.</caption>
            <thead>
                <tr>
                    <th>Season</th>
                    <th>Period</th>
                    <th>Max Limit(Kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($seasons as $row) { ?>
                    <tr>
                        <td><?= $row['name']; ?></td>
                        <th><?= $row['period']; ?></th>
                        <td>
                            <?php 
                                $id = $row['id'];
                            $post = get_post("maxlimit[".$id."]");  ?>
                            <input type="number" class="form-control" name="maxlimit[]" value="<?= $post ? $post: $row['max_allowed_amount']; ?>">
                            <input type="hidden" value="<?= $id; ?>" name="id[]">
                        </td>
                    </tr>
                <?php } ?>
            <tbody>
            <tfoot>
            <tr>
                    <th>Season</th>
                    <th>Period</th>
                    <th>Max Limit(Kg)</th>
                </tr>
            </tfoot>
        </table>
</div>
</div>
</div>

<button type="submit" value="1" name="submit" class="btn btn-primary pull-right">Update</button>

</form>