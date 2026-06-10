"use strict";
var LaborCostLogHandler = /** @class */ (function () {
    function LaborCostLogHandler(projectID) {
        this.projectID = projectID;
        this._projectId = projectID;
    }
    LaborCostLogHandler.prototype.setStructureUsageValidator = function (structureUsageValidator) {
        this._structureUsageValidator = structureUsageValidator;
    };
    LaborCostLogHandler.prototype._edit = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxLaborCostLog/edit/' + _this._laborCostLogId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                var message = "Cargando formulario..";
                if (formData) {
                    message = "Guardando..";
                }
                swal({
                    html: "<h3>" + message + "</h3>",
                    allowOutsideClick: false,
                    onBeforeOpen: function () {
                        swal.showLoading();
                    }
                });
            },
            success: function (response) {
                swal.close();
                if (response.success === 1 && !formData) {
                    var title = "Editar registro de avance";
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
    };
    LaborCostLogHandler.prototype._delete = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxLaborCostLog/delete/' + _this._laborCostLogId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                var message = "....";
                if (formData) {
                    message = "Eliminando registro..";
                }
                swal({
                    html: "<h3>" + message + "</h3>",
                    allowOutsideClick: false,
                    onBeforeOpen: function () {
                        swal.showLoading();
                    }
                });
            },
            success: function (response) {
                swal.close();
                if (response.success === 1 && !formData) {
                    var title = "Eliminar registro de avance";
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
                    }).then(function (result) {
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
    };
    LaborCostLogHandler.prototype.launchForm = function (response, formTitle) {
        var builderList = [];
        var builder = {};
        var splitBuilderString = response.data.logMasterDetail.builderWithId;
        splitBuilderString = splitBuilderString.split(",");
        $.each(splitBuilderString, function (index, value) {
            var string = value;
            var result = string.split("-");
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
        var htmlTemplate = response.data.template;
        var $template = $("<div>" + htmlTemplate + "</div>");
        var htmlSource = $template.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var data = {
            data: response.data,
            buildersSelected: builderList
        };
        var html = template(data);
        var _this = this;
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
            preConfirm: function () {
                var $form = $("form[name=edit-labor-cost-log-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    return false;
                }
            },
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=edit-labor-cost-log-form]");
                var laborCostLogId = parseInt($form.find("input[name=labor-cost-log-id]").val());
                if (isNaN(laborCostLogId)) {
                    // _this.add($form.serialize());
                }
                else {
                    _this._edit($form.serialize());
                }
            }
        });
        var date = new Date();
        var datesToBlock = _this._datesToBlock(response.data.dateRangesToBlock);
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
    };
    LaborCostLogHandler.prototype._updateView = function (pointId) {
        if (pointId !== null) {
            var pointToPointHandler = new PointToPointHandler(this._projectId);
            pointToPointHandler.loadBuildingPoints();
            pointToPointHandler.loadManpowerLog();
        }
        else {
            var manpowerHandler = new ManpowerHandler(this._projectId);
            manpowerHandler.loadManpower();
            manpowerHandler.loadManpowerLog();
        }
    };
    LaborCostLogHandler.prototype._datesToBlock = function (list) {
        var dates = [];
        $.each(list, function (index, dateRange) {
            var startDate = moment(dateRange.from_bld, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');
            var endDate = moment(dateRange.to_bld, "YYYY-MM-DD hh:mm:ss").format('YYYY-MM-DD');
            var range = moment.range(startDate, endDate);
            var arrayMoment = Array.from(range.by('day'));
            $.each(arrayMoment, function (index, moment) {
                dates.push(moment.format('YYYY-MM-DD'));
            });
        });
        return dates;
    };
    LaborCostLogHandler.prototype.loadEventHandler = function () {
        var _this = this;
        this._structureUsageValidator.loadEventHandlers();
        $(document).on("click", ".delete-log", function (e) {
            e.preventDefault();
            var id = $(this).data("log-id");
            _this._laborCostLogId = parseInt(id);
            _this._delete();
        });
        $(document).on("click", ".edit-log", function (e) {
            e.preventDefault();
            var id = $(this).data("log-id");
            _this._laborCostLogId = parseInt(id);
            _this._edit();
        });
    };
    return LaborCostLogHandler;
}());
