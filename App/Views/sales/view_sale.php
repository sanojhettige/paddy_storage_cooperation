<form method="post" action="" id="saleForm">
    <div class="row">
        <div class="form-group col-md-3">
            <label for="buyer_id">Buyer</label>
            <br /><?= $record['customer_name'] ?>
        </div>

        <div class="form-group col-md-3">
            <label for="collection_center_id">Issue Center</label>
            <br /><?= $record['collection_center']; ?>
        </div>
        <div class="form-group col-md-3">
            <label for="collection_date">Issue Date</label>
            <br /><?= date("Y-m-d", strtotime($record['issue_date'])); ?>
        </div>
        <div class="form-group col-md-3">
            <label for="status_id">Sale Status</label>
            <br /><?= sale_status($record['sale_status_id']); ?>
        </div>

    </div>


    <div class="col-md-12">
        <table class="table">
            <thead>
                <th width="5%">#</th>
                <th width="30%">Paddy Type</th>
                <th width="20%">Qty (Kg)</th>
                <th width="20%">Sold price(Unit)</th>
                <th width="25%">Total</th>
            </thead>
            <tbody class="itemList">
                <?php 
                $subTotal = 0;
            foreach($record['items'] as $index=>$row) { ?>
                <tr class="saleItem">
                    <td><?= $index+1; ?></td>
                    <td><?= $row['paddy_name']; ?></td>
                    <td><?= $row['sold_amount']; ?></td>
                    <td><?= $row['sold_rate']; ?></td>
                    <td><?php
                    $total = $row['sold_amount']* $row['sold_rate'];
                   $subTotal += $row['sold_amount']* $row['sold_rate'];
                   echo $total;
                   ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfooter>
                <tr class="total">
                    <td colspan="4"></td>
                    <td><?= $subTotal; ?></td>
                </tr>
            </tfooter>
        </table>
    </div>

    <div class="col-md-12">

        <label for="notes">Notes</label>
        <?= $record['sale_notes']; ?>
    </div>
    </div>

    <br /><br />

    <span class="error-message item form_error"></span>
    <br /><br />
    <input type="hidden" value="<?= isset($record['id']) ? $record['id'] : ''; ?>" name="_id">
    <?php if(isset($canDelete)) { ?>
    <button type="submit" name="submit" value="1" class="btn btn-danger">Delete</button>
    <?php } ?>
    <?php if(isset($canIssue)) { ?>
    <button type="submit" name="submit" value="1" class="btn btn-success">Issue Items</button>
    <?php } ?>
    <a href="<?php echo isset($redirect) ? $redirect : "/sales"; ?>" class="btn btn-default">Back to Sales</a>

</form>