<form method="post" action="" id="purchaseForm">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="farmer_id">Farmer</label>
            <select class="form-control" name="farmer_id" id="farmer_id">
                <option value="">Select Farmer</option>
                <?php foreach($farmers as $item) { ?>
                <?php if(get_post('farmer_id') == $item['id'] || $record['farmer_id'] == $item['id']) { ?>
                <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } else { ?>
                <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } ?>
                <?php } ?>

            </select>
            <span class="error-message farmer_id"><?= isset($errors["farmer_id"]) ? $errors["farmer_id"]: ""; ?></span>
        </div>
        <div class="form-group col-md-4">
            <label for="collection_center_id">Collection Center</label>
            <select class="form-control" name="collection_center_id" id="collection_center_id">
                <option value="">Select Type</option>
                <?php foreach($collection_centers as $item) { ?>
                <?php if(get_post('collection_center_id') == $item['id'] || $record['collection_center_id'] == $item['id']) { ?>
                <option selected value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } else { ?>
                <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                <?php } ?>
                <?php } ?>

            </select>
            <span
                class="error-message collection_center_id"><?= isset($errors["collection_center_id"]) ? $errors["collection_center_id"]: ""; ?></span>
        </div>
        <div class="form-group col-md-4">
            <label for="collection_date">Collection Date</label>
            <input type="text" required
                value="<?= get_post('collection_date') ? get_post('collection_date') : ($record['collection_date'] ? date("Y-m-d", strtotime($record['collection_date'])) : ''); ?>"
                class="form-control datetimepicker" id="collection_date" data-date-format="yyyy-mm-dd"
                name="collection_date">
            <span
                class="error-message collection_date"><?= isset($errors["collection_date"]) ? $errors["collection_date"]: ""; ?></span>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-primary pull-right addItem">Add Item</button>
            <br />
            <br />
        </div>

        <div class="col-md-12">
            <table class="table">
                <thead>
                    <th width="20%">Paddy Type</th>
                    <th width="15%">Qty (Kg)</th>
                    <th width="15%">Buying price</th>
                    <th width="20%">Block No</th>
                    <th width="20%">Total</th>
                    <th></th>
                </thead>
                <tbody class="itemList">
                    <?php foreach($record['items'] as $row) { ?>
                    <tr class="purchaseItem">
                        <td>

                            <select class="form-control paddy_type" name="item[paddy_type][]">
                                <?php foreach($paddy_types as $paddy) {
                          if($row['paddy_category_id'] == $paddy['id'])
                          echo "<option selected value='".$paddy['id']."'>".$paddy['name']."</option>";
                          else
                            echo "<option value='".$paddy['id']."'>".$paddy['name']."</option>";
                      } ?>
                            </select>

                        </td>
                        <td>
                            <input class="form-control" value="<?= $row['collected_amount']; ?>" type="number"
                                name="item[qty][]">
                        </td>
                        <td>
                            <span class="input-group-prepend">
                                <input class="form-control" value="<?= $row['collected_rate']; ?>" readonly
                                    type="number" name="item[price][]">
                                <div class="input-group-text price-reload">
                                    <i class="fa fa-refresh"></i>
                                </div>
                            </span>

                            <input type="hidden" name="item[id][]" value="<?= isset($row['id']) ? $row['id']: ""; ?>">
                            <input class="form-control" value="<?= $row['collected_amount']; ?>" type="hidden"
                                name="item[qty_org][]">
                        </td>
                        <td>
                            <input class="form-control" value="<?= isset($row['block_no']) ? $row['block_no']: ""; ?>"
                                type="text" name="item[block_no][]"> </td>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove_row">Remove</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfooter>
                    <tr class="total">
                        <td colspan="4"></td>
                        <td>00.00</td>
                    </tr>
                </tfooter>
            </table>
        </div>

        <div class="col-md-12">

            <label for="notes">Notes</label>
            <textarea class="form-control" id="notes" name="notes"
                rows="4"><?= get_post('notes') ? get_post('notes') : (isset($record['purchase_notes']) ? $record['purchase_notes'] : ''); ?></textarea>

        </div>
    </div>

    <br /><br />

    <span class="error-message item form_error"></span>
    <br /><br />
    <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id" id="_purchase_id">
    <input type="hidden" value="" id="total_amount" name="total_amount">
    <input type="hidden" value="" id="total_qty" name="total_qty">
    <button type="submit" name="submit" id="submit_purchase" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-default">Reset</button>

</form>