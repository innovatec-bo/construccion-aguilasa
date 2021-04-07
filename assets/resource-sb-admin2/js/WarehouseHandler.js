var WarehouseHandler = /** @class */ (function () {
    function WarehouseHandler() {
    }
    WarehouseHandler.prototype._addRow = function () {
        var rowData = $('.select2-materials').select2('data')[0];
        var htmlSource = $('#table-row').html();
        var template = Handlebars.compile(htmlSource);
        var data = { data: rowData };
        var html = template(data);
        $('#table-body').append(html);
    };
    WarehouseHandler.prototype._quitRow = function (row) {
        $(row).closest('tr').remove();
    };
    WarehouseHandler._builderSelectionVisibility = function (optionSelected) {
        var $component = $('#builder-selection');
        switch (optionSelected) {
            case 4:
            case 10:
            case 11:
                $component.slideDown();
                break;
            default:
                $component.slideUp();
        }
    };
    WarehouseHandler._reservationNumberVisibility = function (optionSelected) {
        var $component = $('#reservation-number-selection');
        switch (optionSelected) {
            case 8:
            case 3:
                $component.slideDown();
                break;
            default:
                $component.slideUp();
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
                var htmlSource = $('#table-row').html();
                var template = Handlebars.compile(htmlSource);
                var html = "";
                console.log(response);
                $.each(response, function (index, value) {
                    var data = { data: value };
                    html += template(data);
                });
                var data = _this._prepareDataTableRow(response);
                var table = $('#items-summary-list').DataTable();
                table.clear().draw();
                table.rows.add(data).draw();
                // $('#table-body').html(html);
                // if ($.fn.DataTable.isDataTable( '#items-summary-list' ) )
                // {
                // 	$('#items-summary-list').DataTable().clear().destroy();
                //
                // }
            }
        });
    };
    WarehouseHandler.prototype._prepareDataTableRow = function (list) {
        var newData = [];
        $.each(list, function (index, value) {
            var statusSelection = '<select class="form-control input-sm" name="summary[' + value.material_code + '][status]"><option value="1">NVO</option></select>';
            var row = [
                value.material_code,
                value.material_description,
                value.quantity_assigned,
                value.quantity_picked_up_from_cre,
                value.pending_material_in_cre,
                value.quantity_in_warehouse,
                '<input type="text" name="summary[' + value.material_code + '][quantity]" value="0" size="7"><input type="hidden" name="summary[' + value.material_code + '][id]" value="' + value.material_id + '" size="7">',
                statusSelection
            ];
            newData.push(row);
        });
        return newData;
    };
    WarehouseHandler.columnsVisibility = function () {
        var table = $('#items-summary-list').DataTable();
        var columns = $('select[name=summary-type]').find(':selected').data('columns');
        columns = columns.split(',');
        table.columns().visible(false);
        table.columns(columns).visible(true);
    };
    WarehouseHandler._changeStatusOptionsToChoose = function () {
        var table = $('#items-summary-list').DataTable();
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            var options = '';
            var summaryType = $('select[name=summary-type] option:selected').val();
            switch (summaryType) {
                case '1':
                    options = '';
                    break;
                case '2':
                    options = '';
                    break;
                case '3':
                case '4':
                case '9':
                case '10':
                    options = '<select name="summary[' + data[0] + '][status]" class="form-control input-sm"><option value="1">NVO</option></select>';
                    break;
                case '8':
                case '12':
                    options = '<select name="summary[' + data[0] + '][status]" class="form-control input-sm"><option value="1">NVO</option><option value="2">MEO</option><option value="3">RBE</option></select>';
                    break;
                case '11':
                    options = '<select name="summary[' + data[0] + '][status]" class="form-control input-sm"><option value="2">MEO</option><option value="3">RBE</option></select>';
                    break;
            }
            data[7] = options;
            this.invalidate();
        });
    };
    WarehouseHandler._changeStatusOptionsToChoose2 = function () {
        var myTable = $('#items-summary-list').DataTable();
        // myTable.column('status:name').nodes().each(function(node){
        var index = 0;
        myTable.column(['material_code:name', 'status:name']).each(function (node) {
            var options = '';
            var summaryType = $('select[name=summary-type] option:selected').val();
            switch (summaryType) {
                case '1':
                    options = '';
                    break;
                case '2':
                    options = '';
                    break;
                case '3':
                case '4':
                case '9':
                case '10':
                    options = '<select name="options" class="form-control input-sm"><option value="1">NVO</option></select>';
                    break;
                case '8':
                case '12':
                    options = '<select name="options" class="form-control input-sm"><option value="1">NVO</option><option value="2">MEO</option><option value="3">RBE</option></select>';
                    break;
                case '11':
                    options = '<select name="options" class="form-control input-sm"><option value="2">MEO</option><option value="3">RBE</option></select>';
                    break;
            }
            console.log(node);
            // myTable.cell(node).data(options);
            index++;
        });
        console.log(index);
    };
    WarehouseHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.wh-add-row', function () {
            _this._addRow();
        });
        $(document).on('click', '.wh-quit-row', function () {
            _this._quitRow(this);
        });
        $('select[name=summary-type]').on('change', function (e) {
            var optionSelected = parseInt($(this).val());
            WarehouseHandler._builderSelectionVisibility(optionSelected);
            WarehouseHandler._reservationNumberVisibility(optionSelected);
            WarehouseHandler.columnsVisibility();
            WarehouseHandler._changeStatusOptionsToChoose();
        });
        $('form[name=materials-summary]').on('submit', function (e) {
            $("#items-summary-list").DataTable().search("").draw();
        });
    };
    return WarehouseHandler;
}());
