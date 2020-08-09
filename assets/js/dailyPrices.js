$(document).ready(function(){
    $('.datetimepicker').datepicker({
        timepicker: false,
        language: 'en',
        range: false,
        multipleDates: false,
            multipleDatesSeparator: " To "
      });

      $(".addPrice").click(function(e) {
        $('#dailyPriceForm').trigger("reset");
        $("#price_title").html("Add Price");
      });
  
  });
  
  (function () {    
      'use strict';
      $(function() {
          $('#daily_price_calendar').fullCalendar({
              themeSystem: 'bootstrap4',
              businessHours: false,
              defaultView: 'month',
              editable: false,
              header: {
                  left: 'title',
                  right: 'today prev,next'
              },
              events: {
                url: '/settings/get_daily_prices',
                method: "POST",
                failure: function() {
                  document.getElementById('script-warning').style.display = 'block'
                }
              },
              loading: function(bool) {
                document.getElementById('loading').style.display =
                  bool ? 'block' : 'none';
              },
              eventRender: function(event, element) {
                },
              dayClick: function() {
                  $('#modal-add-price').modal();
              },
              eventClick: function(row, jsEvent, view) {
                  if(row.id > 0) {
                      $("#price_title").html("Update Price");
                  } else {
                    $("#price_title").html("Add Price");
                  }
                      $('#date').val(row.start);
                      $('#selling_price').val(row.selling_price);
                      $('#buying_price').val(row.buying_price);
                      $('#_id').val(row.id);
                      $("#paddy_category_id").val(row.paddy_category_id);
                      $('#modal-add-price').modal();
              },
          })
      });

    
      $("#dailyPriceForm").submit(function(e) {
        e.preventDefault();
        var actionurl = e.currentTarget.action;
        $.ajax({
                url: actionurl,
                type: 'POST',
                dataType: 'json',
                data: $("#dailyPriceForm").serialize(),
                success: function(data) {
                    if(data.success === 1) {
                        $('#modal-add-price').modal("hide");
                    } else {
                      
                    }
                }
        });

    });


  })($);