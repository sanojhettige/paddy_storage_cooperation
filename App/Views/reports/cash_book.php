<!-- <div class="table-responsive">
    <table class="table table-striped table-sm">
        <tr>
            <td colspan="3">Received</td>
            <td><?= formatCurrency($received); ?></td>
        </tr>
        <tr>
            <td colspan="3">Issued</td>
            <td><?= formatCurrency($cash_issued); ?></td>
        </tr>
        <tr>
            <td colspan="3">Balance</td>
            <td><?= formatCurrency($balance); ?></td>
        </tr>
    </table>
</div> -->

<div class="row">
    <div class="col-md-12">Cash Book</div>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <th width="10%">Date</th>
                    <th width="20%">Description</th>
                    <th width="5%">V.No</th>
                    <th width="15%">Cash</th>
                    <th width="10%">Date</th>
                    <th width="20%">Description</th>
                    <th width="5%">V.No</th>
                    <th width="15%">Cash</th>
                </thead>
                <tr>
                    <td><?= date("Y-m-01"); ?></td>
                    <td>B/F</td>
                    <td></td>
                    <td><?= formatCurrency($bf_amount); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php foreach($received as $row) { ?>
                <tr>
                    <td><?= date("Y-m-d", strtotime($row['date'])); ?></td>
                    <td><?= $row['description']; ?></td>
                    <td><?= $row['v_no']; ?></td>
                    <td><?= formatCurrency($row['amount']); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
                <?php foreach($cash_issued as $row) { ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= date("Y-m-d", strtotime($row['date'])); ?></td>
                    <td><?= $row['description']; ?></td>
                    <td><?= $row['v_no']; ?></td>
                    <td><?= formatCurrency($row['amount']); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td><?= date("Y-m-d"); ?></td>
                    <td>B/F</td>
                    <td></td>
                    <td><?= formatCurrency($balance); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            </table>
        </div>
    </div>
</div>