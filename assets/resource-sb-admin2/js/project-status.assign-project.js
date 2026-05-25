/**
 * Created by Jair on 13/08/2018.
 */

$(document).ready(function() {
    // CONFIGURACIÓN DE PARSLEY: Decirle que NO ignore los selects ocultos por Select2
    $('form[name=assign-project-form]').parsley({
        excluded: 'input[type=button], input[type=submit], input[type=reset], input[type=hidden]:not(.ajax-get-responsible-list), input[readonly]'
    });

    var date = new Date();
    $('.input-date').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY'
    });

    $(".ajax-get-responsible-list").select2({
        placeholder: 'Asigne uno o mas responsables',
        allowClear: true
    });

    // Forzar a Parsley a re-validar los Select2 cuando cambien
    $('.ajax-get-responsible-list').on('change', function() {
        $(this).parsley().validate();
    });

    $('.input-date').on("dp.change",function(){
        var startDate = $("input[name=start-date]").val();
        var endDate = $("input[name=end-date]").val();
        calculateDateDiff(startDate, endDate);
    });

    $(document).on("submit","form[name=assign-project-form]",function(e){
        // Si el formulario no es válido según Parsley, detenemos el flujo aquí
        if (!$(this).parsley().isValid()) {
            return false; 
        }

        var responsible = "";
        var select2Data1 = $('#ajax-get-responsible-list1').select2("data");
        var select2Data2 = $('#ajax-get-responsible-list2').select2("data");
        
        // Clonamos el array para no mutar el estado visual de select2 de forma inesperada
        var combinedData = $.merge($.merge([], select2Data1), select2Data2);
        
        var responsibleList = [];
        $.each(combinedData, function(index, value){
            responsibleList.push(value.id);
            responsible += value.id+",";
        });
        
        if(responsible.length > 0) {
            responsible = responsible.substring(0, responsible.length - 1);
        }
        $("input[name=responsible-list]").val(responsible);
    });

    $(document).on("change","#ajax-get-responsible-list2",function(e){
       e.preventDefault();
       if($(this).select2("data").length > 0){
           var supervisingUser = $($(this).select2("data")[0].element).data("supervising-id");
           var supervisingResponsibleId = $("#ajax-get-responsible-list1 option[data-user-id="+supervisingUser+"]").val();
           
           // Al disparar el .trigger("change"), el listener de arriba ejecutará la validación automáticamente
           $("#ajax-get-responsible-list1").val(supervisingResponsibleId).trigger("change");
       }
    });

    $(document).on("change","#ajax-get-responsible-list2",function(e){
        e.preventDefault();
        console.log($(this).select2("data"));
    });
});

function calculateDateDiff(startDate, endDate)
{
    if(!startDate || !endDate) return;
    startDate = startDate.split("-");
    startDate = startDate[2]+"-"+startDate[1]+"-"+startDate[0];
    var date1 = new Date(startDate);
    endDate = endDate.split("-");
    endDate = endDate[2]+"-"+endDate[1]+"-"+endDate[0];
    var date2 = new Date(endDate);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    $("input[name=estimated-time]").val(diffDays);
}