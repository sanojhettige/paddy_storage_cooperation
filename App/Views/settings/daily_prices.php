<div class="row component-header">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
        <a href="#" data-toggle="modal" data-target="#modal-add-price"
            class="btn btn-success btn-sm pull-right addPrice"> Add New </a>
    </div>
</div>
<div>
    <div id='loading'>loading...</div>
    <div id="daily_price_calendar"></div>


    <div id="modal-add-price" class="modal modal-top fade price-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="dailyPriceForm" method="post" action="/settings/save_price">
                    <div class="modal-body">
                        <h4 id="price_title">Add Prices</h4>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="paddy_category_id" id="paddy_category_id">
                                <option value="">Select Category</option>
                                <?php foreach($categories as $item) { ?>
                                <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" required class="form-control datetimepicker" id="date"
                                data-date-format="yyyy-mm-dd" name="date">
                        </div>
                        <div class="form-group">
                            <label>Buying Price</label>
                            <input type='text' required class="form-control" id="buying_price" name="buying_price">
                        </div>
                        <div class="form-group">
                            <label>Selling Price</label>
                            <input type='text' required class="form-control" id="selling_price" name="selling_price">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="_id" name="_id">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>