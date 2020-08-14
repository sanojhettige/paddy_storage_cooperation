<?php if(isset($id) && $id <= 0) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/settings/money_allocation" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-8">
        <div class="table-responsive">
            <table id="money_datatable" class="table table-striped table-sm" url="/settings/get_money_allocations">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Colletion Center</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Last updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Colletion Center</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Last updated</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="col-md-4">


        <form method="post" action="">
            <div class="form-group">
                <label for="bank_account_id">Collection Center</label>
                <select class="form-control" name="bank_account_id" id="bank_account_id">
                    <option value="">Select Type</option>
                    <?php foreach($bank_accounts as $item) { ?>
                    <?php if(get_post('bank_account_id') === $item['id'] || $record['bank_account_id'] === $item['id']) { ?>
                    <option selected value="<?= $item['id']; ?>">
                        <?= $item['bank_account_no']."(".$item['collection_center'].")"; ?></option>
                    <?php } else { ?>
                    <option value="<?= $item['id']; ?>">
                        <?= $item['bank_account_no']."(".$item['collection_center'].")"; ?></option>
                    <?php } ?>
                    <?php } ?>

                </select>
                <span
                    class="error-message bank_account_id"><?= isset($errors["bank_account_id"]) ? $errors["collection_center_id"]: ""; ?></span>
            </div>
            <div class="form-group">
                <label for="name">Amount</label>
                <input value="<?= get_post('amount') ? get_post('amount') : ($record ? $record['amount'] : ''); ?>"
                    type="number" class="form-control" required id="amount" name="amount" placeholder="">
                <span class="error-message"><?= isset($errors["amount"]) ? $errors["amount"]: ""; ?></span>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"
                    rows="2"><?= get_post('description') ? get_post('description') : ($record ? $record['notes'] : ''); ?></textarea>
                <span class="error-message"><?= isset($errors["description"]) ? $errors["description"]: ""; ?></span>
            </div>


            <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
            <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>

        </form>

    </div>
</div>