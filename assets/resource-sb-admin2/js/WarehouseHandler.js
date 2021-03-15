var WarehouseHandler = /** @class */ (function () {
    function WarehouseHandler() {
    }
    WarehouseHandler.prototype._addRow = function () {
    };
    WarehouseHandler.prototype._deleteRow = function () {
    };
    WarehouseHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.wh-add-row');
    };
    return WarehouseHandler;
}());
