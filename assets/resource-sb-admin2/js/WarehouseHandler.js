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
            case 5:
            case 6:
            case 7:
                $component.slideDown();
                break;
            default:
                $component.slideUp();
        }
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
        });
    };
    return WarehouseHandler;
}());
