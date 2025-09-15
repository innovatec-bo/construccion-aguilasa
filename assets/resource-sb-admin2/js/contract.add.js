$(document).ready(function() {
    var date = new Date();
    $('.input-date').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY',
    });

    $(document).on("submit","form[name=assign-project-form]",function(e){
        var responsible = "";
        var select2Data1 = $('#ajax-get-responsible-list1').select2("data");
        var select2Data2 = $('#ajax-get-responsible-list2').select2("data");
        Array.prototype.push.apply(select2Data1,select2Data2);
        var responsibleList = [];
        $.each(select2Data1, function(index, value){
            responsibleList.push(value.id);
            responsible += value.id+","
        });
        responsible = responsible.substring(0, responsible.length - 1);
       $("input[name=responsible-list]").val(responsible);
    });
});