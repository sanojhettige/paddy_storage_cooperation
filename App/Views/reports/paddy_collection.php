<form action="" method="post">
    <div class="row component-header">

        <div class="col-md-4">
            <label for="from_date">From Date</label>
            <input type="text" required value="<?= get_post('from_date') ? get_post('from_date') : ''; ?>"
                class="form-control datetimepicker" id="from_date" data-date-format="yyyy-mm-dd" name="from_date">
            <span class="error-message from_date"><?= isset($errors["from_date"]) ? $errors["from_date"]: ""; ?></span>
        </div>
        <div class="col-md-4">
            <label for="to_date">To Date</label>
            <input type="text" required value="<?= get_post('to_date') ? get_post('to_date') : ''; ?>"
                class="form-control datetimepicker" id="to_date" data-date-format="yyyy-mm-dd" name="to_date">
            <span class="error-message to_date"><?= isset($errors["to_date"]) ? $errors["to_date"]: ""; ?></span>
        </div>
        <div class="col-md-4">
            <button type="submit" style="margin-top: 30px;" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Purchase ID</th>
                <th>Farmer Name</th>
                <th>Paddy Type</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Pay Order Issued</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($report as $item) { ?>
            <tr>
                <td><?= $item['purchase_id']; ?></td>
                <td><?= $item['farmer_name']; ?></td>
                <td><?= $item['paddy_name']; ?></td>
                <td><?= $item['collected_amount']; ?></td>
                <td><?= $item['collected_rate']; ?></td>
                <th><?= $item['pay_order_issued'] ? "Yes": "No"; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Purchase ID</th>
                <th>Farmer Name</th>
                <th>Paddy Type</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Pay Order Issued</th>
            </tr>
        </tfoot>
    </table>
</div>