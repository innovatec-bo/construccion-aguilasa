var WarehouseHandler = /** @class */ (function () {
    function WarehouseHandler() {
        this._projectMaterialSummary = [];
        WarehouseHandler.columnsDefinition['material_code'] = 1;
        WarehouseHandler.columnsDefinition['material_description'] = 2;
        WarehouseHandler.columnsDefinition['quantity_assigned_materials'] = 3;
        WarehouseHandler.columnsDefinition['quantity_picked_up_from_cre'] = 4;
        WarehouseHandler.columnsDefinition['pending_material_in_cre'] = 5;
        WarehouseHandler.columnsDefinition['quantity_materials_delivered_to_builder'] = 6;
        WarehouseHandler.columnsDefinition['quantity_in_warehouse'] = 7;
        WarehouseHandler.columnsDefinition['movement'] = 8;
        WarehouseHandler.columnsDefinition['tension'] = 9;
        WarehouseHandler.columnsDefinition['status'] = 10;
    }
    WarehouseHandler.prototype._addRow = function () {
        var rowData = $('.select2-materials').select2('data')[0];
        var htmlSource = $('#table-row').html();
        var template = Handlebars.compile(htmlSource);
        var data = { data: rowData, rowId: Date.now() };
        var html = template(data);
        //Add new row: let's get the last row to append the new row after it
        var lastRow = $("td:nth-child(1)").filter(function () {
            return $(this).text() == rowData.material_code;
        }).last().parent();
        //If there is at least one row.
        if (lastRow.length > 0)
            lastRow.after(html);
        //If the tbody is empty.
        else
            $('#table-body').append(html);
        //Search summary from next array by code added to table
        var rowDataSummary = this._projectMaterialSummary.filter(function (p) { return p.material_code == rowData.material_code; });
        //Get rows using the first column
        var rows = $("td:nth-child(1)").filter(function () {
            return $(this).text() == rowData.material_code;
        }).parent();
        WarehouseHandler._applyRowspan(rows, rowData, rowDataSummary);
        WarehouseHandler.columnsVisibility();
    };
    WarehouseHandler.prototype._quitRow = function (btn) {
        var materialCode = $(btn).closest('tr').find("td:eq(0)").text();
        //Removing entire row
        $(btn).closest('tr').remove();
        //Get rows using the first cell from tr deleted
        var rows = $("td:nth-child(1)").filter(function () {
            return $(this).text() == materialCode;
        }).parent();
        WarehouseHandler._applyRowspan(rows);
        WarehouseHandler.columnsVisibility();
    };
    WarehouseHandler._applyRowspan = function (rows, rowData, rowDataSummary) {
        //Add colspan
        var toApplyRowspan = ['material_code', 'material_description', 'quantity_assigned_materials', 'quantity_picked_up_from_cre', 'pending_material_in_cre', 'quantity_materials_delivered_to_builder', 'quantity_in_warehouse'];
        var _loop_1 = function (columnKey) {
            var columnIndex = WarehouseHandler.columnsDefinition[columnKey];
            if (toApplyRowspan.indexOf(columnKey) >= 0) {
                $.each(rows.find("td:eq(" + (columnIndex - 1) + ")"), function (rowIndex, value) {
                    if (rowDataSummary && rowDataSummary.length > 0) {
                        var cellValue = rowDataSummary[0][columnKey];
                        $(value).text(cellValue);
                    }
                    else if (rowData) {
                        var cellValue = "--";
                        if (rowData.hasOwnProperty(columnKey)) {
                            cellValue = rowData[columnKey];
                        }
                        $(value).text(cellValue);
                    }
                    if (rowIndex == 0) {
                        $(value).attr('rowspan', rows.length);
                        $(value).removeClass('hide');
                    }
                    else
                        $(value).addClass('hide');
                });
            }
        };
        for (var columnKey in WarehouseHandler.columnsDefinition) {
            _loop_1(columnKey);
        }
    };
    WarehouseHandler.builderSelectionVisibility = function () {
        var optionSelected = parseInt($('select[name=summary-type] option:selected').val());
        var $component = $('#builder-selection');
        switch (optionSelected) {
            case 4:
            case 10:
            case 11:
            case 14:
            case 15:
                $component.slideDown();
                break;
            default:
                $component.slideUp();
        }
    };
    WarehouseHandler.prototype.reservationNumberVisibility = function () {
        var optionSelected = parseInt($('select[name=summary-type] option:selected').val());
        var $component = $('#reservation-number-selection');
        switch (optionSelected) {
            case 8:
            case 3:
                $component.slideDown();
                break;
            default:
                $component.slideUp();
                var projectId = $('select.project option:selected').val();
                if (projectId != "")
                    this.getSummaryByReservationNumber(projectId);
        }
    };
    WarehouseHandler.prototype.getSummaryByReservationNumber = function (projectId, reservationNumber) {
        if (reservationNumber === void 0) { reservationNumber = ""; }
        var _this = this;
        $.ajax({
            url: base_url + 'panel/AjaxMaterialSummary/getSummaryByReservationNumber/' + projectId + '/' + reservationNumber,
            dataType: "json",
            type: "GET",
            success: function (response) {
                _this._projectMaterialSummary = response;
            }
        });
    };
    WarehouseHandler.prototype.fillTable = function () {
        var htmlSource = $('#table-row').html();
        var template = Handlebars.compile(htmlSource);
        var html = "";
        $.each(this._projectMaterialSummary, function (index, value) {
            var data = { data: value, rowId: index + Date.now() };
            html += template(data);
        });
        var $tableBody = $('#table-body');
        $tableBody.html('');
        $tableBody.append(html);
    };
    WarehouseHandler.columnsVisibility = function () {
        var visibleColumns = $('select[name=summary-type]').find(':selected').data('columns');
        visibleColumns = visibleColumns.split(',');
        for (var key in WarehouseHandler.columnsDefinition) {
            var value = WarehouseHandler.columnsDefinition[key];
            var $currentColumn = $('td:nth-child(' + value + '),th:nth-child(' + value + ')');
            $currentColumn.hide();
            if (visibleColumns.indexOf(key) >= 0) {
                $currentColumn.show();
            }
        }
    };
    WarehouseHandler.prototype.getSummaryListByProjectId = function () {
        var projectId = $('select.project option:selected').val();
        $.ajax({
            url: base_url + 'panel/AjaxMaterialSummary/getSummaryListByProjectId/' + projectId,
            dataType: "json",
            type: "GET",
            success: function (response) {
                var htmlSource = $('#reservation-number-options').html();
                var template = Handlebars.compile(htmlSource);
                var data = { options: response };
                var html = template(data);
                $('select[name=reservation-number]').html(html);
            }
        });
    };
    WarehouseHandler.prototype.loadRequestedData = function () {
        var _this = this;
        if (materialSummary.summary_id !== undefined) {
            var $newOption = $("<option selected='selected'></option>").val(materialSummary.project_id).text(materialSummary.project_code);
            $("select[name=project]").append($newOption).trigger('change');
            $("select[name=summary-type]").val(summaryTypeId).trigger('change');
            $("select[name=fiscal]").val(materialSummary.fiscal_id);
            $("select[name=builder]").val(materialSummary.builder_id);
            setTimeout(function () {
                $.each(materialList, function (index, value) {
                    var $select2Materials = $(".select2-materials");
                    var data = { id: value.material_id, text: "(" + value.material_code + ") " + value.material_description, material_code: value.material_code };
                    $select2Materials.select2("trigger", "select", { data: data });
                    $select2Materials.trigger('change');
                    _this._addRow();
                    //Luego de agregar un row se debe asignar los valores por defecto
                    //After add a new row, let's assign the default values
                    $select2Materials.val(null).trigger('change');
                    var $rowAdded = $('#table-body tr:last');
                    $rowAdded.find('.quantity').val(value.material_quantity);
                    $rowAdded.find('.tension').val(value.material_tension_id);
                    $rowAdded.find('.status').val(value.material_status_id);
                    $rowAdded.find('.material').val(value.material_id);
                });
            }, 2000);
        }
    };
    WarehouseHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.wh-add-row', function () {
            var reservationNumberVisible = $("#reservation-number-selection").is(':visible');
            var reservationNumber = $('select[name=reservation-number]').val();
            var project = $('select[name=project]').val();
            var material = $('select[name=materials]').val();
            if (project == "") {
                toastr.error('Debe especificar un proyecto', '', { 'progressBar': true });
            }
            else {
                if (reservationNumberVisible && reservationNumber == "") {
                    toastr.error('Seleccione un Nro. de reserva', '', { 'progressBar': true });
                }
                else {
                    if (material == "") {
                        toastr.error('Seleccione un material', '', { 'progressBar': true });
                    }
                    else {
                        _this._addRow();
                    }
                }
            }
        });
        $(document).on('click', '.wh-quit-row', function () {
            _this._quitRow(this);
        });
        $('select[name=summary-type]').on('change', function (e) {
            WarehouseHandler.builderSelectionVisibility();
            _this.reservationNumberVisibility();
            WarehouseHandler.columnsVisibility();
        });
        $('select.project').on('select2:clear', function (e) {
            $('select[name=reservation-number]').html('<option value="">--Elija un Nro. de reserva--</option>');
            $('#table-body').html("");
            $('.select2-materials').val(null).trigger('change');
        });
        $('select.project').on('change', function (e) {
            var projectId = $('select.project option:selected').val();
            if (projectId != "") {
                //If the reservation number is not
                if (!$("#reservation-number-selection").is(':visible')) {
                    _this.getSummaryByReservationNumber(projectId);
                }
                $('select[name=reservation-number]').html('<option value="">Cargando..</option>');
                $('#table-body').html("");
                _this.getSummaryListByProjectId();
            }
            $('.select2-materials').val(null).trigger('change');
        });
        $(document).on('click', '.wh-show-all-in-table', function () {
            var reservationNumberVisible = $("#reservation-number-selection").is(':visible');
            var reservationNumber = $('select[name=reservation-number]').val();
            var project = $('select[name=project]').val();
            if (project == "") {
                toastr.error('Debe especificar un proyecto', '', { 'progressBar': true });
            }
            else {
                if (reservationNumberVisible && reservationNumber == "") {
                    toastr.error('Seleccione un Nro. de reserva', '', { 'progressBar': true });
                }
                else {
                    _this.fillTable();
                }
            }
        });
        $(document).on('select2:opening', '.select2-materials', function () {
            var reservationNumberVisible = $("#reservation-number-selection").is(':visible');
            var reservationNumber = $('select[name=reservation-number]').val();
            var project = $('select[name=project]').val();
            if (project == "") {
                toastr.error('Debe especificar un proyecto', '', { 'progressBar': true });
                return false;
            }
            else {
                if (reservationNumberVisible && reservationNumber == "") {
                    toastr.error('Seleccione un Nro. de reserva', '', { 'progressBar': true });
                    return false;
                }
            }
        });
    };
    WarehouseHandler.columnsDefinition = [];
    return WarehouseHandler;
}());
