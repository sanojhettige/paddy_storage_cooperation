<form method="post" action="" id="transferForm">
    <div class="row">
        <div class="form-group col-md-2">
            <label for="registration_number">Vehicle : </label>
            <br /><?= $record['registration_number'] ?>
        </div>

        <div class="form-group col-md-2">
            <label for="from_center_id">Issued By : </label>
            <br /><?= $record['from_center']; ?>
        </div>
        <div class="form-group col-md-2">
            <label for="from_center_id">Issued To : </label>
            <br /><?= $record['to_center']; ?>
        </div>
        <div class="form-group col-md-2">
            <label for="collection_date">Transfer Date</label>
            <br /><?= date("Y-m-d", strtotime($record['transfer_date'])); ?>
        </div>
        <div class="form-group col-md-2">
            <label for="collection_date">Transfer Status</label>
            <br /><?= transfer_status($record['transfer_status_id']); ?>
        </div>

    </div>

    <br />
    <br />
    <div class="col-md-12">
        <table class="table">
            <thead>
                <th width="5%">#</th>
                <th width="60%">Paddy Type</th>
                <th width="35%">Qty (Kg)</th>
            </thead>
            <tbody class="itemList">
                <?php 
                $subTotal = 0;
            foreach($record['items'] as $index=>$row) { ?>
                <tr class="purcahseItem">
                    <td><?= $index+1; ?></td>
                    <td><?= $row['paddy_name']; ?></td>
                    <td><?= $row['transfer_amount']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="col-md-12">

        <label for="notes">Notes</label>
        <?= $record['transfer_notes']; ?>
    </div>
    </div>

    <br /><br />

    <span class="error-message item form_error"></span>
    <br /><br />
    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
    <?php if(isset($canIssue) && $record['transfer_status_id'] === 1) { ?>
    <button type="submit" name="submit" value="2" class="btn btn-success">Issue Stock</button>
    <?php } ?>
    <?php if(isset($canCollect) && $record['transfer_status_id'] === 2) { ?>
    <button type="submit" name="submit" value="3" class="btn btn-success">Collect Stock</button>
    <?php } ?>
    <?php if(isset($canPrint)) { ?>
    <a target="_blank" href="/transfers/view/<?= $record['id'] ?>?print=1" class="btn btn-success">Print</a>
    <?php } ?>
    <?php if(isset($canDelete) && $record['transfer_status_id'] === 1) { ?>
    <button type="submit" name="submit" value="4" class="btn btn-danger">Delete</button>
    <?php } ?>



    <a href="<?php echo isset($redirect) ? $redirect : "/transfers"; ?>" class="btn btn-default">Back to Orders</a>

</form>