var StructureUsageValidator = /** @class */ (function () {
    function StructureUsageValidator(formName) {
        this.formName = formName;
        // this._tableSelector = tableSelector;
        this._formName = formName;
        this._manpowerHasPoint = false;
    }
    StructureUsageValidator.prototype.hasPoint = function () {
        this._manpowerHasPoint = true;
    };
    StructureUsageValidator.prototype.validateQuantityToUse = function () {
    };
    StructureUsageValidator.prototype._setBackgroundColor = function () {
    };
    StructureUsageValidator.prototype.loadFieldEvents = function () {
        $("form[name=" + this._formName + "]").parsley().on('field:validate', function (e) {
            if ($(e.element).hasClass('quantity-to-use')) {
                var currentValue = $(e.element).val() == "" ? "0" : $(e.element).val();
                currentValue = currentValue.replace(',', '');
                currentValue = parseFloat(currentValue);
                var $tr = $(e.element).closest('tr');
                var quantityToUse = $tr.attr('data-quantity-to-use');
                quantityToUse = quantityToUse.replace(',', '');
                quantityToUse = parseFloat(quantityToUse);
                var totalWorkedUp = $tr.attr('data-total-worked-up');
                totalWorkedUp = totalWorkedUp.replace(',', '');
                totalWorkedUp = parseFloat(totalWorkedUp);
                var maxQuantityToUse = (quantityToUse + (quantityToUse * 1)) - totalWorkedUp;
                maxQuantityToUse = maxQuantityToUse < 0 ? 0 : maxQuantityToUse;
                //success
                if (currentValue == 0 || (currentValue + totalWorkedUp) <= quantityToUse) {
                    $(e.element).closest('tr')
                        .css('background', '')
                        .css('color', '');
                    $(e.element).closest('tr').find('input').css('color', '');
                }
                //warning
                else if ((currentValue + totalWorkedUp) > quantityToUse && currentValue <= maxQuantityToUse) {
                    $(e.element).closest('tr')
                        .css('background', '#f0ad4e')
                        .css('color', '#ffffff');
                    $(e.element).closest('tr').find('input').css('color', '#545454');
                }
                //error
                else if ((currentValue + totalWorkedUp) > maxQuantityToUse) {
                    $(e.element).closest('tr')
                        .css('background', '#d9534f')
                        .css('color', '#ffffff');
                    $(e.element).closest('tr').find('input').css('color', '#545454');
                }
                // console.log(currentValue, maxQuantityToUse);
            }
        });
    };
    StructureUsageValidator.prototype.loadEventHandlers = function () {
        var _this = this;
        window.Parsley
            .addValidator('maxQuantityToUse', {
            requirementType: 'string',
            validateString: function (value, requirement) {
                value = value.replace(',', '');
                value = parseFloat(value);
                requirement = parseFloat(requirement);
                return value <= requirement;
            },
            messages: {
                en: 'Max %s',
                es: 'Max $s'
            }
        });
        $(document).on("keyup", '.structure-list-entry-progress input.quantity-to-use', function () {
            var $tr = $(this).closest('tr');
            // let quantityToUse = parseFloat($tr.attr('data-quantity-to-use'));
            // let totalWorkedUp = parseFloat($tr.attr('data-total-worked-up'));
            var quantityToUse = $tr.attr('data-quantity-to-use');
            quantityToUse = quantityToUse.replace(',', '');
            quantityToUse = parseFloat(quantityToUse);
            var totalWorkedUp = $tr.attr('data-total-worked-up');
            totalWorkedUp = totalWorkedUp.replace(',', '');
            totalWorkedUp = parseFloat(totalWorkedUp);
            var unitOfMeasurement = $tr.attr('data-unit-of-measurement');
            var maxQuantityToUse = (quantityToUse + (quantityToUse * 1)) - totalWorkedUp;
            maxQuantityToUse = maxQuantityToUse < 0 ? 0 : maxQuantityToUse;
            $(this).attr('data-parsley-max-quantity-to-use', maxQuantityToUse);
            $(this).attr('data-parsley-max-quantity-to-use-message', "Permitido: " + maxQuantityToUse + " " + unitOfMeasurement);
            $(this).parsley().validate();
            // console.log($(this).val(), quantityToUse);
        });
    };
    return StructureUsageValidator;
}());
