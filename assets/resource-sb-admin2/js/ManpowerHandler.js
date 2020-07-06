var ManpowerHandler = /** @class */ (function () {
    function ManpowerHandler(projectID) {
        this.projectID = projectID;
        this._projectId = projectID;
        this.viewData = {};
    }
    ManpowerHandler.prototype.add = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxProject/addManpowerProgress/' + _this._projectId,
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
                if (response.success === 1 && !formData) {
                    _this.launchForm(response, "Registrar avance");
                }
                else if (response.success === 1 && formData) {
                    Swal({ title: '', html: response.message, type: "success" });
                    _this.loadManpower();
                    _this.loadManpowerLog();
                }
                else {
                    Swal({ title: '', html: response.message, type: "error" });
                }
            }
        });
    };
    ManpowerHandler.prototype.edit = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxProject/edit/' + _this._questionId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                var message = "Opening form..";
                if (formData) {
                    message = "Processing..";
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
                if (response.success === 1 && !formData) {
                    _this.launchForm(response, "Edit Question");
                }
                else if (response.success === 1 && formData) {
                    swal({ title: '', html: response.message, type: "success" });
                    _this.loadQuestions();
                }
                else {
                    swal({ title: '', html: response.message, type: "error" });
                }
            }
        });
    };
    ManpowerHandler.prototype.launchForm = function (response, formTitle) {
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
        var data = { structureList: structureList, builders: response.data.builders };
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
                var $form = $("form[name=manpower-progress-form]");
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
                var $form = $("form[name=manpower-progress-form]");
                _this.add($form.serialize());
            }
        });
        var date = new Date();
        var datesToBlock = _this._datesToBlock(response.data.dateRangesToBlock);
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            format: 'DD-MM-YYYY',
            useCurrent: false,
            disabledDates: datesToBlock
        });
        $(".select2-builders").select2({ dropdownCssClass: "dd-select2-builders" });
        this._startSelect2();
        $(".input-masked").inputmask('decimal', { min: 1, max: 999999, groupSeparator: ',', autoGroup: true });
        $(".input-masked-price").inputmask('decimal', { min: 0, max: 999999, groupSeparator: ',', autoGroup: true });
    };
    ManpowerHandler.prototype.loadManpower = function () {
        var _this = this;
        $.ajax({
            url: base_url + 'panel/AjaxProject/getManpower/' + _this._projectId,
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
                var html = template({ laborCostMasterDetail: response.data.laborCostMasterDetail });
                $("#manpower-table").html(html);
            }
        });
    };
    ManpowerHandler.prototype.loadBuildingPoints = function () {
        var _this = this;
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
                $("#building-points").html(html);
            }
        });
    };
    ManpowerHandler.prototype._addRow = function () {
        $(".table-error-message").addClass("hide");
        var $listContent = $("#structure-item-list-content");
        var $template = $("<div>" + this._loadViewTemplate + "</div>");
        var htmlSource = $template.find('#ht-structure-item').html();
        var template = Handlebars.compile(htmlSource);
        var index = $listContent.children().length + 1;
        var data = {
            index: index,
            laborCostList: this._laborCostMasterDetail
        };
        var html = template(data);
        $listContent.append(html);
        // evaluateVisibilityBtnRemove();
        var selectorSelect2 = "[data-row-index='" + index + "'] select";
        this._startSelect2(selectorSelect2);
        $(".input-masked").inputmask('decimal', { min: 1, max: 999999, groupSeparator: ',', autoGroup: true });
    };
    ManpowerHandler.prototype._removeRow = function () {
    };
    ManpowerHandler.prototype._startSelect2 = function (selector) {
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
    ManpowerHandler.prototype.loadManpowerLog = function () {
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
                var builderList = [];
                var builder = {};
                $.each(response.data.log, function (index, string) {
                    var splitBuilderString = string.builderWithId;
                    splitBuilderString = splitBuilderString.split(",");
                    $.each(splitBuilderString, function (index, value) {
                        var string = value;
                        var result = string.split("-");
                        builder = { "id": result[0].trim(), "fullName": result[1].trim() };
                        builderList[result[0]] = builder;
                        builder = {};
                    });
                });
                // builderList = _this.arrayValues(builderList);
                // let tag : string = "";
                // $.each(builderList, function(index, value){
                //     if(value !== undefined)
                //         tag += "<a href='"+base_url+"Home/testProductivityReport/12/03/2020'>"+value.fullName+"</a> ";
                // });
                // $("#builder-list").html(tag);
            }
        });
    };
    ManpowerHandler.prototype.arrayValues = function (arrayObj) {
        var tempObj = {};
        Object.keys(arrayObj).forEach(function (prop) {
            if (arrayObj[prop]) {
                tempObj[prop] = arrayObj[prop];
            }
        });
        return tempObj;
    };
    ManpowerHandler.prototype._addBuildingStructure = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxLaborCost/add/' + _this._projectId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                // let message = "Cargando formulario..";
                // if(formData)
                // {
                //     message = "Procesando.."
                // }
                // Swal({
                //     html: "<h3>"+message+"</h3>",
                //     allowOutsideClick:false,
                //     onBeforeOpen: () => {
                //         Swal.showLoading();
                //     }
                // });
            },
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this.launchFormBuildingStructureForm(response, "Agregar Estructura");
                }
                else if (response.success === 1 && formData) {
                    // let laborCost = response.data.laborCost;
                    // let structure = response.data.structure;
                    // let data = {
                    //     id: laborCost.id_lac,
                    //     text: structure.structure_code_bus
                    // };
                    //
                    // let newOption = new Option(data.text, data.id, false, true);
                    // $(newOption).attr("data-activity",laborCost.activity_lac);
                    // $(newOption).attr("data-execution",laborCost.execution_lac);
                    // $(newOption).attr("data-description",structure.description_bus);
                    // $(newOption).attr("data-unit-of-measurement",structure.unit_of_measurement_bus);
                    // $(newOption).attr("data-quantity",laborCost.quantity_lac);
                    // $('.select2-structure-code').append(newOption).trigger('select2:select');
                    console.log(response);
                }
            }
        });
    };
    ManpowerHandler.prototype.launchFormBuildingStructureForm = function (response, formTitle) {
        this._loadViewTemplate = response.data.template;
        this._laborCostMasterDetail = response.data.laborCostMasterDetail;
        var $template = $("<div>" + this._loadViewTemplate + "</div>");
        var htmlSource = $template.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var data = { project: response.data.project };
        var html = template(data);
        var _this = this;
        bootbox.confirm({
            title: formTitle,
            message: html,
            buttons: {
                confirm: {
                    label: 'Guardar',
                    className: 'btn btn-primary'
                },
                cancel: {
                    label: 'Cancelar',
                    className: 'btn btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    var $formExisting = $("form[name=add-existing-structure]");
                    var $formNew = $("form[name=add-new-structure]");
                    var formSerialized = "";
                    if ($formExisting.is(":visible")) {
                        formSerialized = $formExisting.serialize();
                    }
                    else {
                        formSerialized = $formNew.serialize();
                    }
                    _this._addBuildingStructure(formSerialized);
                }
            }
        });
        startSelect2LaborCost();
        var $inputMasked = $(".input-masked");
        if ($inputMasked.length > 0) {
            $inputMasked.inputmask();
        }
    };
    ManpowerHandler.prototype._datesToBlock = function (list) {
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
    ManpowerHandler.prototype.loadEventHandler = function () {
        var _this = this;
        $(document).on("click", ".add-manpower-progress", function (e) {
            e.preventDefault();
            _this.add();
        });
        $(document).on('click', '.add-row', function (e) {
            e.preventDefault();
            _this._addRow();
        });
        $(document).on('select2:select', '.select2-structure-code', function (e) {
            $(this).parsley().validate();
            $(".table-error-message").addClass("hide");
            var $optionElement = $(e.params.data.element);
            var unitOfMeasurement = $optionElement.data('unit-of-measurement');
            var activity = $optionElement.data('activity');
            var execution = $optionElement.data('execution');
            var description = $optionElement.data('description');
            var unitPrice = $optionElement.data('unit-price');
            var quantity = $optionElement.data('quantity');
            $optionElement.closest('tr').find('.activity').text(activity);
            $optionElement.closest('tr').find('.execution').text(execution);
            $optionElement.closest('tr').find('.description').text(description);
            $optionElement.closest('tr').find('.unit-of-measurement').text(unitOfMeasurement);
            $optionElement.closest('tr').find('.unit-price').val(unitPrice);
            $optionElement.closest('tr').find('.quantity').text(quantity);
        });
        $(document).on("change", "select[name='builders[]']", function () {
            $("select[name='builders[]']").parsley().validate();
        });
        $(document).on("click", ".remove-row", function () {
            $(this).closest("tr").remove();
        });
        $(document).on("click", '[data-toggle="tooltip"]', function (e) {
            e.preventDefault();
        });
        $(document).on("click", ".add-building-structure", function (e) {
            e.preventDefault();
            _this._projectId = parseInt($(this).data('project-id'));
            _this._addBuildingStructure();
        });
        $(document).on("select2:select", 'select.select2-labor-cost', function (e) {
            console.log(e);
            var data = e.params.data;
            var $form = $("form[name=add-existing-structure]");
            $form.find("select[name=activity]").val(data.structure_activity);
            $form.find("select[name=execution]").val(data.structure_execution);
            // $form.find("input[name=quantity]").val(data.structure_quantity);
            $form.find("input[name=price]").val(data.structure_unit_price);
            console.log(data);
        });
    };
    return ManpowerHandler;
}());
