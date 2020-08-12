<div class="table-responsive">
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
</div>