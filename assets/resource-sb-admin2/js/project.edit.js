/**
 * Created by Jair on 07/06/2018.
 */

$(document).ready(function() {
    // Basic date
    var date = new Date();
    $('#datetimepicker1').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY'
    });
});
