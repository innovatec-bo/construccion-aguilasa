/**
 * Created by Jair on 07/06/2018.
 */

$(document).ready(function() {

    $("select[name=project-cre-fiscal]").select2();
    // Basic date
    var date = new Date();
    $('.input-group.date').datetimepicker({
        ignoreReadonly: true,
        // defaultDate: date,
        showClear:true,
        format: 'DD-MM-YYYY'
    });

    $('.input-group.year').datetimepicker({
        ignoreReadonly: true,
        // defaultDate: date,
        format: 'YYYY'
    });

    $(document).on("click", ".save-project",function(e){
        e.preventDefault();
        var projectStatus = $(this).data("project-status");
        $("input[name=project-status]").val(projectStatus);
        $(this).closest("form").submit();
    });
});
