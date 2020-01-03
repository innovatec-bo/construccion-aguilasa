var StatusManagementHandler = /** @class */ (function () {
    function StatusManagementHandler(projectStatusSet, projectID) {
        this.projectStatusSet = projectStatusSet;
        this.projectID = projectID;
        this.statusSet = projectStatusSet;
        this.projectId = projectID;
        this.buttonAdd = ".save-status";
        this.buttonEdit = ".edit-status";
        this.buttonAddStep = ".add-step";
        this.buttonRemoveStep = ".remove-step";
        this.viewData = {};
        this.statusManagementContentSelector = "div#status-management-content";
        this.stopTreeLoop = false;
        this._breadCrumb = [];
        this.nextStep = [];
        this._statusFilesIdsToSave = [];
    }
    StatusManagementHandler.prototype.loadView = function () {
        var _this = this;
        blockArea($(_this.statusManagementContentSelector));
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/statusManagement/' + _this.statusSet + '/' + _this.projectId,
            dataType: "json",
            method: "GET",
            data: {},
            success: function (response) {
                _this.loadViewResponse = response;
                if (response.success === 1) {
                    _this.prepareViewData();
                    _this.loadViewTemplate = response.data.template;
                    var $template = $("<div>" + _this.loadViewTemplate + "</div>");
                    var htWizardStep = $template.find("#ht-wizard-step").html();
                    Handlebars.registerPartial("ht-wizard-step", htWizardStep);
                    var html = _this.getHandlebarHtml("#ht-status-management", { viewData: _this.viewData });
                    $(_this.statusManagementContentSelector).html(html);
                    _this.loadStatusForm(_this.viewData.project.keyword_pst, 0);
                    _this.projectLog();
                    _this._defineNextStep();
                }
                else {
                    // console.log("error: "+response.message);
                }
            }
        });
    };
    StatusManagementHandler.prototype.prepareViewData = function () {
        var project = this.loadViewResponse.data.projectFullDetail;
        var projectLog = this.loadViewResponse.data.projectLog;
        var allowUpdateHistory = this.loadViewResponse.data.updateHistory;
        var projectSystems = this.loadViewResponse.data.projectSystems;
        var statusList = this.loadViewResponse.data.statusList;
        var statusArray = this.loadViewResponse.data.statusArray;
        var statusSet = this.loadViewResponse.data.statusSet;
        var stepTree = this.loadViewResponse.data.stepTree;
        var updateHistory = this.loadViewResponse.data.updateHistory;
        var responsibleList = this.loadViewResponse.data.responsibleList;
        var responsibleListFiscal = this.loadViewResponse.data.responsibleListFiscal;
        var responsibleListBuilder = this.loadViewResponse.data.responsibleListBuilder;
        var statusName = "Este proyecto no esta en esta etapa";
        if (project.status_pro == 20) {
            statusName = "Este proyecto ha sido devuelto a CRE";
        }
        else if (statusList.hasOwnProperty(project.status_pro)) {
            statusName = statusList[project.status_pro].status_name_pst;
        }
        var showBtnEditConstructionAssignments = false;
        if (this.statusSet == "building" && this.loadViewResponse.data.updateHistory == 1) {
            showBtnEditConstructionAssignments = true;
        }
        this.viewData.statusName = statusName;
        this.viewData.project = project;
        this.viewData.projectLog = projectLog;
        this.viewData.allowUpdateHistory = allowUpdateHistory;
        this.viewData.statusSet = statusSet;
        this.viewData.updateHistory = updateHistory;
        this.viewData.responsibleList = responsibleList;
        this.viewData.responsibleListFiscal = responsibleListFiscal;
        this.viewData.responsibleListBuilder = responsibleListBuilder;
        this.viewData.project.system = projectSystems[project.system_pro];
        this.viewData.showBtnEditConstructionAssignments = showBtnEditConstructionAssignments;
        this.viewData.statusList = statusList;
        this.viewData.statusArray = statusArray;
        this._defineBreadCrumb();
        this.viewData.stepTree = stepTree;
        this._includeBtnAddStep();
        this.viewData.stepList = this._breadCrumb;
    };
    StatusManagementHandler.prototype._defineBreadCrumb = function () {
        var projectLog = this.loadViewResponse.data.projectLog;
        var viewData = this.viewData;
        var stepList = [];
        var previousStatusId = null;
        var previousOrder = 1000;
        var statusSetList = this.statusSetList();
        var memory = [];
        //Only loop up to current project status
        $.each(projectLog, function (index, value) {
            if (previousStatusId != value.status_id_psl && previousOrder >= parseInt(value.order_pst) && statusSetList.indexOf(value.keyword_pst) >= 0 && memory.indexOf(value.keyword_pst) == -1) {
                previousStatusId = value.status_id_psl;
                previousOrder = parseInt(value.order_pst);
                var completed = statusSetList.indexOf(value.keyword_pst) >= 0 ? " completed " : "";
                var stepStatus = value.status_id_psl == viewData.project.status_pro ? " active " : completed;
                var step = { stepId: value.status_id_psl, stepName: value.status_name_pst, stepKeyword: value.keyword_pst, stepIcon: value.status_icon_pst, stepStatus: stepStatus };
                stepList.push(step);
                memory.push(value.keyword_pst);
            }
        });
        //At this point we have the step list to drawing
        stepList.reverse();
        this._breadCrumb = stepList;
    };
    StatusManagementHandler.prototype.statusSetList = function () {
        var statusSet = [];
        statusSet["design"] = ["project_has_been_created", "stakes", "digitization", "drawing", "schedule", "returned"];
        statusSet["approvement"] = ["ready_to_send", "already_sent", "approved", "canceled", "rectify_design", "rectify_illustration"];
        statusSet["rectify_design"] = ["rectify_design", "rd_stakes", "rd_digitization", "rd_drawing"];
        statusSet["rectify_illustration"] = ["rectify_illustration", "ri_digitization", "ri_drawing"];
        statusSet["building"] = ["assign_to", "in_progress", "paused", "stopped", "completed", "project_energized", "as_built", "conciliation_reception", "conciliation_shipment", "cre_return_order", "project_return_materials", "project_real_budget_confirmation"];
        return statusSet[this.statusSet];
    };
    StatusManagementHandler.prototype.projectLog = function () {
        var _this = this;
        var viewData = this.viewData;
        var $logContent = $("#status-project-log-content");
        blockArea($logContent);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/getProjectLog',
            dataType: "json",
            type: "POST",
            data: { projectId: _this.projectId },
            success: function (response) {
                var allowUpdateHistory = viewData.allowUpdateHistory;
                var data = { projectLog: response, allowUpdateHistory: allowUpdateHistory };
                var html = _this.getHandlebarHtml("#ht-status-project-log-quick-view", data);
                $logContent.html(html);
                initPhotoSwipeFromDOM('.my-gallery');
            }
        });
    };
    StatusManagementHandler.prototype._includeBtnAddStep = function () {
        this._defineNextStep();
        if (this.nextStep.length > 0) {
            //Button to add more steps
            var step = { stepId: null, stepName: "", stepKeyword: null, stepIcon: "fa fa-plus", stepStatus: "li-add-step" };
            this._breadCrumb.push(step);
        }
    };
    StatusManagementHandler.prototype._defineNextStep = function () {
        var breadCrumb = [];
        $.each(this._breadCrumb, function (index, value) {
            if (value.stepKeyword !== null)
                breadCrumb.push(value.stepKeyword);
        });
        this.processTree(this.viewData.stepTree, 0, breadCrumb);
    };
    StatusManagementHandler.prototype.addStep = function (button) {
        this._defineNextStep();
        this.stopTreeLoop = false;
        var nextStep = this.nextStep;
        this.nextStep = []; //after assign this variable to a local variable let's set as empty
        var nextStepObjectArray = [];
        var statusList = this.loadViewResponse.data.statusList;
        $.each(statusList, function (index, value) {
            if (nextStep.includes(value.keyword_pst)) {
                var step = { stepId: value.id_pst, stepName: value.status_name_pst, stepKeyword: value.keyword_pst, stepIcon: value.status_icon_pst, stepStatus: "" };
                nextStepObjectArray.push(step);
            }
        });
        //if there is more than 1 step then let's show a component to select the next step
        if (nextStepObjectArray.length > 1) {
            this.launchStepSelector(button, nextStepObjectArray);
        }
        //if there is just one step then let's insert it in step list
        else {
            var step = nextStepObjectArray[0];
            this.insertStep(step);
            StatusManagementHandler.applyStepListClass(button, "addStep");
        }
    };
    StatusManagementHandler.prototype.insertStep = function (step) {
        var html = this.getHandlebarHtml("#ht-wizard-step", step);
        $(html).insertBefore($(".li-add-step"));
        this.loadStatusForm(step.stepKeyword, 1);
    };
    StatusManagementHandler.prototype.removeStep = function (button) {
        StatusManagementHandler.applyStepListClass(button, "removeStep");
        var statusKeyword = $(".step-list li.active a").prop("id");
        this.loadStatusForm(statusKeyword, 0);
    };
    StatusManagementHandler.applyStepListClass = function (button, event) {
        var $liStep = $(".step-list li");
        switch (event) {
            case 'addStep':
                button.parent().removeClass("li-add-step").addClass("li-remove-step");
                $liStep.removeClass("active").addClass("completed");
                button.parent().prev().removeClass("completed").addClass("active");
                button.removeClass("add-step").addClass("remove-step");
                button.find("i").removeClass("fa-plus").addClass("fa-minus");
                break;
            case 'removeStep':
                $(".step-list li:last-child").prev().remove();
                button.removeClass("remove-step").addClass("add-step");
                $liStep.removeClass("active").addClass("completed");
                button.parent().prev().removeClass("completed").addClass("active");
                button.parent().removeClass("li-remove-step").addClass("li-add-step");
                button.parent().prev().removeClass("completed").addClass("active");
                button.find("i").removeClass("fa-minus").addClass("fa-plus");
                break;
        }
    };
    StatusManagementHandler.prototype.launchStepSelector = function (button, nextStepObjectArray) {
        var project = this.viewData.project;
        var data = { nextStepObjectArray: nextStepObjectArray, project: project };
        var html = this.getHandlebarHtml("#ht-select-next-step", data);
        button.parent().popover("destroy");
        button.parent().popover({
            title: 'Elija el siguiente paso',
            html: true,
            content: html,
            placement: 'auto'
        });
        button.parent().trigger("click");
    };
    StatusManagementHandler.prototype.addStepFromList = function (step) {
        this.insertStep(step);
        var $button = $(".step-list .li-add-step").find("a");
        StatusManagementHandler.applyStepListClass($button, "addStep");
        $('.popover').popover('destroy');
    };
    StatusManagementHandler.prototype.loadStatusForm = function (statusKeyword, addMoreInfo) {
        var _this = this;
        var $statusFormContent = $("#status-form-content");
        blockArea($statusFormContent);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/verifyPreviousEntry',
            dataType: "json",
            type: "POST",
            data: { projectId: _this.projectId, statusKeyword: statusKeyword, statusSet: _this.statusSet },
            success: function (response) {
                _this._statusFilesIdsToSave = [];
                var html = "something went wrong";
                if (response.previousEntry[0] === undefined || addMoreInfo == 1) {
                    var points = $("#points").text();
                    var distance = $("#distance").text();
                    var responsibleGroup = StatusManagementHandler.getResponsibleGroup(statusKeyword);
                    var statusResponsible = responsibleGroup.responsibleList;
                    var responsibleListLength = responsibleGroup.responsibleListLength;
                    var assignmentResponsible = response.assignmentEntry.length > 0 ? JSON.parse("[" + response.assignmentEntry[0].jsonResponsible + "]") : [];
                    var assignmentResponsibleFiscal = [];
                    var assignmentResponsibleBuilder = [];
                    if (statusKeyword == "in_progress") {
                        assignmentResponsibleFiscal.push(assignmentResponsible[0]);
                        assignmentResponsibleBuilder = assignmentResponsible[1] || { id: null, name: "" };
                    }
                    var data = {
                        statusResponsible: statusResponsible,
                        responsibleListLength: responsibleListLength,
                        responsibleGroup: responsibleGroup,
                        points: points,
                        distance: distance,
                        statusKeyword: statusKeyword,
                        statusSet: _this.statusSet,
                        previousEntry: response.previousEntry[0],
                        assignmentResponsible: assignmentResponsible,
                        assignmentResponsibleFiscal: assignmentResponsibleFiscal,
                        assignmentResponsibleBuilder: assignmentResponsibleBuilder,
                        viewData: _this.viewData
                    };
                    html = _this.getHandlebarHtml("#ht-status-" + statusKeyword + "-form", data);
                }
                else {
                    var data = { statusKeyword: statusKeyword, statusSet: _this.statusSet, previousEntry: response.previousEntry[0] };
                    html = _this.getHandlebarHtml("#ht-status-" + statusKeyword + "-form-completed", data);
                }
                $statusFormContent.html(html);
                _this.statusFormStartSpecialComponents();
                StatusManagementHandler.updateTotalOnApprovedForm();
                _this.checkIncidents();
            }
        });
    };
    StatusManagementHandler.prototype.getHandlebarHtml = function (templateId, dataObject) {
        var $template = $("<div>" + this.loadViewTemplate + "</div>");
        var htmlSource = $template.find(templateId).html();
        var template = Handlebars.compile(htmlSource);
        return template(dataObject);
    };
    StatusManagementHandler.updateTotalOnApprovedForm = function () {
        var $totalAmountContent = $("#total-project-amount");
        if ($totalAmountContent.length == 1) {
            var design = parseFloat($("input[name=design-budget]").val().replace(",", ""));
            design = isNaN(design) ? 0 : design;
            var building = parseFloat($("input[name=building-budget]").val().replace(",", ""));
            building = isNaN(building) ? 0 : building;
            var transportation = parseFloat($("input[name=transportation-budget]").val().replace(",", ""));
            transportation = isNaN(transportation) ? 0 : transportation;
            var liveLine = parseFloat($("input[name=live-line-budget]").val().replace(",", ""));
            liveLine = isNaN(liveLine) ? 0 : liveLine;
            var rightOfWay = parseFloat($("input[name=right-of-way-budget]").val().replace(",", ""));
            rightOfWay = isNaN(rightOfWay) ? 0 : rightOfWay;
            var total = design + building + transportation + liveLine + rightOfWay;
            total = parseFloat(total.toFixed(2));
            $totalAmountContent.text(total);
        }
    };
    StatusManagementHandler.prototype.statusFormStartSpecialComponents = function () {
        var _this = this;
        var $dateTimePickerComponent = $('.date-time-picker');
        if ($dateTimePickerComponent.length > 0) {
            $.each($dateTimePickerComponent, function (index, value) {
                if (index === 0) {
                    var minDate = new Date(_this.viewData.projectLog[0].manual_entry_date_psl);
                    $(value).datetimepicker({
                        ignoreReadonly: true,
                        // defaultDate: minDate,
                        // minDate:minDate,
                        locale: "es",
                        format: 'DD-MM-YYYY'
                    });
                }
                else {
                    var defaultDate = new Date();
                    $(value).datetimepicker({
                        ignoreReadonly: true,
                        defaultDate: defaultDate,
                        locale: "es",
                        format: 'DD-MM-YYYY'
                    });
                }
            });
        }
        var $select2 = $(".select2");
        if ($select2.length > 0) {
            $select2.select2({
                placeholder: 'Asigne uno o mas responsables',
                allowClear: true
            });
        }
        var $responsibleList = $("#ajax-get-responsible-list");
        if ($responsibleList.length > 0) {
            $responsibleList.select2({
                placeholder: 'Asigne uno o mas responsables',
                allowClear: true
            });
        }
        var $inputMasked = $(".input-masked");
        if ($inputMasked.length > 0) {
            $inputMasked.inputmask();
        }
        var $dropzone = $('#dropzone');
        if ($dropzone.length > 0) {
            // Dropzone
            var myDropzone = new Dropzone("#dropzone", {
                url: base_url + "panel/projectStatus/saveStatusFiles",
                paramName: "file",
                maxFilesize: 1,
                parallelUploads: 15,
                maxFiles: 15,
                acceptedFiles: ".pdf, .jpg, .jpeg, .png",
                autoProcessQueue: false
            });
            myDropzone.on('addedfile', function (file) {
                var ext = file.name.split('.').pop();
                ext = ext.toLowerCase();
                var imageUrl = base_url + "assets/images/file-default-icon.png";
                if (ext == "pdf") {
                    imageUrl = base_url + "assets/images/pdf-icon.png";
                }
                else if (ext.indexOf("doc") != -1 || ext.indexOf("docx") != -1) {
                    imageUrl = base_url + "assets/images/docx-icon.png";
                }
                else if (ext.indexOf("xls") != -1 || ext.indexOf("xlsx") != -1) {
                    imageUrl = base_url + "assets/images/excel-icon.png";
                }
                else if (ext.indexOf("csv") != -1) {
                    imageUrl = base_url + "assets/images/csv-icon.png";
                }
                var timthumbImage = base_url + "timthumb/timthumb.php?src=" + imageUrl + "&w=90";
                $(file.previewElement).find(".dz-image img").attr("src", timthumbImage);
                var removeButton = Dropzone.createElement('<a class="btn btn-danger btn-xs dropzone-remove btn-block" href="#" title="" data-original-title="ELIMINAR" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a>');
                var _this = this;
                removeButton.addEventListener("click", function (e) {
                    // Make sure the button click doesn't submit the form:
                    e.preventDefault();
                    e.stopPropagation();
                    // Remove the file preview.
                    _this.removeFile(file);
                });
                // Now attach this new element some where in your page
                $("#dropzone").append(file.previewElement);
                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);
            });
            // myDropzone.on('queuecomplete', function() {
            //     console.log(_this._statusFilesIdsToSave);
            // });
            myDropzone.on("success", function (file, responseText) {
                var fileId = responseText;
                _this._statusFilesIdsToSave.push(fileId);
            });
        }
    };
    StatusManagementHandler.getResponsibleGroup = function (statusKeyword) {
        //all responsible by status keyword
        var response = {};
        var responsibleString = $("input[name=responsible-list]").val().toString();
        var responsibleList = JSON.parse(responsibleString);
        var statusResponsible = [];
        $.each(responsibleList, function (index, value) {
            if (value.keyword_pst == statusKeyword)
                statusResponsible.push(value);
        });
        var responsibleListLength = statusResponsible.length;
        response.responsibleList = statusResponsible;
        response.responsibleListLength = responsibleListLength;
        //all responsible by status keyword and role fiscal
        responsibleString = $("input[name=responsible-list-fiscal]").val().toString();
        var responsibleListFiscal = JSON.parse(responsibleString);
        var statusResponsibleFiscal = [];
        $.each(responsibleListFiscal, function (index, value) {
            statusResponsibleFiscal.push(value);
        });
        var responsibleListFiscalLength = statusResponsibleFiscal.length;
        response.responsibleListFiscal = statusResponsibleFiscal;
        response.responsibleListFiscalLength = responsibleListFiscalLength;
        //all responsible by status keyword and role builder
        responsibleString = $("input[name=responsible-list-builder]").val().toString();
        var responsibleListBuilder = JSON.parse(responsibleString);
        var statusResponsibleBuilder = [];
        $.each(responsibleListBuilder, function (index, value) {
            statusResponsibleBuilder.push(value);
        });
        var responsibleListBuilderLength = statusResponsibleBuilder.length;
        response.responsibleListBuilder = statusResponsibleBuilder;
        response.responsibleListBuilderLength = responsibleListBuilderLength;
        return response;
    };
    StatusManagementHandler.prototype.checkIncidents = function () {
        var _this = this;
        var $activeLink = $(".active a");
        var statusId = $activeLink.data("status-id");
        var data = {
            projectId: this.projectId,
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
                var html = _this.getHandlebarHtml("#ht-modal-incident-list", data);
                $("#incident-content").html(html);
            }
        });
    };
    StatusManagementHandler.prototype.saveStatus = function (button) {
        var $form = $("form[name=status-management]");
        var $content = $("#status-form-content");
        // let $button = $(".save-status");
        var statusKeyword = button.data("status-keyword");
        var statusId = button.data("status-id");
        var _this = this;
        if ($form.parsley().isValid({ group: statusKeyword })) {
            blockArea($content);
            if (Dropzone.instances.length > 0) {
                Dropzone.instances[0].processQueue();
                Dropzone.instances[0].on('queuecomplete', function () {
                    _this.chooseMethod(statusKeyword, statusId, button);
                });
            }
            else {
                _this.chooseMethod(statusKeyword, statusId, button);
            }
        }
        else {
            $form.parsley().validate({ group: statusKeyword });
        }
    };
    StatusManagementHandler.prototype.chooseMethod = function (statusKeyword, statusId, button) {
        switch (statusKeyword) {
            case "rd_stakes":
            case "stakes":
                this.saveBasicLog(statusId, statusKeyword);
                break;
            case "returned":
                this.saveBasicLog(statusId, statusKeyword);
                break;
            case "ri_digitization":
            case "rd_digitization":
            case "digitization":
                this.saveDigitization(statusId, statusKeyword, button);
                break;
            case "ri_drawing":
            case "rd_drawing":
            case "drawing":
                this.saveDrawing(statusId, statusKeyword, button);
                break;
            case "schedule":
                this.saveSchedule(statusId, statusKeyword);
                break;
            case "already_sent":
                this.saveBasicLog(statusId, statusKeyword);
                break;
            case "rectify_design":
                this.saveRectifyDesign(statusId, statusKeyword);
                break;
            case "rectify_illustration":
                this.saveRectifyIllustration(statusId, statusKeyword);
                break;
            case "approved":
                this.saveApproved(statusId, statusKeyword);
                break;
            case "canceled":
                this.saveCanceled(statusId, statusKeyword);
                break;
            case "in_progress":
                this.saveInProgress(statusId, statusKeyword);
                break;
            case "paused":
            case "stopped":
            case "completed":
                this.saveBasicLog(statusId, statusKeyword);
                break;
            case "project_energized":
                this.saveProjectEnergized(statusId, statusKeyword);
                break;
            case "as_built":
                this.saveAsBuilt(statusId, statusKeyword);
                break;
            case "conciliation_reception":
                this.saveBasicLog(statusId, statusKeyword);
                break;
            case "conciliation_shipment":
                this.saveConciliationShipment(statusId, statusKeyword);
                break;
            case "cre_return_order":
                this.saveCreReturnOrder(statusId, statusKeyword);
                break;
            case "project_return_materials":
            case "project_real_budget_confirmation":
                this.saveBasicLog(statusId, statusKeyword);
                break;
            default:
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Disculpe las molestias, aun no se ha establecido la logica para el guardado de los datos en esta etapa.'
                });
        }
    };
    StatusManagementHandler.prototype.saveBasicLog = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveBasicLog',
            dataType: "json",
            type: "POST",
            data: data,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveDigitization = function (statusId, statusKeyword, button) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var projectPoints = $("input[name=project-points]").val();
        var projectDistance = $("input[name=project-meters-distance]").val();
        var lastPoints = $("input[name=current-project-points]").val();
        var lastDistance = $("input[name=current-project-meters-distance]").val();
        var sendToApprovement = button.data("send-to-approvement");
        var digitization = {
            projectPoints: projectPoints,
            projectDistance: projectDistance,
            lastPoints: lastPoints,
            lastDistance: lastDistance,
            sendToApprovement: sendToApprovement
        };
        var dataResult = Object.assign(data, digitization);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveDigitization',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                if (sendToApprovement == 1) {
                    window.location = base_url + "panel/ProjectStatus/statusManagement/approvement/" + data.projectId;
                }
                else {
                    _this.loadView();
                }
            }
        });
    };
    StatusManagementHandler.prototype.saveDrawing = function (statusId, statusKeyword, button) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var sendToApprovement = button.data("send-to-approvement");
        var drawing = {
            sendToApprovement: sendToApprovement
        };
        var dataResult = Object.assign(data, drawing);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveDrawing',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                if (sendToApprovement == 1) {
                    window.location = base_url + "panel/ProjectStatus/statusManagement/approvement/" + data.projectId;
                }
                else {
                    _this.loadView();
                }
            }
        });
    };
    StatusManagementHandler.prototype.saveSchedule = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var projectStart = $("input[name=project-start]").val();
        var projectEnd = $("input[name=project-end]").val();
        var design = $("input[name=design]").val();
        var schedule = {
            projectStart: projectStart,
            projectEnd: projectEnd,
            design: design
        };
        var dataResult = Object.assign(data, schedule);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveSchedule',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveRectifyDesign = function (statusId, statusKeyword) {
        var _this = this;
        var dataResult = this.prepareDataToSave(statusId, statusKeyword);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveRectifyDesign',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                window.location = base_url + "panel/ProjectStatus/statusManagement/rectify_design/" + _this.projectId;
            }
        });
    };
    StatusManagementHandler.prototype.saveRectifyIllustration = function (statusId, statusKeyword) {
        var _this = this;
        var dataResult = this.prepareDataToSave(statusId, statusKeyword);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveRectifyIllustration',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                window.location = base_url + "panel/ProjectStatus/statusManagement/rectify_illustration/" + _this.projectId;
            }
        });
    };
    StatusManagementHandler.prototype.saveApproved = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var design = $("input[name=design-budget]").val();
        var building = $("input[name=building-budget]").val();
        var graphNumber = $("input[name=graph-number-budget]").val();
        var reservationNumber = $("input[name=reservation-number-budget]").val();
        var transportation = $("input[name=transportation-budget]").val();
        var liveLine = $("input[name=live-line-budget]").val();
        var rightOfWay = $("input[name=right-of-way-budget]").val();
        var secondaryCode = $("input[name=secondary-code]").val();
        var manpowerFileId = $("input[name=manpower-file-id]").val();
        var pointToPointFileId = $("input[name=point-to-point-file-id]").val();
        var approved = {
            design: design,
            building: building,
            graphNumber: graphNumber,
            reservationNumber: reservationNumber,
            transportation: transportation,
            liveLine: liveLine,
            rightOfWay: rightOfWay,
            secondaryCode: secondaryCode,
            manpowerFileId: manpowerFileId,
            pointToPointFileId: pointToPointFileId
        };
        var dataResult = Object.assign(data, approved);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveApproved',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveCanceled = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var design = $("input[name=design-budget]").val();
        var building = $("input[name=building-budget]").val();
        var canceled = {
            design: design,
            building: building
        };
        var dataResult = Object.assign(data, canceled);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveCanceled',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveInProgress = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var select2Data1 = $('.select2.fiscal').select2("data");
        var select2Data2 = $('.select2.builders').select2("data");
        Array.prototype.push.apply(select2Data1, select2Data2);
        var responsibleList = [];
        $.each(select2Data1, function (index, value) {
            responsibleList.push(value.id);
        });
        data.responsibleList = responsibleList;
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveBasicLog',
            dataType: "json",
            type: "POST",
            data: data,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveAsBuilt = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var projectPoints = $("input[name=project-points]").val();
        var projectDistance = $("input[name=project-meters-distance]").val();
        var asBuilt = {
            projectPoints: projectPoints,
            projectDistance: projectDistance
        };
        var dataResult = Object.assign(data, asBuilt);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveAsBuilt',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveProjectEnergized = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var projectEnergized = $("input[name=project-energized]").is(":checked") ? 1 : 0;
        var energized = {
            projectEnergized: projectEnergized
        };
        var dataResult = Object.assign(data, energized);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveProjectEnergized',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveConciliationShipment = function (statusId, statusKeyword) {
        var _this = this;
        var data = this.prepareDataToSave(statusId, statusKeyword);
        var design = $("input[name=design-budget]").val();
        var building = $("input[name=building-budget]").val();
        var transportation = $("input[name=transportation-budget]").val();
        var liveLine = $("input[name=live-line-budget]").val();
        var rightOfWay = $("input[name=right-of-way-budget]").val();
        var conciliationShipment = {
            design: design,
            building: building,
            transportation: transportation,
            liveLine: liveLine,
            rightOfWay: rightOfWay
        };
        var dataResult = Object.assign(data, conciliationShipment);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveConciliationShipment',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.saveCreReturnOrder = function (statusId, statusKeyword) {
        var _this = this;
        var dataResult = this.prepareDataToSave(statusId, statusKeyword);
        $.ajax({
            url: base_url + 'panel/AjaxProjectStatus/saveCreReturnOrder',
            dataType: "json",
            type: "POST",
            data: dataResult,
            success: function () {
                _this.loadView();
            }
        });
    };
    StatusManagementHandler.prototype.prepareDataToSave = function (statusId, statusKeyword) {
        var projectId = this.projectId;
        var select2Data = $('#ajax-get-responsible-list').select2("data");
        var responsibleList = [];
        $.each(select2Data, function (index, value) {
            responsibleList.push(value.id);
        });
        var entryDate = $("input[name=" + statusKeyword + "-entry-date]").val();
        var statusDetail = $("textarea[name=" + statusKeyword + "-detail]").val();
        return {
            projectId: projectId,
            entryDate: entryDate,
            statusId: statusId,
            statusKeyword: statusKeyword,
            statusDetail: statusDetail,
            responsibleList: responsibleList,
            statusFilesIdsToSave: this._statusFilesIdsToSave
        };
    };
    StatusManagementHandler.prototype.processTree = function (tree, index, breadCrumb) {
        for (var i = 0; i < tree.length; i++) {
            var step = tree[i];
            if (step.name == breadCrumb[index] && !this.stopTreeLoop) {
                index++;
                if (step.next.length > 0) {
                    if (index == breadCrumb.length) {
                        this.stopTreeLoop = true;
                    }
                    this.processTree(step.next, index, breadCrumb);
                    if (index == breadCrumb.length) {
                        for (var j = 0; j < step.next.length; j++) {
                            this.nextStep.push(step.next[j].name);
                        }
                    }
                }
            }
        }
    };
    StatusManagementHandler.prototype.loadEventHandler = function () {
        var _this = this;
        $(document).on("click", this.buttonAddStep, function (e) {
            e.preventDefault();
            var $button = $(this);
            $('.popover').popover('destroy');
            _this.addStep($button);
        });
        $(document).on("click", ".add-step-from-list", function (e) {
            e.preventDefault();
            var stepId = $(this).data("step-id");
            var stepName = $(this).data("step-name");
            var keyword = $(this).data("keyword");
            var icon = $(this).data("icon");
            var step = { stepId: stepId, stepName: stepName, stepKeyword: keyword, stepIcon: icon, stepStatus: "active" };
            _this.addStepFromList(step);
        });
        $(document).on("click", this.buttonRemoveStep, function (e) {
            e.preventDefault();
            var $button = $(this);
            _this.removeStep($button);
        });
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
            e.preventDefault();
            var keyword = $(this).prop("id");
            _this.loadStatusForm(keyword, 0);
        });
        $(document).on("click", ".cancel-add-step", function (e) {
            e.preventDefault();
            $('.popover').popover('destroy');
        });
        $(document).on("click", ".load-status-form-new-info", function (e) {
            e.preventDefault();
            var keyword = $(this).data("keyword");
            _this.loadStatusForm(keyword, 1);
            // console.log(keyword);
        });
        $(document).on("click", this.buttonAdd, function (e) {
            e.preventDefault();
            var $button = $(this);
            _this.saveStatus($button);
        });
        $(document).on("keyup", "input[name=design-budget], input[name=building-budget], input[name=transportation-budget], input[name=live-line-budget], input[name=right-of-way-budget]", function () {
            StatusManagementHandler.updateTotalOnApprovedForm();
        });
        $(document).on("click", ".extract-approved-budgets", function () {
            var formName = $(this).data('form-name');
            var saveInSystem = $(this).data('save-in-system');
            var form = $('form[name=' + formName + ']')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: base_url + "panel/AjaxProjectStatus/readManpowerFile/" + saveInSystem,
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                beforeSend: function () {
                    blockArea($(form));
                },
                success: function (response) {
                    $(form).unblock();
                    if (response.success == 1) {
                        var projectBudgetId = $("input[name=project-budget-id]").val();
                        if (projectBudgetId != "") {
                            _this.projectLog();
                            _this.loadStatusForm('approved', 0);
                        }
                        else {
                            var file = response.data.file;
                            var budget = response.data.budget;
                            var extraInfo = response.data.extraInfo;
                            var $form = $("#status-form-content");
                            $form.find("input[name=manpower-file-id]").val(file.id);
                            $form.find("input[name=design-budget]").val(budget.design);
                            $form.find("input[name=building-budget]").val(budget.building);
                            $form.find("input[name=transportation-budget]").val(budget.transportation);
                            $form.find("input[name=live-line-budget]").val(budget.liveLine);
                            $form.find("input[name=right-of-way-budget]").val(budget.rightOfWay);
                            $form.find("input[name=graph-number-budget]").val(extraInfo.graphNumber);
                            StatusManagementHandler.updateTotalOnApprovedForm();
                            console.log(response.data);
                        }
                    }
                    else {
                        Swal.fire({
                            type: 'error',
                            title: 'Error',
                            html: response.message
                        });
                        console.log(response.message);
                    }
                }
            });
        });
        $(document).on("click", ".extract-building-budgets", function () {
            var formName = $(this).data('form-name');
            var saveInSystem = $(this).data('save-in-system');
            var form = $('form[name=' + formName + ']')[0];
            var data = new FormData(form);
            var $form = $("#status-form-content");
            var manpowerFileId = $form.find("input[name=manpower-file-id]").val();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: base_url + "panel/AjaxProjectStatus/readPointToPointFile/" + saveInSystem + "/" + manpowerFileId,
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                beforeSend: function () {
                    blockArea($(form));
                },
                success: function (response) {
                    $(form).unblock();
                    if (response.success == 1) {
                        var projectBudgetId = $("input[name=project-budget-id]").val();
                        var manpowerFileId_1 = $("input[name=manpower-file-id]").val();
                        if (projectBudgetId != "" && saveInSystem == 1) {
                            _this.projectLog();
                            _this.loadStatusForm('approved', 0);
                        }
                        else {
                            var file = response.data.file;
                            var budget = response.data.budget;
                            var $form_1 = $("#status-form-content");
                            $form_1.find("input[name=point-to-point-file-id]").val(file.id);
                            $form_1.find("input[name=building-budget]").val(budget.building);
                            StatusManagementHandler.updateTotalOnApprovedForm();
                            console.log(response.data);
                        }
                    }
                    else {
                        Swal.fire({
                            type: 'error',
                            title: 'Error',
                            html: response.message
                        });
                        console.log(response.message);
                    }
                }
            });
        });
    };
    return StatusManagementHandler;
}());
