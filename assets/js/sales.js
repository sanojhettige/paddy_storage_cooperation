$(document).ready(function() {
    $('.datetimepicker').datepicker({
        timepicker: false,
        language: 'en',
        range: false,
        multipleDates: false,
        multipleDatesSeparator: " To ",
        onSelect: function(dateText, inst) {
            onDateChange(dateText);
        }
    });

    $(".addItem").click(function(e) {
        addRow();
    });

    $('table').on('mouseup keyup', 'input[type=number]', () => calculateTotals());

    $(document).on("change", ".paddy_type", function() {
        const date = $("#collection_date").val();
        const row = $(this).closest('tr');
        getDailyPrice(date, $(this).val(), row);

    });

    $(document).on("click", ".remove_row", function() {
        $(this).closest('tr').remove();
        calculateTotals();
    });

    $(document).on("click", ".price-reload", function() {
        const date = $("#collection_date").val();
        onDateChange(date);
    });

    $(document).on("change", "#collection_center_id", function() {
        const date = $("#collection_date").val();
        onCenterChange(date);
    })



    function getDailyPrice(date, category, row) {
        const warehouse = $("#collection_center_id").val();
        const id = $("#_sale_id").val();
        $.ajax({
            url: "/settings/get_paddy_rate",
            type: 'POST',
            dataType: 'json',
            data: { date, paddy_type: category, warehouse, sale_id: id },
            success: function(data) {
                const inputs = row.find('input');
                inputs[1].value = data.selling_price;
                if (data.available_stock >= 0) {
                    inputs[0].placeholder = "Avl. " + data.available_stock;
                    inputs[0].available_stock = data.available_stock;
                } else {
                    inputs[0].available_stock = 0;
                }

                calculateTotals();
            }
        });
    }


    function getMaxLimits(qty, category) {
        const sid = $("#_sale_id").val();
        const warehouse = $("#collection_center_id").val();
        $.ajax({
            url: "/sales/check_max_limits",
            type: 'POST',
            dataType: 'json',
            data: { total_qty: qty, category, warehouse, json: 1, update: sid },
            success: function(data) {
                let message = "";
                if (data.can_proceed) {
                    $("#submit_sale").attr("disabled", false);
                } else {
                    $("#submit_sale").attr("disabled", true);
                    if (data.available_stock <= 0) {
                        message += "No enough stocks to issue paddy";
                        message += ", max allowed amount is " + data.available_stock + " Kgs";
                    } else if (data.available_stock < qty) {
                        message += "No enough stocks to issue paddy";
                        message += ", max allowed amount is " + data.available_stock + " Kgs";
                    }
                    if (message) {
                        alert(message);
                    }

                }
            }
        });
    }



    function onDateChange(date) {
        $('.saleItem').map((idx, val) => {
            const select = $(val).find('select');
            getDailyPrice(date, select[0].value, $(val));
        });
    }

    function onCenterChange(date) {
        $('.saleItem').map((idx, val) => {
            const select = $(val).find('select');
            getDailyPrice(date, select[0].value, $(val));
        });
    }

    loadSale();

    function loadSale() {
        calculateTotals();
        handleRowRemoveButton();
    }

    function formatCurrency(amount) {
        return `Rs ${Number(amount).toFixed(2)}`;
    }

    function calculateTotals() {
        const subtotals = $('.saleItem').map((idx, val) => calculateSubtotal(val)).get();
        const totalQtys = $('.saleItem').map((idx, val) => calculateQty(val)).get();
        const total = subtotals.reduce((a, v) => a + Number(v), 0);
        const totalQty = totalQtys.reduce((a, v) => a + Number(v), 0);
        $('.total td:eq(1)').text(formatCurrency(total));
        handleRowRemoveButton();
        $("#total_amount").val(total);
        $("#total_qty").val(totalQty);
    }

    function calculateSubtotal(row) {
        const $row = $(row);
        const inputs = $row.find('input');
        const select = $(row).find('select');
        const subtotal = inputs[0].value * inputs[1].value;
        $row.find('td:eq(4)').text(formatCurrency(subtotal));
        getMaxLimits(inputs[0].value, select[0].value);
        return subtotal;
    }

    function calculateQty(row) {
        const $row = $(row);
        const inputs = $row.find('input');
        const subtotal = inputs[0].value;
        return subtotal;
    }

    function addRow() {
        const $lastRow = $('.saleItem:last');
        const $newItem = $lastRow.clone();
        $newItem.find('input').val('');
        $newItem.find('select').val('');
        $newItem.find('td:eq(4)').text('0.00');
        $newItem.find('td:eq(5)').html('<button type="button" class="btn btn-sm btn-danger remove_row">Remove</button>');
        $newItem.insertAfter($lastRow);
        $newItem.find('select:first').focus();
        handleRowRemoveButton();
    }

    function handleRowRemoveButton() {
        let totalRows = 0;
        const $firstRow = $('.saleItem:first');
        $('.saleItem').map((idx, val) => totalRows++).get();
        if (totalRows === 1) {
            $('.remove_row').css('display', 'none');
        } else {
            $('.remove_row').css('display', 'block');
        }
    }

});

(function() {
    'use strict';

    $("#saleForm").submit(function(e) {
        e.preventDefault();
        $(".error-message").html("");
        var actionurl = e.currentTarget.action;
        $.ajax({
            url: actionurl,
            type: 'POST',
            dataType: 'json',
            data: $("#saleForm").serialize(),
            success: function(data) {
                if (data.success === 1) {
                    if (data.sale > 0) {
                        location.replace('/sales/edit/' + data.sale);
                    }
                } else {
                    $.each(data.errors, function(index, error) {
                        $("." + index).html(error);
                    });
                }
            }
        });

    });


})($);