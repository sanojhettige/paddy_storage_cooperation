<div id="print-page">
<div id="header">PAY ORDER</div>
<div id="identity">
<div id="address">
    Paddy Storage Cooparation<br/>
    No. 123 <br/>
    ABC Building <br/>
    City
</div>
<div id="logo">


</div>
<div style="clear:both"></div>
<div id="farmer">
<div id="farmer-title">
<?= $record['farmer_name']; ?><br/>
<?= $record['address']; ?>
</div>
<table id="meta">
<tr>
<td class="meta-head">Purchase #</td>
<td><div>#<?= $record['id']; ?></div></td>
</tr>
<tr>
<td class="meta-head">Date</td>
<td><div id="date"><?= date("Y-m-d", strtotime($record['collection_date'])); ?></div></td>
</tr>
<tr>
<td class="meta-head">Issued Amount</td>
<td><div class="due"><?= $pay_order['paid_amount']; ?></div></td>
</tr>
</table>
</div>
<table id="items">
<tr>
<th>Item</th>
<th>Qty</th>
<th>Rate</th>
<th>Total</th>
</tr>
<?php $subTotal= 0; $total = 0; foreach($record['items'] as $row) { ?> 
<tr class="item-row">
<td class="item-name"><?= $row['paddy_name']; ?></td>
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
<div id="terms">
 
    <div id="signature">
        .....................................<br/>
        Authorized Officer
    </div>

</div>
</div>