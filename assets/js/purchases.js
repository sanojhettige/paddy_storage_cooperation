$(document).ready(function(){
    $('.datetimepicker').datepicker({
        timepicker: false,
        language: 'en',
        range: false,
        multipleDates: false,
            multipleDatesSeparator: " To "
      });

    $(".addItem").click(function(e) {
        addRow();
    });

    $('table').on('mouseup keyup', 'input[type=number]', () => calculateTotals());

    function loadPurchase() {
        calculateTotals();
    }

    function formatCurrency(amount) {
        return `Rs ${Number(amount).toFixed(2)}`;
    }

    function calculateTotals() {
        const subtotals = $('.purchaseItem').map((idx, val) => calculateSubtotal(val)).get();
        const total = subtotals.reduce((a, v) => a + Number(v), 0);
        $('.total td:eq(1)').text(formatCurrency(total));
    }

    function calculateSubtotal(row) {
        const $row = $(row);
        const inputs = $row.find('input');
        const subtotal = inputs[0].value * inputs[1].value;
        $row.find('td:last').text(formatCurrency(subtotal));
        return subtotal;
    }

    function addRow() {
        const $lastRow = $('.purchaseItem:last');
        const $newItem = $lastRow.clone();
        $newItem.find('input').val('');
        $newItem.find('select').val('');
        $newItem.find('td:last').text('0.00');
        $newItem.insertAfter($lastRow);
        $newItem.find('select:first').focus();
    }
  
  });
  
  (function () {    
      'use strict';

      $("#purchaseForm").submit(function(e) {
        e.preventDefault();
        var actionurl = e.currentTarget.action;
        $.ajax({
                url: actionurl,
                type: 'POST',
                dataType: 'json',
                data: $("#purchaseForm").serialize(),
                success: function(data) {
                    if(data.success === 1) {
                        
                    } else {
                      
                    }
                }
        });

    });


  })($);