/**
 * Created by Jair on 07/06/2018.
 */

$(document).ready(function() {
    // Basic date
    var date = new Date();
    $('.input-group.date').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'DD-MM-YYYY'
    });

    $(document).on("click", ".save-project",function(e){
        e.preventDefault();
        var projectStatus = $(this).data("project-status");
        $("input[name=project-status]").val(projectStatus);
        $(this).closest("form").submit();

    });
});
