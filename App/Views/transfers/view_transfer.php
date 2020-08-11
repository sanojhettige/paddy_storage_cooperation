

<form method="post" action="" id="saleForm">
  <div class="row">
  <div class="form-group col-md-4">
    <label for="farmer_id">Farmer</label>
    <?= $record['farmer_id'] ?>
  </div>

  <div class="form-group col-md-4">
    <label for="collection_center_id">Collection Center</label>
    <?= $record['collection_center_id']; ?>
</div>
  <div class="form-group col-md-4">
    <label for="collection_date">Collection Date</label>
    <?= date("Y-m-d", strtotime($record['collection_date'])); ?>
    </div>

        </div>

        
        <div class="col-md-12">
          <table class="table">
            <thead>
              <th width="5%">#</th>
              <th width="30%">Paddy Type</th>
              <th width="20%">Qty (Kg)</th>
              <th width="20%">Collected price(Unit)</th>
              <th width="25%">Total</th>
            </thead>
            <tbody class="itemList">
            <?php 
                $subTotal = 0;
            foreach($record['items'] as $index=>$row) { ?> 
                <tr class="purcahseItem">
                  <td><?= $index+1; ?></td>
                  <td><?= $row['paddy_category_id']; ?></td>
                  <td><?= $row['collected_amount']; ?></td>
                  <td><?= $row['collected_rate']; ?></td>
                  <td><?php
                    $total = $row['collected_amount']* $row['collected_rate'];
                   $subTotal += $total;
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
        <?= $record['purchase_notes']; ?>
                    </div>
          </div>
          
          <br/><br />

          <span class="error-message item form_error"></span>
<br/><br/>
  <input type="hidden" value="<?= $record ? $record['id'] : ''; ?>" name="_id">
  <button type="submit" name="submit" value="1" class="btn btn-danger">Delete</button>
  <a href="/purchases" class="btn btn-default">Back to Purchases</a>
  
</form>