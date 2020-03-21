var IncidentHandler = /** @class */ (function () {
    function IncidentHandler() {
        this._buttonAdd = ".add-incident";
        this._serverResponse = {};
        this._htmlTemplate = "";
        this._daysWithoutIncident = 0;
    }
    IncidentHandler.prototype.add = function (formData, statusId, projectId) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxIncident/add/' + statusId + '/' + projectId,
            dataType: "json",
            method: method,
            data: formData,
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this._launchForm(response);
                }
                else if (response.success === 1 && formData) {
                    var $tableProject = $("#project-index");
                    if ($tableProject.length <= 0) {
                        if (formData.pauseProject == 1 || formData.stopProject == 1) {
                            window.location.reload();
                        }
                        else {
                            var $incidentContent = $("#incident-content");
                            if ($incidentContent.length > 0 && $.isNumeric(statusId))
                                IncidentHandler.checkStatusIncidents(projectId, statusId);
                        }
                    }
                }
                else {
                    alert("error: " + response.message);
                }
            }
        });
    };
    IncidentHandler.prototype._launchForm = function (response) {
        var _this = this;
        var queue = { list: [], steps: [] };
        var list = [];
        var steps = [];
        this._serverResponse = response;
        this._htmlTemplate = response.template;
        var $template = $("<div>" + this._htmlTemplate + "</div>");
        var htmlSource = $template.find("#ht-modal-incident-form").html();
        var template = Handlebars.compile(htmlSource);
        $.each(response.projectList, function (index, value) {
            var data = { projectData: value };
            var html = template(data);
            list.push({ "title": value.code_pro + " - " + value.status_name_pst, "html": html });
            steps.push(index + 1);
        });
        queue.list = list;
        if (response.projectList.length > 1) {
            queue.steps = steps;
        }
        Swal.mixin({
            confirmButtonText: 'Guardar incidencia &rarr;',
            showCancelButton: false,
            focusConfirm: true,
            customClass: "incident-modal-form",
            progressSteps: queue.steps,
            preConfirm: function () {
                var $form = $("form[name=incident-form]");
                var incidentType = $("select[name=incident-type] option:selected").val();
                var noneIncidentGroup = {};
                if (incidentType == 9) {
                    noneIncidentGroup = { group: "none-incident" };
                }
                if ($form.parsley().isValid(noneIncidentGroup)) {
                    var projectId = $("input[name=project-id]").val();
                    var statusId = $("input[name=status-id]").val();
                    var detail = $('textarea[name=incident-detail]').val();
                    var percentage = $('input[name=incident-percentage]').val();
                    var entryDate = $('input[name=incident-manual-entry-date]').val();
                    var pauseProject = $("input[name=pause-project]").is(":checked") ? 1 : 0;
                    var stopProject = $("input[name=stop-project]").is(":checked") ? 1 : 0;
                    var formData = {
                        projectId: projectId,
                        statusId: statusId,
                        detail: detail,
                        percentage: percentage,
                        entryDate: entryDate,
                        pauseProject: pauseProject,
                        stopProject: stopProject,
                        incidentType: incidentType
                    };
                    _this.add(formData, statusId, projectId);
                    return [
                        $('textarea[name=incident-detail]').val(),
                        $("input[name=incident-manual-entry-date]").val()
                    ];
                }
                else {
                    $form.parsley().validate();
                    return false;
                }
            },
            onBeforeOpen: function () {
                var date = new Date();
                $('input[name=incident-manual-entry-date]').datetimepicker({
                    ignoreReadonly: true,
                    defaultDate: date,
                    format: 'DD-MM-YYYY'
                });
            }
        }).queue(queue.list).then(function (result) {
            if (result.value) {
                // Swal.fire({
                //     title: 'Guardando incidencias...',
                //     showConfirmButton: TRUE,
                // });
            }
        });
    };
    IncidentHandler.prototype.getAllIncidents = function () {
        var $content = $("#incident-content");
        var _this = this;
        blockArea($content);
        $.ajax({
            url: base_url + 'panel/AjaxIncident/getIncidentLog',
            dataType: "json",
            method: "GET",
            data: {},
            success: function (response) {
                var $template = $("<div>" + response.data.template + "</div>");
                var htmlSource = $template.find(response.data.templateName).html();
                var template = Handlebars.compile(htmlSource);
                var data = { incidentList: response.data.incidentList };
                var html = template(data);
                $content.html(html);
                // console.log(response);
                _this._setDaysWithoutIncidents(response.data.incidentList);
                new PerfectScrollbar('#incident-list', {
                    wheelSpeed: 2,
                    wheelPropagation: true,
                    minScrollbarLength: 50
                });
            }
        });
    };
    IncidentHandler.checkStatusIncidents = function (projectId, statusId) {
        var _this = this;
        var data = {
            projectId: projectId,
            statusId: statusId
        };
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/checkIncidents',
            dataType: "json",
            type: "POST",
            data: data,
            success: function (response) {
                var currentProjectPercentage = 0;
                if (response.allIncidents.length > 0) {
                    currentProjectPercentage = response.allIncidents[0].percentage_inc;
                }
                var data = { incidentList: response.incidentList, currentProjectPercentage: currentProjectPercentage };
                // let html = _this.getHandlebarHtml("#ht-modal-incident-list", data);
                var $template = $("<div>" + response.template + "</div>");
                var htmlSource = $template.find("#ht-modal-incident-list").html();
                var template = Handlebars.compile(htmlSource);
                var html = template(data);
                $("#incident-content").html(html);
            }
        });
    };
    IncidentHandler.prototype._setDaysWithoutIncidents = function (incidentList) {
        var lastIncident = incidentList[0];
        var momentLastDate = moment(lastIncident.manual_entry_date);
        var momentCurrentDate = moment();
        this._daysWithoutIncident = momentCurrentDate.diff(momentLastDate, 'days');
        var text = this._daysWithoutIncident > 1 ? this._daysWithoutIncident + " dias " : this._daysWithoutIncident + " dia ";
        $("#days-without-incidents").text(text);
    };
    IncidentHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on("click", this._buttonAdd, function (e) {
            e.preventDefault();
            var statusId = $(this).data("status-id");
            var projectId = $(this).data("project-id");
            _this.add(undefined, statusId, projectId);
            $('.popover').popover('destroy');
        });
    };
    return IncidentHandler;
}());
