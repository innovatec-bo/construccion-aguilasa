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
    $(".input-masked").inputmask();
    $(document).on("click", ".save-project",function(e){
        e.preventDefault();
        var projectStatus = $(this).data("project-status");
        $("input[name=project-status]").val(projectStatus);
        $(this).closest("form").submit();

    });
    defineSecondaryButtonVisibility(false);
    $(document).on("change","input[name=instant-approvement]",function(e){
        e.preventDefault();
        var instantApprovement = $(this).is(":checked");
        defineSecondaryButtonVisibility(instantApprovement);
    });
});

function defineSecondaryButtonVisibility(instantApprovement)
{
    if(instantApprovement)
    {
        $("[data-project-status=1]").addClass("hide");
        $("#approvement-section").removeClass("hide");
        $("#approvement-section").find("input[required]").attr("disabled",false);
    }
    else
    {
        $("[data-project-status=1]").removeClass("hide");
        $("#approvement-section").addClass("hide");
        $("#approvement-section").find("input[required]").attr("disabled",true);
    }
}