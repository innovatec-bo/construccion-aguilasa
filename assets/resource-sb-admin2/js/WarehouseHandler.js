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
        console.log(rowDataSummary);
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
                var projectId = $('select.select2.project option:selected').val();
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
                // console.log(response);
            }
        });
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
        var projectId = $('select.select2.project option:selected').val();
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
            var optionSelected = parseInt($(this).val());
            WarehouseHandler.builderSelectionVisibility();
            _this.reservationNumberVisibility();
            WarehouseHandler.columnsVisibility();
        });
        $('select.select2.project').on('change', function (e) {
            var projectId = $('select.select2.project option:selected').val();
            if (projectId != "") {
                //If the reservation number is not
                if (!$("#reservation-number-selection").is(':visible')) {
                    _this.getSummaryByReservationNumber(projectId);
                }
                $('select[name=reservation-number]').html('<option value="">Cargando..</option>');
                $('#table-body').html("");
                _this.getSummaryListByProjectId();
            }
            console.log('Triggered project select2 change');
        });
    };
    WarehouseHandler.columnsDefinition = [];
    return WarehouseHandler;
}());
