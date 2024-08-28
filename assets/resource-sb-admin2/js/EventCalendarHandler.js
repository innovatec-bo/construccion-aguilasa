var EventCalendarHandler = /** @class */ (function () {
    function EventCalendarHandler() {
        moment.locale('es');
        this._calendarElement = document.getElementById('calendar');
        this._dateStartDateSelected = null;
        this._initializeCalendar();
    }
    EventCalendarHandler.prototype.add = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxEvent/add',
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                _this._beforeSend(method);
            },
            success: function (response) {
                EventCalendarHandler._destroyPopOvers();
                if (response.success === 1 && !formData) {
                    _this.launchForm(response);
                }
                else if (response.success === 1 && formData) {
                    _this.refreshCalendar();
                    _this._dateStartDateSelected = null;
                    _this._calendar.unselect();
                    toastr.success(response.message, '', { "progressBar": true });
                }
                else {
                    toastr.error(response.message, '', { "progressBar": true });
                    _this.refreshCalendar();
                    _this._dateStartDateSelected = null;
                }
            }
        });
    };
    EventCalendarHandler.prototype.launchForm = function (response) {
        var _this = this;
        var $template = $("<div>" + response.data.template + "</div>");
        var htmlSource = $template.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var html = template({ event: response.data.event });
        $(_this._popoverAttachTo).popover({
            content: html,
            placement: 'left',
            html: true,
            trigger: 'click',
            animation: true,
            container: 'body',
            template: '<div class="popover box-shadow-3 no-border event-calendar-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        }).popover('show');
        var defaultDate1 = moment();
        var defaultDate2 = moment().add(1, 'hours');
        if (_this._dateStartDateSelected !== null) {
            defaultDate1 = moment(this._dateStartDateSelected);
            defaultDate2 = moment(this._dateStartDateSelected).add(1, 'hours');
        }
        $('.event-date-time-from').datetimepicker({
            locale: 'es',
            useCurrent: false,
            ignoreReadonly: true,
            defaultDate: defaultDate1,
            format: 'llll',
            widgetPositioning: { horizontal: 'auto', vertical: 'auto' }
        });
        $('.event-date-time-to').datetimepicker({
            locale: 'es',
            useCurrent: false,
            ignoreReadonly: true,
            defaultDate: defaultDate2,
            format: 'llll',
            widgetPositioning: { horizontal: 'auto', vertical: 'auto' }
        });
    };
    EventCalendarHandler.prototype.edit = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxEvent/edit/' + _this._eventId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                _this._beforeSend(method);
            },
            success: function (response) {
                EventCalendarHandler._destroyPopOvers();
                if (response.success === 1 && !formData) {
                    EventCalendarHandler._parseTimeToEdit(response.data.event);
                    _this.launchForm(response);
                }
                else if (response.success === 1 && formData) {
                    _this.refreshCalendar();
                    toastr.success(response.message, '', { "progressBar": true });
                }
                else {
                    _this.refreshCalendar();
                    toastr.error(response.message, '', { "progressBar": true });
                }
            }
        });
    };
    EventCalendarHandler.prototype._initializeCalendar = function () {
        var _this = this;
        var defaultDate = moment().format("YYYY-MM-DD");
        this._calendar = new FullCalendar.Calendar(this._calendarElement, {
            plugins: ['interaction', 'dayGrid', 'timeGrid'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'es',
            defaultDate: defaultDate,
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: false,
            select: function (selectInfo) {
                _this._popoverAttachTo = ".fc-highlight";
                _this._dateStartDateSelected = moment(selectInfo.start).format('YYYY-MM-DD HH:mm:ss');
                _this.add();
            },
            eventClick: function (info) {
                EventCalendarHandler._destroyPopOvers();
                _this._popoverAttachTo = info.el;
                _this._eventId = info.event.id;
                _this.edit();
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: {
                url: base_url + 'panel/AjaxEvent/calendarAllEvents',
                failure: function () {
                    document.getElementById('script-warning').style.display = 'block';
                }
            },
            loading: function (bool) {
                document.getElementById('loading').style.display =
                    bool ? 'block' : 'none';
            },
            viewSkeletonRender: function () {
                EventCalendarHandler._destroyPopOvers();
                console.log('new view');
            }
        });
        this._calendar.render();
    };
    EventCalendarHandler.prototype._parseTimeToSend = function (formData) {
        $.each(formData, function (index, value) {
            if (value.name == 'date-time-from' || value.name == 'date-time-to') {
                formData[index].value = moment(value.value, 'llll').format('YYYY-MM-DD HH:mm:ss');
            }
        });
        return formData;
    };
    EventCalendarHandler._parseTimeToEdit = function (event) {
        event.startTime = moment(event.startTime, 'YYYY-MM-DD HH:mm:ss').format('llll');
        event.endTime = moment(event.endTime, 'YYYY-MM-DD HH:mm:ss').format('llll');
        return event;
    };
    EventCalendarHandler.prototype.refreshCalendar = function () {
        this._calendar.refetchEvents();
    };
    EventCalendarHandler._destroyPopOvers = function () {
        $('.popover').popover('dispose');
    };
    EventCalendarHandler.prototype._beforeSend = function (method) {
        if (method == "GET") {
            $(this._popoverAttachTo).popover({
                content: "Cargando..",
                placement: 'left',
                html: true,
                trigger: 'click',
                animation: true,
                container: 'body',
                template: '<div class="popover box-shadow-3 no-border event-calendar-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
            }).popover('show');
        }
    };
    EventCalendarHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on("click", ".event-calendar-btn-cancel", function (e) {
            e.preventDefault();
            EventCalendarHandler._destroyPopOvers();
        });
        $(document).on("submit", "form[name=event-calendar-form]", function (e) {
            e.preventDefault();
            var eventId = parseInt($("input[name=event-id]").val());
            var $form = $("form[name=event-calendar-form]");
            var formData = _this._parseTimeToSend($form.serializeArray());
            if (isNaN(eventId)) {
                _this.add(formData);
            }
            else {
                _this.edit(formData);
            }
        });
    };
    return EventCalendarHandler;
}());
