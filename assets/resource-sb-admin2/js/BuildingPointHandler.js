var BuildingPointHandler = /** @class */ (function () {
    function BuildingPointHandler(projectID) {
        this.projectID = projectID;
        this._projectId = projectID;
    }
    BuildingPointHandler.prototype.add = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxBuildingPoint/add/' + _this._projectId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                // _this._beforeSend(method);
            },
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this._masterTemplate = $("<div>" + response.data.template + "</div>");
                    _this._launchForm(response, 'Crear punto de construccion');
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
    BuildingPointHandler.prototype.edit = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxWorkPlan/edit/' + _this._buildingPointId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                // _this._beforeSend(method);
            },
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this._masterTemplate = $("<div>" + response.data.template + "</div>");
                    _this._launchForm(response, 'Editar plan de trabajo');
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                    $("#work-plan-index").DataTable().ajax.reload(null, false);
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
    BuildingPointHandler.prototype.delete = function () {
        var _this = this;
        swal.fire({
            title: "Eliminar Plan de trabajo?",
            html: "",
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            width: '50%'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: base_url + 'panel/AjaxWorkPlan/delete/' + _this._buildingPointId,
                    dataType: "json",
                    method: "post",
                    data: {},
                    beforeSend: function () {
                        // _this._beforeSend(method);
                    },
                    success: function (response) {
                        if (response.success === 1) {
                            toastr.success(response.message, '', { 'progressBar': true });
                        }
                        else {
                            toastr.error(response.message, '', { 'progressBar': true });
                        }
                    }
                });
            }
        });
    };
    BuildingPointHandler.prototype._launchForm = function (response, title) {
        var _this = this;
        var htmlSource = _this._masterTemplate.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var html = template({ buildingPoint: response.data.buildingPoint });
        swal.fire({
            title: title,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            customClass: "modal-building-point-form",
            width: '100%',
            preConfirm: function () {
                var $form = $("form[name=building-point-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    return false;
                }
            },
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=building-point-form]");
                var buildingPointId = parseInt($form.find("input[name=building-point-id]").val());
                if (isNaN(buildingPointId)) {
                    _this.add($form.serialize());
                }
                else {
                    _this.edit($form.serialize());
                }
            }
        });
    };
    BuildingPointHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on("click", ".add-building-point", function (e) {
            e.preventDefault();
            _this.add();
        });
        $(document).on("click", ".edit-work-plan", function (e) {
            e.preventDefault();
            var workPlanId = $(this).data('work-plan-id');
            _this._buildingPointId = parseInt(workPlanId);
            _this.edit();
        });
        $(document).on("click", ".delete-work-plan", function (e) {
            e.preventDefault();
            var workPlanId = $(this).data('work-plan-id');
            _this._buildingPointId = parseInt(workPlanId);
            _this.delete();
        });
    };
    return BuildingPointHandler;
}());
