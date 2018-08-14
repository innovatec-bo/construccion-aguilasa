/**
 * Created by Jair on 13/08/2018.
 */

$(document).ready(function() {
    var date = new Date();
    $('.input-date').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY'
    });

    $("#ajax-get-responsible-list").select2({
        placeholder: 'Asigne uno o mas responsables',
        allowClear: true
    });

    $("input[name='start-date']").change(function(){
        var startDate = $(this).val();
        var endDate = $("input[name=end-date]").val();
        calculateDateDiff(startDate, endDate);
    });

    $("input[name='end-date']").change(function(){
        var startDate = $("input[name=end-date]").val();
        var endDate = $(this).val();
        calculateDateDiff(startDate, endDate);
    });
    $(document).on("submit","form[name=assign-project-form]",function(e){
        var responsible = "";
        var select2Data = $('#ajax-get-responsible-list').select2("data");
        var responsibleList = [];
        $.each(select2Data, function(index, value){
            responsibleList.push(value.id);
            responsible += value.id+","
        });
        responsible = responsible.substring(0, responsible.length - 1);
       $("input[name=responsible-list]").val(responsible);
    });
});

function calculateDateDiff(startDate, endDate)
{
    var date1 = new Date(startDate);
    var date2 = new Date(endDate);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    $("input[name=estimated-time]").val(diffDays);
}
