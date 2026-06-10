"use strict";
var StructureUsageValidator = /** @class */ (function () {
    function StructureUsageValidator(formName) {
        this.formName = formName;
        // this._tableSelector = tableSelector;
        this._formName = formName;
        this._manpowerHasPoint = false;
        this._overflowPercentage = 0;
    }
    StructureUsageValidator.prototype.hasPoint = function () {
        this._manpowerHasPoint = true;
    };
    StructureUsageValidator.prototype.loadFieldEvents = function () {
        var _this = this;
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
                // let maxQuantityToUse = (quantityToUse + (quantityToUse*1.5)) - totalWorkedUp;
                var maxQuantityToUse = (quantityToUse + (quantityToUse * (_this._overflowPercentage / 100))) - totalWorkedUp;
                maxQuantityToUse = maxQuantityToUse < 0 ? 0 : maxQuantityToUse;
                //success
                if (currentValue == 0 || (currentValue + totalWorkedUp) <= quantityToUse) {
                    $(e.element).closest('tr')
                        .css('background', '')
                        .css('color', '');
                    $(e.element).closest('tr').find('input').css('color', '');
                }
                //warning
                // else if( (currentValue + totalWorkedUp) > quantityToUse && currentValue <= maxQuantityToUse)
                // {
                // 	$(e.element).closest('tr')
                // 		.css('background','#f0ad4e')
                // 		.css('color','#ffffff');
                // 	$(e.element).closest('tr').find('input').css('color','#545454');
                // }
                //error
                else if ((currentValue + totalWorkedUp) > maxQuantityToUse) {
                    $(e.element).closest('tr')
                        .css('background', '#d9534f')
                        .css('color', '#ffffff');
                    $(e.element).closest('tr').find('input').css('color', '#545454');
                }
                console.log(currentValue, maxQuantityToUse);
            }
        });
    };
    StructureUsageValidator.prototype.setIncomingProduction = function () {
        var incomingProduction = 0;
        $.each($('#structure-item-list-content').children(), function (index, value) {
            var quantityToUse = $(value).find('.quantity-to-use').val();
            quantityToUse = quantityToUse.replace(',', '');
            quantityToUse = parseFloat(quantityToUse);
            var unitPrice = $(value).find('.unit-price').val();
            unitPrice = unitPrice.replace(',', '');
            unitPrice = parseFloat(unitPrice);
            incomingProduction += (isNaN(quantityToUse) ? 0 : quantityToUse) * (isNaN(unitPrice) ? 0 : unitPrice);
        });
        var $progressBar = $('#production-percentage');
        var currentBudget = $progressBar.data('project-current-budget');
        var currentPercentage = parseFloat($progressBar.data('production-percentage'));
        var incomingPercentage = (incomingProduction * 100) / parseFloat(currentBudget);
        var additionalProductionText = incomingPercentage > 0 ? "+ " + incomingPercentage.toFixed(2) + "% = " + (currentPercentage + incomingPercentage).toFixed(2) + "%" : "";
        $('#additional-production-text').text(additionalProductionText);
        $('#incoming-percentage').css('width', incomingPercentage + "%");
        // $('input[name=production-limit]').val((currentPercentage + incomingPercentage).toFixed(2)).parsley().validate();
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
        window.Parsley
            .addValidator('productionLimit', {
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
            _this.setIncomingProduction();
            var $tr = $(this).closest('tr');
            var quantityToUse = $tr.attr('data-quantity-to-use');
            quantityToUse = quantityToUse.replace(',', '');
            quantityToUse = parseFloat(quantityToUse);
            var totalWorkedUp = $tr.attr('data-total-worked-up');
            totalWorkedUp = totalWorkedUp.replace(',', '');
            totalWorkedUp = parseFloat(totalWorkedUp);
            var unitOfMeasurement = $tr.attr('data-unit-of-measurement');
            var maxQuantityToUse = (quantityToUse + (quantityToUse * (_this._overflowPercentage / 100))) - totalWorkedUp;
            maxQuantityToUse = maxQuantityToUse < 0 ? 0 : maxQuantityToUse;
            // $(this).attr('data-parsley-max-quantity-to-use', maxQuantityToUse);
            // $(this).attr('data-parsley-max-quantity-to-use-message',"Permitido: "+maxQuantityToUse+" "+unitOfMeasurement);
            $(this).parsley().validate();
        });
        $(document).on("keyup", '.structure-list-entry-progress input.unit-price', function () {
            _this.setIncomingProduction();
            // let unitPrice = $(this).val();
            // unitPrice = unitPrice.replace(',','');
            // unitPrice = parseFloat(unitPrice);
            // console.log(unitPrice);
        });
    };
    return StructureUsageValidator;
}());
