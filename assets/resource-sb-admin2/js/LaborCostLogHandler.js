"use strict";
class LaborCostLogHandler {
    constructor(projectID) {
        this.projectID = projectID;
        this._projectId = projectID;
    }
    setStructureUsageValidator(structureUsageValidator) {
        this._structureUsageValidator = structureUsageValidator;
    }
    _edit(formData) {
        let _this = this;
        let method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxLaborCostLog/edit/' + _this._laborCostLogId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                let message = "Cargando formulario..";
                if (formData) {
                    message = "Guardando..";
                }
                swal({
                    html: "<h3>" + message + "</h3>",
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading();
                    }
                });
            },
            success: function (response) {
                swal.close();
                if (response.success === 1 && !formData) {
                    let title = "Editar registro de avance";
                    if (response.data.logMasterDetail.pointId !== null)
                        title = title + " en el Punto " + response.data.logMasterDetail.pointLabel;
                    _this.launchForm(response, title);
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                    _this._updateView(response.data.pointId);
                }
                else {
                    swal({ title: '', html: response.message, type: "error" });
                }
            }
        });
    }
    _delete(formData) {
        let _this = this;
        let method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxLaborCostLog/delete/' + _this._laborCostLogId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                let message = "....";
                if (formData) {
                    message = "Eliminando registro..";
                }
                swal({
                    html: "<h3>" + message + "</h3>",
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        swal.showLoading();
                    }
                });
            },
            success: function (response) {
                swal.close();
                if (response.success === 1 && !formData) {
                    let title = "Eliminar registro de avance";
                    if (response.data.logMasterDetail.pointId !== null)
                        title = title + " en el Punto " + response.data.logMasterDetail.pointLabel;
                    title = title + "?";
                    swal({
                        title: title,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#E41C5E',
                        cancelButtonColor: '#DDDDDD',
                        confirmButtonText: 'Eliminar registro',
                        cancelButtonText: 'Cancelar',
                        allowOutsideClick: false,
                        customClass: "modal-manpower-form"
                    }).then((result) => {
                        if (result.value) {
                            _this._delete({ data: "xyz" });
                        }
                    });
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                    _this._updateView(response.data.pointId);
                }
                else {
                    swal({ title: '', html: response.message, type: "error" });
                }
            }
        });
    }
    launchForm(response, formTitle) {
        let builderList = [];
        let builder = {};
        let splitBuilderString = response.data.logMasterDetail.builderWithId;
        splitBuilderString = splitBuilderString.split(",");
        $.each(splitBuilderString, function (index, value) {
            let string = value;
            let result = string.split("-");
            builder = { "id": result[0].trim(), "fullName": result[1].trim() };
            builderList.push(builder);
            builder = {};
        });
        response.data.builders = response.data.builders.filter(function (obj) {
            return !builderList.some(function (obj2) {
                return obj.id == obj2.id;
            });
        });
        response.data.logMasterDetail.manualEntryDate = moment(response.data.logMasterDetail.manualEntryDate).format('DD-MM-YYYY');
        let htmlTemplate = response.data.template;
        let $template = $("<div>" + htmlTemplate + "</div>");
        let htmlSource = $template.find(response.data.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let data = {
            data: response.data,
            buildersSelected: builderList
        };
        let html = template(data);
        let _this = this;
        swal({
            title: formTitle,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Modificar registro',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            customClass: "modal-manpower-form",
            width: '100%',
            preConfirm: () => {
                let $form = $("form[name=edit-labor-cost-log-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    return false;
                }
            },
        }).then((result) => {
            if (result.value) {
                let $form = $("form[name=edit-labor-cost-log-form]");
                let laborCostLogId = parseInt($form.find("input[name=labor-cost-log-id]").val());
                if (isNaN(laborCostLogId)) {
                    // _this.add($form.serialize());
                }
                else {
                    _this._edit($form.serialize());
                }
            }
        });
        let date = new Date();
        let datesToBlock = _this._datesToBlock(response.data.dateRangesToBlock);
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            // defaultDate: date,
            format: 'DD-MM-YYYY',
            locale: 'es',
            disabledDates: datesToBlock
        });
        this._structureUsageValidator.loadFieldEvents();
        $(".select2-builders").select2({ dropdownCssClass: "dd-select2-builders" });
        $(".input-masked").inputmask('decimal', { min: 0, max: 999999, groupSeparator: ',', autoGroup: true });
        $(".input-masked-price").inputmask('decimal', { min: 0, max: 999999, groupSeparator: ',', autoGroup: true });
    }
    _updateView(pointId) {
        if (pointId !== null) {
            let pointToPointHandler = new PointToPointHandler(this._projectId);
            pointToPointHandler.loadBuildingPoints();
            pointToPointHandler.loadManpowerLog();
        }
        else {
            let manpowerHandler = new ManpowerHandler(this._projectId);
            manpowerHandler.loadManpower();
            manpowerHandler.loadManpowerLog();
        }
    }
    _datesToBlock(list) {
        let dates = [];
        $.each(list, function (index, dateRange) {
            let startDate = moment(dateRange.from_bld, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');
            let endDate = moment(dateRange.to_bld, "YYYY-MM-DD hh:mm:ss").format('YYYY-MM-DD');
            let range = moment.range(startDate, endDate);
            let arrayMoment = Array.from(range.by('day'));
            $.each(arrayMoment, function (index, moment) {
                dates.push(moment.format('YYYY-MM-DD'));
            });
        });
        return dates;
    }
    loadEventHandler() {
        let _this = this;
        this._structureUsageValidator.loadEventHandlers();
        $(document).on("click", ".delete-log", function (e) {
            e.preventDefault();
            let id = $(this).data("log-id");
            _this._laborCostLogId = parseInt(id);
            _this._delete();
        });
        $(document).on("click", ".edit-log", function (e) {
            e.preventDefault();
            let id = $(this).data("log-id");
            _this._laborCostLogId = parseInt(id);
            _this._edit();
        });
    }
}
