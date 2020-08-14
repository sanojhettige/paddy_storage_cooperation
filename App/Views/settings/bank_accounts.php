<?php if(isset($id) && $id <= 0) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/settings/bank_accounts" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-8">
        <div class="table-responsive">
            <table id="bank_datatable" class="table table-striped table-sm" url="/settings/get_bank_accounts">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Collection Center</th>
                        <th>Bank Name</th>
                        <th>Account Name</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Collection Center</th>
                        <th>Bank Name</th>
                        <th>Account Name</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="col-md-4">


        <form method="post" action="">
            <div class="form-group">
                <label for="collection_center_id">Collection Center</label>
                <select class="form-control" name="collection_center_id" id="collection_center_id">
                    <option value="">Select Type</option>
                    <?php foreach($collection_centers as $item) { ?>
                    <?php if(get_post('collection_center_id') === $item['id'] || $record['collection_center_id'] === $item['id']) { ?>
                    <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                    <?php } ?>
                    <?php } ?>

                </select>
                <span
                    class="error-message collection_center_id"><?= isset($errors["collection_center_id"]) ? $errors["collection_center_id"]: ""; ?></span>
            </div>
            <div class="form-group">
                <label for="bank_account_no">Account No</label>
                <input
                    value="<?= get_post('bank_account_no') ? get_post('bank_account_no') : ($record ? $record['bank_account_no'] : ''); ?>"
                    type="text" class="form-control" required id="bank_account_no" name="bank_account_no"
                    placeholder="">
                <span
                    class="error-message"><?= isset($errors["bank_account_no"]) ? $errors["bank_account_no"]: ""; ?></span>
            </div>
            <div class="form-group">
                <label for="bank_account_name">Account Name</label>
                <input
                    value="<?= get_post('bank_account_name') ? get_post('bank_account_name') : ($record ? $record['bank_account_name'] : ''); ?>"
                    type="text" class="form-control" required id="bank_account_name" name="bank_account_name"
                    placeholder="">
                <span
                    class="error-message"><?= isset($errors["bank_account_name"]) ? $errors["bank_account_name"]: ""; ?></span>
            </div>
            <div class="form-group">
                <label for="bank_and_branch">Bank/Branch</label>
                <input
                    value="<?= get_post('bank_and_branch') ? get_post('bank_and_branch') : ($record ? $record['bank_and_branch'] : ''); ?>"
                    type="text" class="form-control" required id="bank_and_branch" name="bank_and_branch"
                    placeholder="">
                <span
                    class="error-message"><?= isset($errors["bank_and_branch"]) ? $errors["bank_and_branch"]: ""; ?></span>
            </div>



            <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
            <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>

        </form>

    </div>
</div>