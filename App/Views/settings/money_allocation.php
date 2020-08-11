<?php if($id <= 0) { ?>
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
    <label for="name">Collection Center</label>
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
    <span class="error-message collection_center_id"><?= isset($errors["collection_center_id"]) ? $errors["collection_center_id"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Amount</label>
    <input value="<?= get_post('amount') ? get_post('amount') : ($record ? $record['amount'] : ''); ?>" type="number" class="form-control" required id="amount" name="amount" placeholder="">
    <span class="error-message"><?= isset($errors["amount"]) ? $errors["amount"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description" rows="2"><?= get_post('description') ? get_post('description') : ($record ? $record['notes'] : ''); ?></textarea>
    <span class="error-message"><?= isset($errors["description"]) ? $errors["description"]: ""; ?></span>
  </div>


  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>

</div>
</div>
