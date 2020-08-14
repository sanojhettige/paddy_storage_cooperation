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


    $(document).on("click", ".remove_row", function() {
        $(this).closest('tr').remove();
    });


    loadTransfer();

    function loadTransfer() {
        handleRowRemoveButton();
    }

    function addRow() {
        const $lastRow = $('.transferItem:last');
        const $newItem = $lastRow.clone();
        $newItem.find('input').val('');
        $newItem.find('select').val('');
        $newItem.find('td:eq(5)').html('<button type="button" class="btn btn-sm btn-danger remove_row">Remove</button>');
        $newItem.insertAfter($lastRow);
        $newItem.find('select:first').focus();
        handleRowRemoveButton();
    }

    function handleRowRemoveButton() {
        let totalRows = 0;
        const $firstRow = $('.transferItem:first');
        $('.transferItem').map((idx, val) => totalRows++).get();
        if (totalRows === 1) {
            $('.remove_row').css('display', 'none');
        } else {
            $('.remove_row').css('display', 'block');
        }

    }

});

(function() {
    'use strict';

    $("#transferForm").submit(function(e) {
        e.preventDefault();
        $(".error-message").html("");
        var actionurl = e.currentTarget.action;
        $.ajax({
            url: actionurl,
            type: 'POST',
            dataType: 'json',
            data: $("#transferForm").serialize(),
            success: function(data) {
                if (data.success === 1) {
                    if (data.purchase > 0) {
                        location.replace('/transfers/edit/' + data.purchase);
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