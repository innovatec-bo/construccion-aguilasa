var ManpowerHandler = (function () {
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
                swal({
                    html: "<h3>" + message + "</h3>",
                    allowOutsideClick: false,
                    onBeforeOpen: function () {
                        swal.showLoading();
                    }
                });
            },
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this.launchForm(response, "Registrar avance");
                }
                else if (response.success === 1 && formData) {
                    Swal({ title: '', html: response.message, type: "success" });
                    _this.loadQuestions();
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
        var data = { structureList: structureList };
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
                // let $form = $("form[name=question-form]");
                // if(!$form.parsley().isValid())
                // {
                //     $form.parsley().validate();
                //     Swal.showValidationMessage('Corrija los errores e intente nuevamente');
                // }
            },
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=manpower-progress-form]");
                _this.add($form.serialize());
            }
        });
        var date = new Date();
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            defaultDate: date,
            format: 'DD-MM-YYYY'
        });
        this._startSelect2();
        $(".input-masked").inputmask('decimal', { min: 1, max: 999999, groupSeparator: ',', autoGroup: true });
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
    ManpowerHandler.prototype._addRow = function () {
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
            width: '100%',
            // escapeMarkup: function (markup) { return markup; },
            templateResult: function (state) {
                if (!state.id) {
                    return state.text;
                }
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
        });
    };
    ManpowerHandler.prototype._startSelect2Multiple = function (selector) {
        var _this = this;
        selector = selector || '.select2-builders';
        $(selector).select2({
            containerCssClass: "select-xs",
            width: '100%',
            // escapeMarkup: function (markup) { return markup; },
            templateResult: function (state) {
                if (!state.id) {
                    return state.text;
                }
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
        });
    };
    ManpowerHandler.prototype._formatState = function (state) {
        if (!state.id) {
            return state.text;
        }
        var $template = $("<div>" + this._loadViewTemplate + "</div>");
        var htmlSource = $template.find('#ht-select2-template-result').html();
        var template = Handlebars.compile(htmlSource);
        var html = template({});
        var $state = $(html);
        return $state;
    };
    ManpowerHandler.prototype.loadEventHandler = function () {
        var _this = this;
        $(document).on("click", ".add-manpower-progress", function (e) {
            e.preventDefault();
            _this.add();
            console.log(_this._projectId);
        });
        $(document).on('click', '.add-row', function (e) {
            e.preventDefault();
            _this._addRow();
        });
        $(document).on('select2:select', '.select2-structure-code', function (e) {
            var $optionElement = $(e.params.data.element);
            var structureCode = e.params.data.text;
            var unitOfMeasurement = $optionElement.data('unit-of-measurement');
            var activity = $optionElement.data('activity');
            var execution = $optionElement.data('execution');
            var description = $optionElement.data('description');
            var quantity = $optionElement.data('quantity');
            $optionElement.closest('tr').find('.activity').text(activity);
            $optionElement.closest('tr').find('.execution').text(execution);
            $optionElement.closest('tr').find('.description').text(description);
            $optionElement.closest('tr').find('.unit-of-measurement').text(unitOfMeasurement);
            $optionElement.closest('tr').find('.quantity').text(quantity);
            console.log(structureCode, unitOfMeasurement, activity, execution, description);
        });
    };
    return ManpowerHandler;
}());
