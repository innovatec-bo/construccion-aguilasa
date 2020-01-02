// export {};
declare let Handlebars: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let Object: any;
declare let window: any;
declare let Swal: any;
declare let Dropzone: any;
class StatusManagementHandler
{
    private statusSet: string;
    private projectId: number;
    private buttonAddStep: string;
    private buttonRemoveStep: string;
    private buttonAdd: string;
    private buttonEdit: string;
    private statusManagementContentSelector: string;
    private loadViewResponse: any;
    private loadViewTemplate: any;
    private viewData: any;
    private stopTreeLoop: boolean;
    private _breadCrumb : any;
    private nextStep: any;
    private _statusFilesIdsToSave: any;
    constructor(private projectStatusSet: string, private projectID: number)
    {
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

    loadView()
    {
        let _this = this;
        blockArea($(_this.statusManagementContentSelector));
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/statusManagement/' + _this.statusSet + '/' + _this.projectId,
            dataType  :"json",
            method : "GET",
            data:{},
            success:function(response){
                _this.loadViewResponse = response;
                if(response.success === 1)
                {
                    _this.prepareViewData();
                    _this.loadViewTemplate = response.data.template;
                    let $template = $("<div>"+_this.loadViewTemplate+"</div>");
                    let htWizardStep = $template.find("#ht-wizard-step").html();
                    Handlebars.registerPartial("ht-wizard-step", htWizardStep);
                    let html = _this.getHandlebarHtml("#ht-status-management",{viewData:_this.viewData});
                    $(_this.statusManagementContentSelector).html(html);
                    _this.loadStatusForm(_this.viewData.project.keyword_pst,0);
                    _this.projectLog();
                    _this._defineNextStep();
                }
                else
                {
                    // console.log("error: "+response.message);
                }
            }
        });
    }

    prepareViewData()
    {
        let project = this.loadViewResponse.data.projectFullDetail;
        let projectLog = this.loadViewResponse.data.projectLog;
        let allowUpdateHistory = this.loadViewResponse.data.updateHistory;
        let projectSystems = this.loadViewResponse.data.projectSystems;
        let statusList = this.loadViewResponse.data.statusList;
        let statusArray = this.loadViewResponse.data.statusArray;
        let statusSet = this.loadViewResponse.data.statusSet;
        let stepTree = this.loadViewResponse.data.stepTree;
        let updateHistory = this.loadViewResponse.data.updateHistory;
        let responsibleList = this.loadViewResponse.data.responsibleList;
        let responsibleListFiscal = this.loadViewResponse.data.responsibleListFiscal;
        let responsibleListBuilder = this.loadViewResponse.data.responsibleListBuilder;
        let statusName = "Este proyecto no esta en esta etapa";
        if(project.status_pro == 20)
        {
            statusName = "Este proyecto ha sido devuelto a CRE";
        }
        else if(statusList.hasOwnProperty(project.status_pro))
        {
            statusName = statusList[project.status_pro].status_name_pst
        }

        let showBtnEditConstructionAssignments = false;
        if(this.statusSet == "building" && this.loadViewResponse.data.updateHistory == 1)
        {
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
    }

    private _defineBreadCrumb()
    {
        let projectLog = this.loadViewResponse.data.projectLog;
        let viewData = this.viewData;
        let stepList = [];
        let previousStatusId = null;
        let previousOrder = 1000;
        let statusSetList = this.statusSetList();
        let memory = [];
        //Only loop up to current project status
        $.each(projectLog, function(index, value){
            if(previousStatusId != value.status_id_psl && previousOrder >= parseInt(value.order_pst) && statusSetList.indexOf(value.keyword_pst) >= 0 && memory.indexOf(value.keyword_pst) == -1)
            {
                previousStatusId = value.status_id_psl;
                previousOrder = parseInt(value.order_pst);
                let completed = statusSetList.indexOf(value.keyword_pst) >= 0?" completed ":"";
                let stepStatus =  value.status_id_psl == viewData.project.status_pro?" active ":completed;
                let step = {stepId:value.status_id_psl, stepName:value.status_name_pst, stepKeyword: value.keyword_pst, stepIcon: value.status_icon_pst, stepStatus:stepStatus};
                stepList.push(step);
                memory.push(value.keyword_pst);
            }
        });
        //At this point we have the step list to drawing
        stepList.reverse();
        this._breadCrumb = stepList;
    }

    statusSetList()
    {
        let statusSet = [];
        statusSet["design"] = ["project_has_been_created", "stakes", "digitization", "drawing", "schedule","returned"];
        statusSet["approvement"] = ["ready_to_send", "already_sent", "approved", "canceled", "rectify_design","rectify_illustration"];
        statusSet["rectify_design"] = ["rectify_design", "rd_stakes", "rd_digitization", "rd_drawing"];
        statusSet["rectify_illustration"] = ["rectify_illustration", "ri_digitization", "ri_drawing"];
        statusSet["building"] = ["assign_to", "in_progress", "paused","stopped","completed","project_energized","as_built","conciliation_reception","conciliation_shipment","cre_return_order","project_return_materials","project_real_budget_confirmation"];
        return statusSet[this.statusSet];
    }

    projectLog()
    {
        let _this = this;
        let viewData = this.viewData;
        let $logContent = $("#status-project-log-content");
        blockArea($logContent);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/getProjectLog',
            dataType  :"json",
            type : "POST",
            data : {projectId:_this.projectId},
            success:function(response){
                let allowUpdateHistory = viewData.allowUpdateHistory;
                let data = {projectLog:response,allowUpdateHistory:allowUpdateHistory};
                let html = _this.getHandlebarHtml("#ht-status-project-log-quick-view", data);
                $logContent.html(html);
            }
        });
    }

    private _includeBtnAddStep()
    {
        this._defineNextStep();
        if(this.nextStep.length > 0)
        {
            //Button to add more steps
            let step = {stepId:null, stepName:"", stepKeyword: null, stepIcon:"fa fa-plus", stepStatus:"li-add-step"};
            this._breadCrumb.push(step);
        }
    }

    private _defineNextStep()
    {
        let breadCrumb = [];
        $.each(this._breadCrumb,function(index, value){
            if(value.stepKeyword !== null)
                breadCrumb.push(value.stepKeyword);
        });
        this.processTree(this.viewData.stepTree,0, breadCrumb);
    }

    addStep(button)
    {
        this._defineNextStep();
        this.stopTreeLoop = false;
        let nextStep = this.nextStep;
        this.nextStep = [];//after assign this variable to a local variable let's set as empty
        let nextStepObjectArray = [];
        let statusList = this.loadViewResponse.data.statusList;
        $.each(statusList, function(index, value){
            if(nextStep.includes(value.keyword_pst))
            {
                let step = {stepId: value.id_pst, stepName: value.status_name_pst, stepKeyword:  value.keyword_pst, stepIcon: value.status_icon_pst, stepStatus:""};
                nextStepObjectArray.push(step);
            }
        });

        //if there is more than 1 step then let's show a component to select the next step
        if(nextStepObjectArray.length > 1)
        {
            this.launchStepSelector(button, nextStepObjectArray);
        }
        //if there is just one step then let's insert it in step list
        else
        {
            let step = nextStepObjectArray[0];
            this.insertStep(step);
            StatusManagementHandler.applyStepListClass(button,"addStep");
        }
    }

    insertStep(step)
    {
        let html = this.getHandlebarHtml("#ht-wizard-step", step);
        $(html).insertBefore($(".li-add-step"));
        this.loadStatusForm(step.stepKeyword,1);
    }

    removeStep(button)
    {
        StatusManagementHandler.applyStepListClass(button, "removeStep");
        let statusKeyword = $(".step-list li.active a").prop("id");
        this.loadStatusForm(statusKeyword, 0);
    }

    static applyStepListClass(button, event)
    {
        let $liStep : any = $(".step-list li");
        switch (event)
        {
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
    }

    launchStepSelector(button, nextStepObjectArray)
    {
        let project = this.viewData.project;
        let data = {nextStepObjectArray:nextStepObjectArray, project:project };
        let html = this.getHandlebarHtml("#ht-select-next-step", data);
        button.parent().popover("destroy");
        button.parent().popover({
            title:'Elija el siguiente paso',
            html:true,
            content:html,
            placement:'auto'
        });
        button.parent().trigger("click");
    }

    addStepFromList(step)
    {
        this.insertStep(step);
        let $button = $(".step-list .li-add-step").find("a");
        StatusManagementHandler.applyStepListClass($button,"addStep");
        $('.popover').popover('destroy');
    }

    loadStatusForm(statusKeyword, addMoreInfo)
    {
        let _this = this;
        let $statusFormContent = $("#status-form-content");
        blockArea($statusFormContent);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/verifyPreviousEntry',
            dataType  :"json",
            type : "POST",
            data : {projectId:_this.projectId, statusKeyword:statusKeyword, statusSet:_this.statusSet},
            success:function(response){
                _this._statusFilesIdsToSave = [];
                let html = "something went wrong";
                if(response.previousEntry[0] === undefined || addMoreInfo ==  1)
                {
                    let points = $("#points").text();
                    let distance = $("#distance").text();
                    let responsibleGroup = StatusManagementHandler.getResponsibleGroup(statusKeyword);
                    let statusResponsible = responsibleGroup.responsibleList;
                    let responsibleListLength = responsibleGroup.responsibleListLength;
                    let assignmentResponsible = response.assignmentEntry.length > 0?JSON.parse("["+response.assignmentEntry[0].jsonResponsible+"]"):[];
                    let assignmentResponsibleFiscal = [];
                    let assignmentResponsibleBuilder = [];
                    if(statusKeyword == "in_progress")
                    {
                        assignmentResponsibleFiscal.push(assignmentResponsible[0]);
                        assignmentResponsibleBuilder = assignmentResponsible[1] || {id:null, name:""};
                    }
                    let data = {
                        statusResponsible:statusResponsible,
                        responsibleListLength:responsibleListLength,
                        responsibleGroup:responsibleGroup,
                        points:points,
                        distance:distance,
                        statusKeyword:statusKeyword,
                        statusSet:_this.statusSet,
                        previousEntry:response.previousEntry[0],
                        assignmentResponsible:assignmentResponsible,
                        assignmentResponsibleFiscal: assignmentResponsibleFiscal,
                        assignmentResponsibleBuilder: assignmentResponsibleBuilder,
                        viewData: _this.viewData
                    };
                    html = _this.getHandlebarHtml("#ht-status-"+statusKeyword+"-form", data);
                }
                else
                {
                    let data = {statusKeyword:statusKeyword,statusSet:_this.statusSet,previousEntry:response.previousEntry[0]};
                    html = _this.getHandlebarHtml("#ht-status-"+statusKeyword+"-form-completed", data);
                }
                $statusFormContent.html(html);
                _this.statusFormStartSpecialComponents();
                StatusManagementHandler.updateTotalOnApprovedForm();
                _this.checkIncidents();
            }
        });
    }

    getHandlebarHtml(templateId, dataObject)
    {
        let $template = $("<div>"+this.loadViewTemplate+"</div>");
        let htmlSource   = $template.find(templateId).html();
        let template = Handlebars.compile(htmlSource);
        return template(dataObject);
    }

    static updateTotalOnApprovedForm()
    {
        let $totalAmountContent : any = $("#total-project-amount");
        if($totalAmountContent.length == 1)
        {
            let design : number = parseFloat($("input[name=design-budget]").val().replace(",",""));
            design = isNaN(design)?0:design;
            let building : number = parseFloat($("input[name=building-budget]").val().replace(",",""));
            building = isNaN(building)?0:building;
            let transportation : number = parseFloat($("input[name=transportation-budget]").val().replace(",",""));
            transportation = isNaN(transportation)?0:transportation;
            let liveLine : number = parseFloat($("input[name=live-line-budget]").val().replace(",",""));
            liveLine = isNaN(liveLine)?0:liveLine;
            let rightOfWay : number = parseFloat($("input[name=right-of-way-budget]").val().replace(",",""));
            rightOfWay = isNaN(rightOfWay)?0:rightOfWay;
            let total : number = design + building + transportation + liveLine + rightOfWay;
            total = parseFloat(total.toFixed(2));
            $totalAmountContent.text(total);
        }
    }

    statusFormStartSpecialComponents()
    {
        let _this = this;
        let $dateTimePickerComponent = $('.date-time-picker');

        if($dateTimePickerComponent.length > 0)
        {
            $.each($dateTimePickerComponent, function(index, value){
                if(index === 0)
                {
                    let minDate = new Date(_this.viewData.projectLog[0].manual_entry_date_psl);
                    $(value).datetimepicker({
                        ignoreReadonly: true,
                        // defaultDate: minDate,
                        // minDate:minDate,
                        locale:"es",
                        format: 'DD-MM-YYYY'
                    });
                }
                else
                {
                    let defaultDate = new Date();
                    $(value).datetimepicker({
                        ignoreReadonly: true,
                        defaultDate: defaultDate,
                        locale:"es",
                        format: 'DD-MM-YYYY'
                    });
                }
            });
        }
        let $select2 = $(".select2");
        if($select2.length > 0)
        {
            $select2.select2({
                placeholder: 'Asigne uno o mas responsables',
                allowClear: true
            });
        }
        let $responsibleList = $("#ajax-get-responsible-list");
        if($responsibleList.length > 0)
        {
            $responsibleList.select2({
                placeholder: 'Asigne uno o mas responsables',
                allowClear: true
            });
        }

        let $inputMasked = $(".input-masked");
        if($inputMasked.length > 0)
        {
            $inputMasked.inputmask();
        }
    
        let $dropzone = $('#dropzone');
        if($dropzone.length > 0)
        {
            // Dropzone
            let myDropzone = new Dropzone("#dropzone",{
            url: base_url + "panel/projectStatus/saveStatusFiles",
            paramName: "file",
            maxFilesize: 30,
            acceptedFiles: ".pdf, .jpg, .jpeg, .png",
            autoProcessQueue:false,
            // addRemoveLinks:true
            });    
            myDropzone.on('addedfile', function(file) {
                let ext = file.name.split('.').pop();
                ext = ext.toLowerCase();
                let imageUrl = base_url + "assets/images/file-default-icon.png";
                if (ext == "pdf")
                {
                    imageUrl = base_url + "assets/images/pdf-icon.png";
                } 
                else if (ext.indexOf("doc") != -1 || ext.indexOf("docx") != -1) 
                {
                    imageUrl = base_url + "assets/images/docx-icon.png";
                } 
                else if (ext.indexOf("xls") != -1 || ext.indexOf("xlsx") != -1) 
                {
                    imageUrl = base_url + "assets/images/excel-icon.png";
                }
                else if (ext.indexOf("csv") != -1) 
                {
                    imageUrl = base_url + "assets/images/csv-icon.png";
                }
                let timthumbImage = base_url+"timthumb/timthumb.php?src="+imageUrl+"&w=90";
                $(file.previewElement).find(".dz-image img").attr("src", timthumbImage);
                let removeButton = Dropzone.createElement('<a class="btn btn-danger btn-xs dropzone-remove btn-block" href="#" title="" data-original-title="ELIMINAR" data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a>');
                let _this = this;
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
            myDropzone.on("success", function(file, responseText) {
                let fileId = responseText;
               _this._statusFilesIdsToSave.push(fileId);
               
            });

        }
    }

    static getResponsibleGroup(statusKeyword)
    {
        //all responsible by status keyword
        let response: any = {};
        let responsibleString : string = $("input[name=responsible-list]").val().toString();
        let responsibleList = JSON.parse(responsibleString);
        let statusResponsible: any[] = [];
        $.each(responsibleList,function(index,value){
            if(value.keyword_pst == statusKeyword)
                statusResponsible.push(value);
        });
        let responsibleListLength = statusResponsible.length;
        response.responsibleList = statusResponsible;
        response.responsibleListLength = responsibleListLength;

        //all responsible by status keyword and role fiscal
        responsibleString = $("input[name=responsible-list-fiscal]").val().toString();
        let responsibleListFiscal = JSON.parse(responsibleString);
        let statusResponsibleFiscal = [];
        $.each(responsibleListFiscal,function(index,value){
            statusResponsibleFiscal.push(value);
        });
        let responsibleListFiscalLength = statusResponsibleFiscal.length;
        response.responsibleListFiscal = statusResponsibleFiscal;
        response.responsibleListFiscalLength = responsibleListFiscalLength;

        //all responsible by status keyword and role builder
        responsibleString = $("input[name=responsible-list-builder]").val().toString();
        let responsibleListBuilder = JSON.parse(responsibleString);
        let statusResponsibleBuilder = [];
        $.each(responsibleListBuilder,function(index,value){
            statusResponsibleBuilder.push(value);
        });
        let responsibleListBuilderLength = statusResponsibleBuilder.length;
        response.responsibleListBuilder = statusResponsibleBuilder;
        response.responsibleListBuilderLength = responsibleListBuilderLength;

        return response;
    }

    checkIncidents()
    {
        let _this : any = this;
        let $activeLink : any = $(".active a");
        let statusId : number = $activeLink.data("status-id");
        let data : any = {
            projectId: this.projectId,
            statusId: statusId
        };
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/checkIncidents',
            dataType  :"json",
            type : "POST",
            data:data,
            success:function(response){
                let currentProjectPercentage: number = 0;
                if(response.allIncidents.length > 0)
                {
                    currentProjectPercentage = response.allIncidents[0].percentage_inc;
                }
                let data = {incidentList:response.incidentList, currentProjectPercentage:currentProjectPercentage};
                let html = _this.getHandlebarHtml("#ht-modal-incident-list", data);
                $("#incident-content").html(html);
            }
        });
    }

    saveStatus(button)
    {
        let $form = $("form[name=status-management]");
        let $content = $("#status-form-content");
        // let $button = $(".save-status");
        let statusKeyword = button.data("status-keyword");
        let statusId = button.data("status-id");
        let _this = this;
        if($form.parsley().isValid({group: statusKeyword}))
        {
            blockArea($content);
            if(Dropzone.instances.length > 0)
            {
                Dropzone.instances[0].processQueue();
                Dropzone.instances[0].on('queuecomplete', function() {
                    _this.chooseMethod(statusKeyword, statusId, button);
                });
            }
            else
            {
                _this.chooseMethod(statusKeyword, statusId, button);
            }
        }
        else
        {
            $form.parsley().validate({group: statusKeyword});
        }
    }

    chooseMethod(statusKeyword, statusId, button)
    {
        switch(statusKeyword)
        {
            case "rd_stakes":
            case "stakes":
                this.saveBasicLog(statusId, statusKeyword);
                break;
            case "returned":
                this.saveBasicLog(statusId,statusKeyword);
                break;
            case "ri_digitization":
            case "rd_digitization":
            case "digitization":
                this.saveDigitization(statusId,statusKeyword, button);
                break;
            case "ri_drawing":
            case "rd_drawing":
            case "drawing":
                this.saveDrawing(statusId,statusKeyword,button);
                break;
            case "schedule":
                this.saveSchedule(statusId,statusKeyword);
                break;
            case "already_sent":
                this.saveBasicLog(statusId,statusKeyword);
                break;
            case "rectify_design":
                this.saveRectifyDesign(statusId,statusKeyword);
                break;
            case "rectify_illustration":
                this.saveRectifyIllustration(statusId,statusKeyword);
                break;
            case "approved":
                this.saveApproved(statusId,statusKeyword);
                break;
            case "canceled":
                this.saveCanceled(statusId,statusKeyword);
                break;
            case "in_progress":
                this.saveInProgress(statusId,statusKeyword);
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
                this.saveCreReturnOrder(statusId,statusKeyword);
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
    }

    saveBasicLog(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveBasicLog',
            dataType  :"json",
            type : "POST",
            data : data,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveDigitization(statusId, statusKeyword, button)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);
        let projectPoints = $("input[name=project-points]").val();
        let projectDistance = $("input[name=project-meters-distance]").val();
        let lastPoints = $("input[name=current-project-points]").val();
        let lastDistance = $("input[name=current-project-meters-distance]").val();
        let sendToApprovement = button.data("send-to-approvement");
        let digitization = {
            projectPoints: projectPoints,
            projectDistance: projectDistance,
            lastPoints: lastPoints,
            lastDistance: lastDistance,
            sendToApprovement:sendToApprovement
        };
        let dataResult = Object.assign(data, digitization);

        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveDigitization',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                if(sendToApprovement == 1)
                {
                    window.location = base_url + "panel/ProjectStatus/statusManagement/approvement/"+data.projectId;
                }
                else
                {
                    _this.loadView();
                }
            }
        });
    }

    saveDrawing(statusId,statusKeyword,button)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);
        let sendToApprovement = button.data("send-to-approvement");
        let drawing = {
            sendToApprovement:sendToApprovement
        };
        let dataResult = Object.assign(data, drawing);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveDrawing',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                if(sendToApprovement == 1)
                {
                    window.location = base_url + "panel/ProjectStatus/statusManagement/approvement/"+data.projectId;
                }
                else
                {
                    _this.loadView();
                }
            }
        });
    }

    saveSchedule(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);
        let projectStart = $("input[name=project-start]").val();
        let projectEnd = $("input[name=project-end]").val();
        let design = $("input[name=design]").val();
        let schedule = {
            projectStart: projectStart,
            projectEnd: projectEnd,
            design: design
        };
        let dataResult = Object.assign(data, schedule);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveSchedule',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveRectifyDesign(statusId,statusKeyword)
    {
        let _this = this;
        let dataResult = this.prepareDataToSave(statusId, statusKeyword);

        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveRectifyDesign',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                window.location = base_url + "panel/ProjectStatus/statusManagement/rectify_design/"+_this.projectId;
            }
        });
    }

    saveRectifyIllustration(statusId, statusKeyword)
    {
        let _this = this;
        let dataResult = this.prepareDataToSave(statusId, statusKeyword);

        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveRectifyIllustration',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                window.location = base_url + "panel/ProjectStatus/statusManagement/rectify_illustration/"+_this.projectId;
            }
        });
    }

    saveApproved(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);

        let design = $("input[name=design-budget]").val();
        let building = $("input[name=building-budget]").val();
        let graphNumber = $("input[name=graph-number-budget]").val();
        let reservationNumber = $("input[name=reservation-number-budget]").val();
        let transportation = $("input[name=transportation-budget]").val();
        let liveLine = $("input[name=live-line-budget]").val();
        let rightOfWay = $("input[name=right-of-way-budget]").val();
        let secondaryCode = $("input[name=secondary-code]").val();
        let manpowerFileId = $("input[name=manpower-file-id]").val();
        let pointToPointFileId = $("input[name=point-to-point-file-id]").val();
        let approved = {
            design: design,
            building: building,
            graphNumber: graphNumber,
            reservationNumber: reservationNumber,
            transportation:transportation,
            liveLine:liveLine,
            rightOfWay:rightOfWay,
            secondaryCode:secondaryCode,
            manpowerFileId:manpowerFileId,
            pointToPointFileId:pointToPointFileId
        };
        let dataResult = Object.assign(data, approved);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveApproved',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveCanceled(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);

        let design = $("input[name=design-budget]").val();
        let building = $("input[name=building-budget]").val();
        let canceled = {
            design: design,
            building: building
        };
        let dataResult = Object.assign(data, canceled);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveCanceled',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveInProgress(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);

        let select2Data1 = $('.select2.fiscal').select2("data");
        let select2Data2 = $('.select2.builders').select2("data");
        Array.prototype.push.apply(select2Data1,select2Data2);
        let responsibleList = [];
        $.each(select2Data1, function(index, value){
            responsibleList.push(value.id);
        });
        data.responsibleList = responsibleList;

        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveBasicLog',
            dataType  :"json",
            type : "POST",
            data : data,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveAsBuilt(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);
        let projectPoints = $("input[name=project-points]").val();
        let projectDistance = $("input[name=project-meters-distance]").val();
        let asBuilt = {
            projectPoints: projectPoints,
            projectDistance: projectDistance
        };
        let dataResult = Object.assign(data, asBuilt);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveAsBuilt',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveProjectEnergized(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);

        let projectEnergized = $("input[name=project-energized]").is(":checked")?1:0;
        let energized = {
            projectEnergized:projectEnergized,
        };

        let dataResult = Object.assign(data, energized);
        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveProjectEnergized',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveConciliationShipment(statusId,statusKeyword)
    {
        let _this = this;
        let data = this.prepareDataToSave(statusId, statusKeyword);

        let design = $("input[name=design-budget]").val();
        let building = $("input[name=building-budget]").val();
        let transportation = $("input[name=transportation-budget]").val();
        let liveLine = $("input[name=live-line-budget]").val();
        let rightOfWay = $("input[name=right-of-way-budget]").val();
        let conciliationShipment = {
            design: design,
            building: building,
            transportation:transportation,
            liveLine:liveLine,
            rightOfWay:rightOfWay,
        };

        let dataResult = Object.assign(data, conciliationShipment);

        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveConciliationShipment',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                _this.loadView();
            }
        });
    }

    saveCreReturnOrder(statusId,statusKeyword)
    {
        let _this = this;
        let dataResult = this.prepareDataToSave(statusId, statusKeyword);

        $.ajax({
            url : base_url + 'panel/AjaxProjectStatus/saveCreReturnOrder',
            dataType  :"json",
            type : "POST",
            data : dataResult,
            success:function(){
                _this.loadView();
            }
        });
    }

    prepareDataToSave(statusId, statusKeyword)
    {
        let projectId = this.projectId;
        let select2Data = $('#ajax-get-responsible-list').select2("data");
        let responsibleList = [];
        $.each(select2Data, function(index, value){
            responsibleList.push(value.id);
        });
        let entryDate = $("input[name="+statusKeyword+"-entry-date]").val();
        let statusDetail = $("textarea[name="+statusKeyword+"-detail]").val();
        return {
            projectId: projectId,
            entryDate:entryDate,
            statusId: statusId,
            statusKeyword: statusKeyword,
            statusDetail: statusDetail,
            responsibleList:responsibleList,
            statusFilesIdsToSave:this._statusFilesIdsToSave
        };
    }

    processTree(tree, index, breadCrumb)
    {
        for(let i = 0; i<tree.length; i++)
        {
            let step = tree[i];
            if(step.name == breadCrumb[index] && !this.stopTreeLoop)
            {
                index++;
                if(step.next.length > 0)
                {
                    if(index == breadCrumb.length)
                    {
                        this.stopTreeLoop = true;
                    }
                    this.processTree(step.next, index, breadCrumb);
                    if(index == breadCrumb.length)
                    {
                        for(let j = 0; j < step.next.length; j++)
                        {
                            this.nextStep.push(step.next[j].name);
                        }
                    }
                }
            }
        }
    }

    loadEventHandler()
    {
        let _this = this;
        $(document).on("click", this.buttonAddStep, function(e){
            e.preventDefault();
            let $button = $(this);
            $('.popover').popover('destroy');
            _this.addStep($button);

        });

        $(document).on("click",".add-step-from-list", function(e){
           e.preventDefault();
           let stepId = $(this).data("step-id");
           let stepName = $(this).data("step-name");
           let keyword = $(this).data("keyword");
           let icon = $(this).data("icon");
           let step = {stepId: stepId, stepName: stepName, stepKeyword:keyword, stepIcon: icon, stepStatus:"active"};
           _this.addStepFromList(step);
        });

        $(document).on("click", this.buttonRemoveStep, function(e){
            e.preventDefault();
            let $button = $(this);
            _this.removeStep($button);
        });

        $(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) {
            e.preventDefault();
            let keyword = $(this).prop("id");
            _this.loadStatusForm(keyword,0);
        });

        $(document).on("click",".cancel-add-step",function(e){
           e.preventDefault();
            $('.popover').popover('destroy');
        });

        $(document).on("click",".load-status-form-new-info",function(e){
            e.preventDefault();
            let keyword = $(this).data("keyword");
            _this.loadStatusForm(keyword,1);
            // console.log(keyword);
        });

        $(document).on("click", this.buttonAdd, function(e){
           e.preventDefault();
           let $button = $(this);
           _this.saveStatus($button);
        });

        $(document).on("keyup","input[name=design-budget], input[name=building-budget], input[name=transportation-budget], input[name=live-line-budget], input[name=right-of-way-budget]", function(){
            StatusManagementHandler.updateTotalOnApprovedForm();
        });

        $(document).on("click",".extract-approved-budgets",function(){
            let formName = $(this).data('form-name');
            let saveInSystem = $(this).data('save-in-system');
            let form = $('form[name='+formName+']')[0];
            let data = new FormData(form);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: base_url + "panel/AjaxProjectStatus/readManpowerFile/"+saveInSystem,
                data: data,
                dataType:'json',
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                beforeSend:function(){
                    blockArea($(form));
                },
                success: function (response) {
                    $(form).unblock();
                    if(response.success == 1)
                    {
                        let projectBudgetId = $("input[name=project-budget-id]").val();
                        if(projectBudgetId != "")
                        {
                            _this.projectLog();
                            _this.loadStatusForm('approved', 0);
                        }
                        else
                        {
                            let file = response.data.file;
                            let budget = response.data.budget;
                            let extraInfo = response.data.extraInfo;
                            let $form = $("#status-form-content");
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
                    else
                    {
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

        $(document).on("click",".extract-building-budgets",function(){
            let formName = $(this).data('form-name');
            let saveInSystem = $(this).data('save-in-system');
            let form = $('form[name='+formName+']')[0];
            let data = new FormData(form);
            let $form = $("#status-form-content");
            let manpowerFileId = $form.find("input[name=manpower-file-id]").val();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: base_url + "panel/AjaxProjectStatus/readPointToPointFile/"+saveInSystem+"/"+manpowerFileId,
                data: data,
                dataType:'json',
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                beforeSend:function(){
                    blockArea($(form));
                },
                success: function (response) {
                    $(form).unblock();
                    if(response.success == 1)
                    {
                        let projectBudgetId = $("input[name=project-budget-id]").val();
                        let manpowerFileId = $("input[name=manpower-file-id]").val();
                        if(projectBudgetId != "" && saveInSystem == 1)
                        {
                            _this.projectLog();
                            _this.loadStatusForm('approved', 0);
                        }
                        else
                        {
                            let file = response.data.file;
                            let budget = response.data.budget;
                            let $form = $("#status-form-content");
                            $form.find("input[name=point-to-point-file-id]").val(file.id);
                            $form.find("input[name=building-budget]").val(budget.building);
                            StatusManagementHandler.updateTotalOnApprovedForm();
                            console.log(response.data);
                        }
                    }
                    else
                    {
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
    }
}