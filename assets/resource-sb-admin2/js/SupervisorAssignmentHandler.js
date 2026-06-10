"use strict";
var SupervisorAssignmentHandler = /** @class */ (function () {
    function SupervisorAssignmentHandler() {
        this._scrollBarList = [];
    }
    SupervisorAssignmentHandler.prototype.loadDistribution = function (month, year) {
        var _this = this;
        $.ajax({
            url: base_url + 'panel/AjaxSupervisorAssignment/loadDistribution/' + month + '/' + year,
            dataType: "json",
            method: 'get',
            beforeSend: function () {
                blockArea($('.area-to-block'));
            },
            success: function (response) {
                $('.area-to-block').unblock();
                if (response.success === 1) {
                    _this._masterTemplate = $("<div>" + response.data.template + "</div>");
                    //Available builders
                    var htmlSource = _this._masterTemplate.find('#ht-available-builders-list').html();
                    var template = Handlebars.compile(htmlSource);
                    var html = template({ data: response.data });
                    var $availableBuilderContent = $('#available-builders-content');
                    $availableBuilderContent.html(html);
                    //Distribution list
                    htmlSource = _this._masterTemplate.find('#ht-distribution-list').html();
                    template = Handlebars.compile(htmlSource);
                    html = template({ data: response.data });
                    var $distributionContent = $('#distribution-content');
                    $distributionContent.html(html);
                    _this._applyPerfectScrollBar();
                    _this._startDragula();
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
    SupervisorAssignmentHandler.prototype._startDragula = function () {
        var $list = $('.perfect-scroll-bar');
        var _this = this;
        var $contentList = [];
        $.each($list, function (index, value) {
            $contentList.push(value);
        });
        dragula($contentList, {
            isContainer: function (el) {
                return false; // only elements in drake.containers will be taken into account
            },
            moves: function (el, source, handle, sibling) {
                return true; // elements are always draggable by default
            },
            accepts: function (el, target, source, sibling) {
                return true; // elements can be dropped in any of the `containers` by default
            },
            invalid: function (el, handle) {
                return false; // don't prevent any drags from initiating by default
            }
            // direction: 'vertical',             // Y axis is considered when determining where an element would be dropped
            // copy: false,                       // elements are moved by default, not copied
            // copySortSource: false,             // elements in copy-source containers can be reordered
            // revertOnSpill: false,              // spilling will put the element back where it was dragged from, if this is true
            // removeOnSpill: false,              // spilling will `.remove` the element, if this is true
            // mirrorContainer: document.body,    // set the element that gets mirror elements appended
            // ignoreInputTextSelection: true     // allows users to select input text, see details below
        }).on('drag', function (el) {
            $(el).addClass("draggable-cursor");
            _this._updateScrollBars();
        }).on('drop', function (el) {
            $(el).removeClass("draggable-cursor");
            _this._updateScrollBars();
        }).on('cancel', function (el) {
            $(el).removeClass("draggable-cursor");
        });
    };
    SupervisorAssignmentHandler.prototype._applyPerfectScrollBar = function () {
        var $list = $('.perfect-scroll-bar');
        var _this = this;
        $.each($list, function (index, value) {
            //Apply perfect scroll bar
            var dataValue = $(value).data('scroll-bar-identifier');
            var ps = new PerfectScrollbar('.perfect-scroll-bar[data-scroll-bar-identifier=' + dataValue + ']', {
                wheelSpeed: 2,
                wheelPropagation: true,
                minScrollbarLength: 50
            });
            _this._scrollBarList.push(ps);
        });
    };
    SupervisorAssignmentHandler.prototype._updateScrollBars = function () {
        $.each(this._scrollBarList, function (index, value) {
            value.destroy();
        });
        this._applyPerfectScrollBar();
    };
    SupervisorAssignmentHandler.prototype.saveDistribution = function () {
        var _this = this;
        var month = $('select[name=month] option:selected').val();
        var year = $('select[name=year] option:selected').val();
        var dataToSave = this._prepareDataToSave();
        $.ajax({
            url: base_url + 'panel/AjaxSupervisorAssignment/saveDistribution/',
            dataType: "json",
            method: 'post',
            data: { distributionList: dataToSave, month: month, year: year },
            beforeSend: function () {
                blockArea($('.area-to-block'));
            },
            success: function (response) {
                $('.area-to-block').unblock();
                if (response.success === 1) {
                    toastr.success(response.message, '', { 'progressBar': true });
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
    SupervisorAssignmentHandler.prototype._prepareDataToSave = function () {
        var $panelList = $('.fiscal-panel');
        var fiscalList = [];
        $.each($panelList, function (index, value) {
            var fiscalId = $(value).data('fiscal-id');
            var $builderListGroup = $(value).find('.builder-list-group').children('.list-group-item');
            var fiscal = { 'fiscalId': fiscalId, 'builderList': [] };
            var builderList = [];
            $.each($builderListGroup, function (index, value) {
                var builderId = $(value).data('builder-id');
                var builder = { 'builderId': builderId };
                builderList.push(builder);
            });
            fiscal.builderList = builderList;
            fiscalList.push(fiscal);
        });
        return fiscalList;
    };
    SupervisorAssignmentHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.load-distribution-list', function () {
            var month = $('select[name=month] option:selected').val();
            var year = $('select[name=year] option:selected').val();
            _this.loadDistribution(month, year);
        });
        $(document).on('click', '.save-distribution-list', function () {
            _this.saveDistribution();
        });
    };
    return SupervisorAssignmentHandler;
}());
