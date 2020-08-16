<form method="post" action="" id="payForm">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>Framer ID</td>
                        <td> #<?= $record['farmer_id']; ?></td>
                    </tr>
                    <tr>
                        <td>Framer Name</td>
                        <td> <?= $record['farmer_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Framer NIC No</td>
                        <td><?= $record['nic_no']; ?></td>
                    </tr>
                    <tr>
                        <td>Purchase ID</td>
                        <td>#<?= $record['id']; ?></td>
                    </tr>
                    <tr>
                        <td>Purchase Date</td>
                        <td><?= $record['collection_date']; ?></td>
                    </tr>

                    <tr>
                        <td>Items</td>
                        <td>
                            <table class="table">
                                <thead>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </thead>
                                <?php $subTotal= 0; $total = 0; foreach($record['items'] as $row) { ?>
                                <tr>
                                    <td><?= $row['paddy_name']; ?></td>
                                    <td><?= $row['collected_amount']; ?></td>
                                    <td><?= $row['collected_rate']; ?></td>
                                    <td>
                                        <?php 
                                $total = $row['collected_amount'] * $row['collected_rate']; 
                                echo formatCurrency($total);
                                $subTotal += $total;
                                ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?= formatCurrency($subTotal); ?></td>
                    </tr>
                    <!-- <tr>
                        <td>Paid Amount</td>
                        <td><?= formatCurrency($pay_order['paid_amount']); ?></td>
                    </tr> -->
                    <tr>
                        <td>Payable Amount</td>
                        <td><?= formatCurrency($subTotal); ?></td>
                    </tr>
                    <tr>
                        <td>Issue Amount</td>
                        <td>
                            <input readonly type="number" value="<?php echo ($subTotal); ?>" class="form-control"
                                name="paid_amount">
                            <span
                                class="error-message paid_amount"><?= isset($errors["paid_amount"]) ? $errors["paid_amount"]: ""; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Issue Date</td>
                        <td>
                            <input data-date-format="yyyy-mm-dd" type="text" value=""
                                class="form-control datetimepicker" name="paid_date">
                            <span
                                class="error-message paid_date"><?= isset($errors["paid_date"]) ? $errors["paid_date"]: ""; ?></span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-12">

            <label for="notes">Notes</label>
            <textarea class="form-control" id="pay_notes" name="pay_notes"
                rows="4"><?= get_post('pay_notes') ? get_post('pay_notes') : ($pay_order ? $pay_order['pay_notes'] : ''); ?></textarea>

        </div>
    </div>

    </div>

    <br /><br />

    <span class="error-message item form_error"></span>
    <br /><br />
    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
    <button type="submit" name="submit" class="btn btn-primary">Issue Pay Order</button>
    <button type="reset" class="btn btn-default">Reset</button>



</form>