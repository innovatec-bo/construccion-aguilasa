"use strict";
var PointToPointHandler = /** @class */ (function () {
    function PointToPointHandler(projectID) {
        this.projectID = projectID;
        this._projectId = projectID;
        this.viewData = {};
    }
    PointToPointHandler.prototype.setStructureUsageValidator = function (structureUsageValidator) {
        this._structureUsageValidator = structureUsageValidator;
    };
    PointToPointHandler.prototype.add = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxProject/addPointToPointProgress/' + _this._projectId + "/" + _this._pointId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                var message = "Cargando formulario..";
                if (formData) {
                    message = "Procesando..";
                }
                Swal({
                    html: "<h3>" + message + "</h3>",
                    allowOutsideClick: false,
                    onBeforeOpen: function () {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.close();
                if (response.success === 1 && !formData) {
                    _this.launchForm(response, "Registrar avance en punto " + response.data.point.point_label);
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                    _this.loadManpowerLog();
                    _this.loadBuildingPoints();
                }
                else {
                    Swal({ title: '', html: response.message, type: "error" });
                }
            }
        });
    };
    PointToPointHandler.prototype._addMassiveProgress = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxProject/addMassivePointToPointProgress/' + _this._projectId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                var message = "Cargando formulario..";
                if (formData) {
                    message = "Procesando..";
                }
                Swal({
                    html: "<h3>" + message + "</h3>",
                    allowOutsideClick: false,
                    onBeforeOpen: function () {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.close();
                if (response.success === 1 && !formData) {
                    _this.launchFormMassiveProgress(response, "Completar puntos");
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                    _this.loadManpowerLog();
                    _this.loadBuildingPoints();
                }
                else {
                    Swal({ title: '', html: response.message, type: "error" });
                }
            }
        });
    };
    PointToPointHandler.prototype.launchForm = function (response, formTitle) {
        this._loadViewTemplate = response.data.template;
        this._laborCostMasterDetail = response.data.laborCostMasterDetail;
        var $template = $("<div>" + this._loadViewTemplate + "</div>");
        var structureItemList = $template.find("#ht-structure-item-list").html();
        Handlebars.registerPartial("ht-structure-item-list", structureItemList);
        var structureItem = $template.find("#ht-structure-item").html();
        Handlebars.registerPartial("ht-structure-item", structureItem);
        var htmlSource = $template.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var item = {
            index: 1,
            laborCostList: this._laborCostMasterDetail
        };
        var structureList = [item];
        var data = { point: response.data.point, builders: response.data.builders, response: response, productionLimit: response.data.productionLimit, project: response.data.project };
        var html = template(data);
        var _this = this;
        Swal({
            title: formTitle,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Guardar',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            customClass: "modal-manpower-form",
            width: '100%',
            preConfirm: function () {
                var $listContent = $("#structure-item-list-content");
                var $form = $("form[name=point-to-point-progress-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    return false;
                }
                else if ($listContent.children().length <= 0) {
                    $(".table-error-message").removeClass("hide");
                    return false;
                }
            },
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=point-to-point-progress-form]");
                _this.add($form.serialize());
            }
        });
        var date = new Date();
        var datesToBlock = _this._datesToBlock(response.data.dateRangesToBlock);
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            locale: 'es',
            format: 'DD-MM-YYYY',
            useCurrent: false,
            disabledDates: datesToBlock
        });
        this._structureUsageValidator.loadFieldEvents();
        $(".select2-builders").select2({ dropdownCssClass: "dd-select2-builders" });
        this._startSelect2();
        $(".input-masked").inputmask('decimal', { min: 1, max: 999999, groupSeparator: ',', autoGroup: true });
    };
    PointToPointHandler.prototype.launchFormMassiveProgress = function (response, formTitle) {
        this._loadViewTemplate = response.data.template;
        this._laborCostMasterDetail = response.data.laborCostMasterDetail;
        var $template = $("<div>" + this._loadViewTemplate + "</div>");
        var structureItemList = $template.find("#ht-structure-item-list").html();
        Handlebars.registerPartial("ht-structure-item-list", structureItemList);
        var structureItem = $template.find("#ht-structure-item").html();
        Handlebars.registerPartial("ht-structure-item", structureItem);
        var htmlSource = $template.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var item = {
            index: 1,
            laborCostList: this._laborCostMasterDetail
        };
        var structureList = [item];
        var data = { point: response.data.point, builders: response.data.builders, response: response };
        var html = template(data);
        var _this = this;
        Swal({
            title: formTitle,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Guardar',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            customClass: "modal-manpower-form",
            width: '100%',
            preConfirm: function () {
                var $form = $("form[name=point-to-point-massive-progress-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    return false;
                }
            },
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=point-to-point-massive-progress-form]");
                _this._addMassiveProgress($form.serialize());
            }
        });
        var date = new Date();
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            defaultDate: date,
            format: 'DD-MM-YYYY'
        });
        $(".select2-builders").select2({ dropdownCssClass: "dd-select2-builders" });
        this._startSelect2();
        $(".input-masked").inputmask('decimal', { min: 1, max: 999999, groupSeparator: ',', autoGroup: true });
        $(".input-masked-price").inputmask('decimal', { min: 0, max: 999999, groupSeparator: ',', autoGroup: true });
        if ($('#select2-points').length > 0) {
            $('#select2-points').select2();
        }
    };
    PointToPointHandler.prototype.loadBuildingPoints = function () {
        var _this = this;
        var $buildingPointsContent = $("#building-points");
        blockArea($buildingPointsContent);
        $.ajax({
            url: base_url + 'panel/AjaxProject/getBuildingPoints/' + _this._projectId,
            dataType: "json",
            method: 'GET',
            beforeSend: function () {
                // swal({
                //     html: "<h3>Loading</h3>",
                //     allowOutsideClick:false,
                //     onBeforeOpen: () => {
                //         swal.showLoading();
                //     }
                // });
            },
            success: function (response) {
                // console.log(response);
                var $template = $("<div>" + response.data.template + "</div>");
                var htmlSource = $template.find(response.data.templateName).html();
                var template = Handlebars.compile(htmlSource);
                // let html = template({laborCostMasterDetail:response.data.laborCostMasterDetail});
                var html = template({ buildingPoints: response.data.buildingPoints });
                if (response.data.buildingPoints.length > 0)
                    $buildingPointsContent.html(html);
                else
                    $buildingPointsContent.html("<div class='col-md-9'><h1>No se encontraron puntos</h1></div>");
                if (response.data.buildingPoints.length <= 7) {
                    $('.add-massive-point-to-point-progress').removeClass('hide');
                }
            }
        });
    };
    PointToPointHandler.prototype._startSelect2 = function (selector) {
        var _this = this;
        selector = selector || '.select2-structure-code';
        $(selector).select2({
            containerCssClass: "select-xs",
            dropdownCssClass: "dd-select2-structure-code",
            width: '100%',
            // escapeMarkup: function (markup) { return markup; },
            templateResult: function (state) {
                var alreadySelected = [];
                $.each($(".select2-structure-code"), function (index, value) {
                    alreadySelected.push($(value).val());
                    // console.log($(value).val());
                });
                if (!state.id) {
                    return state.text;
                }
                else {
                    if (alreadySelected.indexOf(state.id) < 0) {
                        var $originalOption = $(state.element);
                        var data = {
                            structureCode: state.text,
                            activity: $originalOption.data('activity'),
                            execution: $originalOption.data('execution'),
                            quantity: $originalOption.data('quantity'),
                            unitOfMeasurement: $originalOption.data('unit-of-measurement'),
                            description: $originalOption.data('description')
                        };
                        var $template = $("<div>" + _this._loadViewTemplate + "</div>");
                        var htmlSource = $template.find('#ht-select2-template-result').html();
                        var template = Handlebars.compile(htmlSource);
                        var html = template(data);
                        var $state = $(html);
                        return $state;
                    }
                }
            },
            language: {
                noResults: function () {
                    return '<a href="#" class="btn btn-default btn-block add-building-structure" data-project-id="' + _this._projectId + '">Agregar estructura</a>';
                },
            },
            escapeMarkup: function (markup) {
                return markup;
            },
        });
    };
    PointToPointHandler.prototype.loadManpowerLog = function () {
        var _this = this;
        $.ajax({
            url: base_url + 'panel/AjaxProject/getManpowerLog/' + _this._projectId,
            dataType: "json",
            method: 'GET',
            beforeSend: function () {
                // swal({
                //     html: "<h3>Loading</h3>",
                //     allowOutsideClick:false,
                //     onBeforeOpen: () => {
                //         swal.showLoading();
                //     }
                // });
            },
            success: function (response) {
                var $template = $("<div>" + response.data.template + "</div>");
                var htmlSource = $template.find(response.data.templateName).html();
                var template = Handlebars.compile(htmlSource);
                var html = template({ log: response.data.log });
                $("#status-project-log-content").html(html);
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    };
    PointToPointHandler.prototype._datesToBlock = function (list) {
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
    PointToPointHandler.prototype.loadEventHandler = function () {
        var _this = this;
        this._structureUsageValidator.loadEventHandlers();
        $(document).on("click", ".add-point-to-point-progress", function (e) {
            e.preventDefault();
            _this._pointId = parseInt($(this).data("point-id"));
            _this.add();
        });
        $(document).on("click", ".add-massive-point-to-point-progress", function (e) {
            e.preventDefault();
            _this._pointId = parseInt($(this).data("point-id"));
            _this._addMassiveProgress();
        });
        $(document).on("change", "select[name='builders[]']", function () {
            $("select[name='builders[]']").parsley().validate();
        });
        $(document).on("click", '[data-toggle="tooltip"]', function (e) {
            e.preventDefault();
        });
    };
    return PointToPointHandler;
}());
