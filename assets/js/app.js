
$(document).ready(function() {
    $('.nav-link-collapse').on('click', function() {
      $('.nav-link-collapse').not(this).removeClass('nav-link-show');
      $(this).toggleClass('nav-link-show');
    });


    $('.datetimepicker').datepicker({
      timepicker: false,
      language: 'en',
      range: true,
      multipleDates: false,
          multipleDatesSeparator: " To "
    });


  });