$(document).ready(function () {
  $(".datepicker").pickadate({
    closeOnSelect: true,
    format: "dd/mm/yyyy"
  });
  $('.timepicker').pickatime({
      default: 'now',
      twelvehour: true, // change to 12 hour AM/PM clock from 24 hour
      donetext: 'OK',
    autoclose: false,
    vibrate: true // vibrate the device when dragging clock hand
  });
});
