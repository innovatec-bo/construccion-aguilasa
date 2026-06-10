"use strict";
var WarehouseHandler = /** @class */ (function () {
    function WarehouseHandler() {
        this._projectMaterialSummary = [];
        WarehouseHandler.columnsDefinition['material_code'] = 1;
        WarehouseHandler.columnsDefinition['material_description'] = 2;
        WarehouseHandler.columnsDefinition['quantity_assigned_materials'] = 3;
        WarehouseHandler.columnsDefinition['quantity_picked_up_from_cre'] = 4;
        WarehouseHandler.columnsDefinition['pending_material_in_cre'] = 5;
        WarehouseHandler.columnsDefinition['quantity_materials_delivered_to_builder'] = 6;
        WarehouseHandler.columnsDefinition['request_materials_quantity'] = 7;
        WarehouseHandler.columnsDefinition['quantity_in_warehouse'] = 8;
        WarehouseHandler.columnsDefinition['all_quantity_in_warehouse'] = 9;
        WarehouseHandler.columnsDefinition['movement'] = 10;
        WarehouseHandler.columnsDefinition['tension'] = 11;
        WarehouseHandler.columnsDefinition['status'] = 12;
        WarehouseHandler.columnsDefinition['delivered_to_builder_detail'] = 13;
    }
    WarehouseHandler.prototype._addRow = function (rowData) {
        //Search summary from next array by code added to table
        var rowDataSummary = this._projectMaterialSummary.filter(function (p) { return p.material_code == rowData.material_code; });
        var htmlSource = $('#table-row').html();
        var template = Handlebars.compile(htmlSource);
        var data = { data: rowData, rowId: Date.now() };
        if (rowDataSummary.length > 0)
            data.data = rowDataSummary[0];
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
        //Get rows using the first column
        var rows = $("td:nth-child(1)").filter(function () {
            return $(this).text() == rowData.material_code;
        }).parent();
        WarehouseHandler._applyRowspan(rows, rowData, rowDataSummary);
        WarehouseHandler.columnsVisibility();
        WarehouseHandler._initInputMask();
    };
    WarehouseHandler._initInputMask = function () {
        $(".input-masked").inputmask();
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
    /**
     * Add info to each cell(already in dom) and apply the proper rowspan
     * @param rows
     * @param rowData
     * @param rowDataSummary
     */
    WarehouseHandler._applyRowspan = function (rows, rowData, rowDataSummary) {
        //Add colspan
        var toApplyRowspan = ['material_code', 'material_description', 'quantity_assigned_materials', 'quantity_picked_up_from_cre', 'pending_material_in_cre', 'quantity_materials_delivered_to_builder', 'request_materials_quantity', 'quantity_in_warehouse', 'all_quantity_in_warehouse'];
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
            case 17:
            case 18:
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
                    this.getSummaryByReservationNumber(optionSelected, projectId);
        }
    };
    WarehouseHandler.prototype.getSummaryByReservationNumber = function (summaryType, projectId, reservationNumber) {
        if (reservationNumber === void 0) { reservationNumber = ""; }
        var _this = this;
        $.ajax({
            url: base_url + 'panel/AjaxMaterialSummary/getSummaryByReservationNumber/' + summaryType + '/' + projectId + '/' + reservationNumber,
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
            var optionSelected = parseInt($('select[name=summary-type] option:selected').val());
            //If the option selected is 'material_picked_up_from_cre' or 'request_loans_materials' and the "pending_materials_in_cre" is "0" then let's skip that row.
            if ((optionSelected == 3 || optionSelected == 15) && value.pending_material_in_cre == 0) {
                return true;
            }
            var data = { data: value, rowId: index + Date.now(), rowClass: "", summaryType: optionSelected };
            if (optionSelected == 14) {
                if (value.quantity_picked_up_from_cre > 0)
                    data.rowClass = "bg-danger text-white";
            }
            html += template(data);
        });
        var $tableBody = $('#table-body');
        WarehouseHandler.emptyTable($tableBody);
        $tableBody.append(html);
    };
    WarehouseHandler.emptyTable = function (tableBody) {
        tableBody.html('');
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
    /**
     * This method is used in warehouse.entry.js as parley validation
     */
    WarehouseHandler.validateQuantityToMove = function (element) {
        var summaryTypeKeyword = $('select[name=summary-type] option:selected').data('keyword');
        var inputValue = $(element).val().replace(',', '');
        var $tr = $(element).closest('tr');
        var pendingMaterialInCre = typeof $tr.data('pending-material-in-cre') == 'string' ? parseFloat($tr.data('pending-material-in-cre').replace(',', '')) : parseFloat($tr.data('pending-material-in-cre'));
        var quantitInWarehouse = typeof $tr.data('quantity-in-warehouse') == 'string' ? parseFloat($tr.data('quantity-in-warehouse').replace(',', '')) : parseFloat($tr.data('quantity-in-warehouse'));
        var quantityRequested = typeof $tr.find('.quantity') == 'string' ? parseFloat($tr.find('.quantity').data('quantity-requested').replace(',', '')) : parseFloat($tr.find('.quantity').data('quantity-requested'));
        var response;
        var message;
        switch (summaryTypeKeyword) {
            case 'materials_picked_up_from_cre':
                response = inputValue <= pendingMaterialInCre;
                message = 'No puede exceder la cantidad pendiente en CRE';
                break;
            case 'materials_delivered_to_builder':
                response = isNaN(quantityRequested) ? true : inputValue <= quantityRequested;
                message = 'No puede llevar mas que la cantidad solicitada.';
                break;
            case 'request_materials':
                response = inputValue <= quantitInWarehouse;
                console.log(inputValue, quantitInWarehouse, inputValue <= quantitInWarehouse);
                message = 'No puede solicitar mas materiales de los que tiene disponible el proyecto en almacen.';
                break;
            default:
                message = '';
                response = true;
        }
        window.Parsley.addMessage('es', 'validateQuantityToMove', message);
        // let materialCode = $(element.$element).closest('tr').data('material-code');//element
        // var requestedQuantity = 0;
        // $(".quantity-"+materialCode).each(function() {   
        // 	requestedQuantity += +this.value;
        // });
        return response;
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
                    var data = {
                        id: value.material_id,
                        text: "(" + value.material_code + ") " + value.material_description,
                        material_code: value.material_code,
                        request_materials_quantity: value.request_materials_quantity,
                        quantity_in_warehouse: value.quantity_in_warehouse,
                        all_quantity_in_warehouse: value.all_quantity_in_warehouse
                    };
                    $select2Materials.select2("trigger", "select", { data: data });
                    $select2Materials.trigger('change');
                    var rowData = $select2Materials.select2('data')[0];
                    _this._addRow(rowData);
                    //After add a new row, let's assign the default values
                    $select2Materials.val(null).trigger('change');
                    var $rowAdded = $('#table-body tr:last');
                    $rowAdded.find('.quantity').val(value.material_quantity);
                    $rowAdded.find('.quantity').data('quantity-requested', value.material_quantity);
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
                        var rowData = $('.select2-materials').select2('data')[0];
                        _this._addRow(rowData);
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
            var summaryType = parseInt($('select[name=summary-type] option:selected').val());
            if (projectId != "") {
                //If the reservation number is not
                if (!$("#reservation-number-selection").is(':visible')) {
                    _this.getSummaryByReservationNumber(summaryType, projectId);
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
                    WarehouseHandler.columnsVisibility();
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
        $(document).on('select2:opening', '.select2-labor-cost', function () {
            var project = $('select[name=project]').val();
            if (project == "") {
                toastr.error('Debe especificar un proyecto', '', { 'progressBar': true });
                return false;
            }
        });
        $(document).on('click', '.wh-clear-table', function () {
            var $tableBody = $('#table-body');
            WarehouseHandler.emptyTable($tableBody);
        });
        $(document).on('click', '.wh-set-cero-as-movement', function () {
            $("input.quantity").val("0.00");
        });
    };
    WarehouseHandler.columnsDefinition = [];
    return WarehouseHandler;
}());
