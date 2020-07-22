var BuildingPointHandler = /** @class */ (function () {
    function BuildingPointHandler(projectID) {
        this.projectID = projectID;
        this._projectId = projectID;
        this._structuresInPoint = [];
    }
    BuildingPointHandler.prototype.setPointToPointHandler = function (pointToPointHandler) {
        this._pointToPointHandler = pointToPointHandler;
    };
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
                    _this._pointToPointHandler.loadBuildingPoints();
                    toastr.success(response.message, '', { 'progressBar': true });
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
    BuildingPointHandler.prototype.addStructureToPoint = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxBuildingPoint/addStructureToPoint/' + _this._buildingPointId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                // _this._beforeSend(method);
            },
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this._structuresInPoint = response.data.buildingPoint.structureList;
                    _this._masterTemplate = $("<div>" + response.data.template + "</div>");
                    _this._launchFormAddStructureToPoint(response, 'Agregar estructura al punto ' + response.data.buildingPoint.label);
                }
                else if (response.success === 1 && formData) {
                    _this._pointToPointHandler.loadBuildingPoints();
                    toastr.success(response.message, '', { 'progressBar': true });
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
    BuildingPointHandler.prototype._launchFormAddStructureToPoint = function (response, title) {
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
                var $form = $("form[name=building-point-structure-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    return false;
                }
            },
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=building-point-structure-form]");
                _this.addStructureToPoint($form.serialize());
                // let buildingPointId = parseInt($form.find("input[name=building-point-id]").val());
                // if(isNaN(buildingPointId))
                // {
                //     _this.add($form.serialize());
                // }
            }
        });
        startSelect2LaborCost('.select2-search-labor-cost');
    };
    BuildingPointHandler.prototype._addRow = function (data) {
        $(".table-error-message").addClass("hide");
        var $listContent = $(".building-point-structure-add-form-item-list");
        var htmlSource = this._masterTemplate.find('#building-point-structure-add-form-item').html();
        var template = Handlebars.compile(htmlSource);
        var html = template(data);
        var structureAlreadyInList = this._structureAlreadyInList(data);
        if (structureAlreadyInList.alreadyInList) {
            toastr.error(structureAlreadyInList.message, '', { 'progressBar': true });
        }
        else {
            $listContent.append(html);
            $(".input-masked").inputmask('decimal', { min: 1, max: 999999, groupSeparator: ',', autoGroup: true });
            $(".input-masked-price").inputmask('decimal', { min: 0, max: 999999, groupSeparator: ',', autoGroup: true });
        }
    };
    /**
     * Eval if the structure is already in list
     * @param data
     * @private
     */
    BuildingPointHandler.prototype._structureAlreadyInList = function (data) {
        var response = { alreadyInList: false, message: "" };
        $.each($('.building-point-structure-add-form-item-list tr'), function (index, value) {
            var laborCostInList = $(value).data('labor-cost-id');
            if (laborCostInList == parseInt(data.labor_cost_id)) {
                response.alreadyInList = true;
                response.message = "Ya escogi&oacute; la estructura " + data.text + ".";
                return false;
            }
        });
        $.each(this._structuresInPoint, function (index, value) {
            if (value.laborCostId == parseInt(data.labor_cost_id)) {
                response.alreadyInList = true;
                response.message = "La estructura " + data.text + " ya esta incluida en el punto " + value.label + ".";
            }
        });
        return response;
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
                // else
                // {
                // 	_this.edit($form.serialize());
                // }
            }
        });
    };
    BuildingPointHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on("click", ".add-building-point", function (e) {
            e.preventDefault();
            _this.add();
        });
        $(document).on('click', '.add-structure-to-point', function (e) {
            e.preventDefault();
            _this._buildingPointId = parseInt($(this).data('point-id'));
            _this.addStructureToPoint();
        });
        $(document).on("select2:select", '.select2-search-labor-cost', function (e) {
            console.log(e);
            var data = e.params.data;
            _this._addRow(data);
        });
        $(document).on("click", ".remove-structure-from-building-point-form-add", function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            $tr.remove();
        });
    };
    return BuildingPointHandler;
}());
