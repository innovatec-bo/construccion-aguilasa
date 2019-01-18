/**
 * Created by Jair on 30/05/2018.
 */

$(document).ready(function() {
    getProjectTotalsTable();
    getProjectNetBuilding();
    getCurrentStatusSummary();
    getExecutiveSummary();
    startSelect2TrackingList();
    var date = new Date();
    $('.date-time').datetimepicker({
        ignoreReadonly: true,
        defaultDate: date,
        format: 'YYYY'
    });
    $('#panel-report-project-totals-table input[name=report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        var dataType = $(this).closest("div#panel-report-project-totals-table").find("select[name=data-type] option:selected").val();
        var contractId = $(this).closest("div#panel-report-project-totals-table").find("input[name=contract-number]").val();
        getProjectTotalsTable(date.getFullYear(), dataType, contractId);
    });

    $(document).on("change",'#panel-report-project-totals-table select[name=data-type], #panel-report-project-totals-table select[name=contract-number]',function(){
        var date = $(this).closest("div#panel-report-project-totals-table").find("input[name=report-year]").val();
        var dataType = $(this).closest("div#panel-report-project-totals-table").find("select[name=data-type] option:selected").val();
        var contractId = $(this).closest("div#panel-report-project-totals-table").find("select[name=contract-number] option:selected").val();
        getProjectTotalsTable(date, dataType, contractId);
    });

    $('input[name=building-report-year]').on("dp.change",function(e){
        var date = new Date(e.date);
        var keyword = $('select[name=keyword] option:selected').val();
        getProjectNetBuilding(date.getFullYear(), keyword);
    });

    $('select[name=keyword]').on("change",function(e){
        var year = $('input[name=building-report-year]').val();
        var keyword = $(this).val();
        getProjectNetBuilding(year, keyword);
    });

    $('#panel-current-status-summary-report select').on("change",function(){
        var projectSystem = $('#panel-current-status-summary-report select[name=project-system] option:selected').val();
        var managementBy = $('#panel-current-status-summary-report select[name=management-by] option:selected').val();
        var contractNumber = $('#panel-current-status-summary-report select[name=contract-number] option:selected').val();
        getCurrentStatusSummary(projectSystem, managementBy, contractNumber);
        getExecutiveSummary(projectSystem, managementBy, contractNumber);
    });

    $(document).on("click",".find-th",function(e){
        e.preventDefault();
        var $td = $(this).closest("td");
        var $th = $td.closest('table').find('th').eq($td.index());

        var keyword = $td.closest(".panel.panel-default").find("select[name=keyword] option:selected").val();
        var year = $td.closest(".panel.panel-default").find("input[name=building-report-year]").val();
        var month = $th.data("month");
        var rowKey = $td.closest("tr").attr("class");
        var $form = $("form[name=workflow-with-parameters]");
        $form.find("input[name=keyword]").val(keyword);
        $form.find("input[name=year]").val(year);
        $form.find("input[name=month]").val(month);
        $form.find("input[name=rowKey]").val(rowKey);
        $form.submit();
    });

    $("input[type=radio][name=workflow-additional-actions]").on("change",function(){
       var action = $(this).val();
       switch (action)
       {
           case "1":
                $("input[name=tracking-list-name]").closest("div").slideDown();
               break;
           default:
               $("input[name=tracking-list-name]").closest("div").slideUp();

       }
    });

    $(".select2.tracking-list").on('select2:select', function (e) {
        var data = e.params.data;
        var codeList = data.code_list;
        $("textarea[name=code-list]").val(codeList);
        // console.log(data);
    });

    $("form[name=workflow-report]").on("submit", function(){
        var additionalActions = $("input[name=workflow-additional-actions]:checked").val();
        if(additionalActions !== "3")
        {
            saveTrackingList();
        }
    });

    $(".delete-tracking-list").on("click", function(){
        var select2 = $("select[name=tracking-list-id]").select2("data");
        if(typeof select2[0] === "undefined")
        {
            swal({ title:'', text:"Seleccione una lista para borrar", type:"error"});
        }
        else
        {
            deleteTrackingList(select2[0].id);
        }
    });

    $("form[name=workflow-report] button").on("click", function(e){
        var response = chooseWorkflowColumnsToDownload();
        // console.log(response);
    });

    var toggleCheckbox = 0;
    $(document).on("click", ".toggle-checkbox-status", function(e){
        e.preventDefault();
        toggleCheckbox++;
        if(toggleCheckbox%2 === 0)
        {
            $(".columns-to-download").find("input[type=checkbox]").not("[value=code_pro]").prop("checked", true);
        }
        else
        {
            $(".columns-to-download").find("input[type=checkbox]").not("[value=code_pro]").prop("checked", false);
        }
    });
});

function getProjectTotalsTable(year, dataType, contractId)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    dataType = typeof dataType !== 'undefined' ? dataType : "countId";
    contractId = typeof contractId !== 'undefined' ? contractId : "";
    var $content = $("#report-project-totals-table");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectTotalsTable',
        dataType  :"json",
        type : "POST",
        data:{year:year, dataType:dataType, contractId:contractId},
        success:function(response){

            if(response.success === 1)
            {
                var htmlSource   = $("#ht-report-project-totals-table").html();
                var template = Handlebars.compile(htmlSource);
                var data = {projectTotalsList:response.data};
                var html = template(data);

            }
            $content.html(html);
        }
    });
}

function getProjectNetBuilding(year, keyword)
{
    year = typeof year !== 'undefined' ? year : (new Date()).getFullYear();
    keyword = typeof keyword !== 'undefined' ? keyword : "project_has_been_created";
    var $content = $("#net-building-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getProjectNetBuilding',
        dataType  :"json",
        type : "POST",
        data:{year:year, keyword:keyword},
        success:function(response){

            if(response.success === 1)
            {
                var htmlSource   = $("#ht-report-net-building-table").html();
                var template = Handlebars.compile(htmlSource);
                var data = {projectTotalsList:response.data};
                var html = template(data);
            }
            $content.html(html);
        }
    });
}

function getCurrentStatusSummary(system, management, contract)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var $content = $("#current-status-summary-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getCurrentStatusSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract},
        success:function(response){

            if(response.success === 1)
            {
                var htmlSource   = $("#ht-report-current-status-summary").html();
                var template = Handlebars.compile(htmlSource);
                var data = {statusSummary:response.data};
                var html = template(data);
            }
            $content.html(html);
        }
    });
}

function saveTrackingList()
{
    var $formData = $("form[name=workflow-report]");
    blockArea($formData);
    $.ajax({
        url : base_url + 'panel/AjaxTrackingList/saveTrackingList',
        dataType  :"json",
        type : "POST",
        data:$formData.serialize(),
        success:function(response){
            $formData.unblock();
            var messageType = "error";
            if(response.success == 1)
                messageType = "success";

            swal({ title:'', text:response.message, type:messageType});
            $("#workflow-additional-actions3").prop("checked", true);
            $("input[name=tracking-list-name]").closest("div").slideUp();
            $('.select2.tracking-list').select2('destroy');
            startSelect2TrackingList()

        }
    });
}
function startSelect2TrackingList(selector)
{
    selector = selector || '.select2.tracking-list';
    $(selector).select2({
        placeholder: "Puede seleccionar una lista de seguimiento",
        containerCssClass: 'select-xs',
        allowClear : true,
        ajax : {
            url : base_url + 'panel/AjaxTrackingList/select2',
            dataType : "json",
            type : "post",
            delay : 600,
            data : function(params) {
                return {
                    term : params.term || "", //search term
                    limit : 5, // page size
                    page: params.page || 1
                };
            },

            processResults: function (data) {
                return {
                    results: data.list,
                    pagination: data.pagination
                };
            }
        },
        width : "100%"
    });
}
function getExecutiveSummary(system, management, contract)
{
    var system = typeof system !== 'undefined' ? system : "";
    var management = typeof management !== 'undefined' ? management : "";
    var contract = typeof contract !== 'undefined' ? contract : "";
    var $content = $("#executive-summary-report");
    blockArea($content);
    $.ajax({
        url : base_url + 'panel/AjaxDashboard/getExecutiveSummary',
        dataType  :"json",
        type : "POST",
        data:{system:system, management:management, contract:contract},
        success:function(response){
            // if(response.success === 1)
            // {
            var htmlSource   = $("#ht-report-executive-summary").html();
            var template = Handlebars.compile(htmlSource);
            var data = {executiveSummary:response};
            var html = template(data);
            // }
            $content.html(html);
        }
    });
}

function deleteTrackingList(trackingListId)
{
    var $formData = $("form[name=workflow-report]");
    blockArea($formData);
    $.ajax({
        url : base_url + 'panel/AjaxTrackingList/deleteTrackingList',
        dataType  :"json",
        type : "POST",
        data:{trackingListId:trackingListId},
        success:function(response){
            $formData.unblock();
            var messageType = "error";
            if(response.success == 1)
                messageType = "success";

            swal({ title:'', text:response.message, type:messageType});
            $("#workflow-additional-actions3").prop("checked", true);
            $("input[name=tracking-list-name]").closest("div").slideUp();

            $("select[name=tracking-list-id]").val(null).trigger("change");
            $formData.find("textarea[name=code-list]").val("");
            $('.select2.tracking-list').select2('destroy');
            startSelect2TrackingList();
        }
    });
}

function chooseWorkflowColumnsToDownload()
{
    var $form = $("form[workflow-report]");
    var data = $("input[name=workflow-column-list]").val();
    data = jQuery.parseJSON(data);
    var columnList = [];
    $.each(data, function(index, value){
        columnList.push({key:index, title:value});
    });
    var htmlSource   = $("#ht-workflow-report-columns-to-download").html();
    var template = Handlebars.compile(htmlSource);
    var data = {columnList:columnList};
    var html = template(data);
    var columnListToDownload = [];
    swal({
        title:'COLUMNAS A DESCARGAR',
        html:html,
        width:"80%",
        customClass:"columns-to-download",
        showCancelButton: true,
        confirmButtonText: 'Descargar!',
        allowOutsideClick:false,
        // onClose: () =>
        // {
        //     var checkboxList = $(".workflow-columns-to-download:checked");
        //     $.each(checkboxList, function(index, value){
        //         columnListToDownload.push($(value).val());
        //     });
        //     $("input[name=columns-to-download]").val(columnListToDownload);
        //     $("form[name=workflow-report]").submit();
        // }

    }).then((result) => {
        if (result.value)
        {
            var checkboxList = $(".workflow-columns-to-download:checked");
            $.each(checkboxList, function(index, value){
                columnListToDownload.push($(value).val());
            });
            $("input[name=columns-to-download]").val(columnListToDownload);
            $("form[name=workflow-report]").submit();
        }
    });
    enableSelect2ColumnsGroupsName();
}

function enableSelect2ColumnsGroupsName()
{
    $('#column-groups-name').select2({
        width: '100%',
        tags:true,
        placeholder: 'Seleccionar o añadir',
        insertTag: function (data, tag) {
            tag.isTag = true;
            // Insert the tag at the end of the results
            data.push(tag);
        },
        templateResult: formatSelect2Option
    }).on("select2:selecting select", function(e){
        var selectedOption = e.data || e.params.args.data;

        // If the selected option is a tag we trigger a custom event and prevent this one never happened.
        if (selectedOption.isTag) {
            // e.preventDefault();
            // e.stopPropagation();
            var groupList = [];
            var checkboxList = $(".workflow-columns-to-download:checked");
            $.each(checkboxList, function(index, value){
                groupList.push($(value).val());
            });
            addWfColumnGroup(selectedOption.text, groupList);
        }
    });
}
function formatSelect2Option(option) {
    if (option.isTag) {
        return $('<div class="add-new"><i class="fa fa-plus-circle fa-fw"></i> ' + option.text + '</div>')
    } else {
        return option.text
    }
}

function addWfColumnGroup(groupName, groupColumns)
{
    $.ajax({
        url : base_url + 'panel/AjaxWorkflowColumnGroup/add',
        dataType  :"json",
        type : "POST",
        data:{groupName:groupName, groupColumns:groupColumns},
        success:function(response){
            var data = {
                id: response.wfColumnGroup.wfGroupId,
                text: response.wfColumnGroup.wfGroupName
            };
            // $('#column-groups-name').trigger("select2:close");
            var newOption = new Option(data.text, data.id, false, false);
            $('#column-groups-name').append(newOption).trigger('change');
            $('#column-groups-name').val(data.id); // Select the option with a value of '1'
            $('#column-groups-name').trigger('change'); // Notify any JS components that the value changed
            console.log(response);
        }
    });
}