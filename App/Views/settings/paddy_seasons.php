<?php if($id <= 0) { ?>
<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="/settings/paddy_seasons" class="btn btn-success btn-sm pull-right"> Add New </a>
    </div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-8">
    <div class="table-responsive">
        <table id="seasons_datatable" class="table table-striped table-sm" url="/settings/get_paddy_seasons">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Period</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Period</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
</div>
</div>
<div class="col-md-4">


<form method="post" action="">
  <div class="form-group">
    <label for="name">Name</label>
    <input value="<?= get_post('name') ? get_post('name') : ($record ? $record['name'] : ''); ?>" type="text" class="form-control" required id="name" name="name" placeholder="">
    <span class="error-message"><?= isset($errors["name"]) ? $errors["name"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="name">Period</label>
    <input value="<?= get_post('period') ? get_post('period') : ($record ? $record['period'] : ''); ?>" type="text" class="form-control datetimepicker" data-date-format="MM" required id="period" name="period" placeholder="">
    <span class="error-message"><?= isset($errors["period"]) ? $errors["period"]: ""; ?></span>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description" rows="2"><?= get_post('description') ? get_post('description') : ($record ? $record['description'] : ''); ?></textarea>
    <span class="error-message"><?= isset($errors["description"]) ? $errors["description"]: ""; ?></span>
  </div>


  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" value="1" class="btn btn-primary">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  
</form>

</div>
</div>
