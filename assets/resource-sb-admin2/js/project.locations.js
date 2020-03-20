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

    $(document).on("click",".search-project-in-map", function(){
        let projectCode = $("input[name=code]").val();
        findProject(projectCode);
    });
    showProjects(projectList);

});

function showProjects(projectList)
{
    $.each(projectList, function(index, value){
        addMarkerOnGlobalMap(value);
    });
}

function findProject(projectCode)
{
    $.each(projectList, function(index, value){
        if(value.code == projectCode)
        map.setCenter(value.latitude, value.longitude);
    });   
}
