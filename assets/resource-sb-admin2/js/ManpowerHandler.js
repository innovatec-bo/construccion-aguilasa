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
            url: base_url + 'panel/AjaxQuestion/add/' + _this._surveyId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                var message = "Opening form..";
                if (formData) {
                    message = "Processing..";
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
                    _this.launchForm(response, "New Question");
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
    ManpowerHandler.prototype.edit = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxQuestion/edit/' + _this._questionId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                var message = "Opening form..";
                if (formData) {
                    message = "Processing..";
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
        var htmlTemplate = response.template;
        var $template = $("<div>" + htmlTemplate + "</div>");
        var htmlSource = $template.find(response.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var data = { question: response.data.question };
        var html = template(data);
        var _this = this;
        swal({
            title: formTitle,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: language.btn_save,
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            customClass: "question-form",
            preConfirm: function () {
                var $form = $("form[name=question-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    swal.showValidationMessage('Corrija los errores e intente nuevamente');
                }
            },
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=question-form]");
                var questionId = parseInt($form.find("input[name=question-id]").val());
                if (isNaN(questionId)) {
                    _this.add($form.serialize());
                }
                else {
                    _this.edit($form.serialize());
                }
            }
        });
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
    ManpowerHandler.prototype.loadEventHandler = function () {
        var _this = this;
        $(document).on("click", ".add-manpower-progress", function (e) {
            e.preventDefault();
            console.log(_this._projectId);
        });
    };
    return ManpowerHandler;
}());
