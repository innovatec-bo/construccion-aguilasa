var WorkPlanHandler = /** @class */ (function () {
    function WorkPlanHandler() {
        moment.locale('es');
        this._headerDays = [];
        this._bodyChecks = [];
        this._projectList = [];
        this._testData = [{ "code": "ra.22.2221", "dateList": ["2020-01-01", "2020-01-02", "2020-01-03"] }, { "code": "ra.22.2222", "dateList": ["2020-01-04", "2020-01-05", "2020-01-06"] }];
    }
    WorkPlanHandler.prototype._setHeaderDates = function () {
        var _this = this;
        var startOfMonth = moment('2020-01-01').startOf('month').format('YYYY-MM-DD HH:mm');
        var endOfMonth = moment('2020-01-01').endOf('month').format('YYYY-MM-DD HH:mm');
        var range = moment.range('2020-01-01', '2020-01-31');
        var arrayMoment = Array.from(range.by('day'));
        $.each(arrayMoment, function (index, value) {
            var day = value.format('dd') + " " + value.format('DD');
            _this._headerDays.push(day);
        });
    };
    WorkPlanHandler.prototype._setWorkPlan = function () {
        var _this = this;
        var startOfMonth = moment('2020-01-01').startOf('month').format('YYYY-MM-DD HH:mm');
        var endOfMonth = moment('2020-01-01').endOf('month').format('YYYY-MM-DD HH:mm');
        var range = moment.range('2020-01-01', '2020-01-31');
        var arrayMoment = Array.from(range.by('day'));
        $.each(_this._projectList, function (i, project) {
            var workPlan = [];
            $.each(arrayMoment, function (k, moment) {
                var monthDate = moment.format('YYYY-MM-DD');
                var workDate = 0;
                $.each(project.dateList, function (j, dateToWork) {
                    if (monthDate == dateToWork) {
                        workDate = 1;
                    }
                });
                workPlan.push({ "date": monthDate, "workDate": workDate });
            });
            project.workPlan = workPlan;
        });
    };
    WorkPlanHandler.prototype.printTable = function () {
        var _this = this;
        $.ajax({
            url: base_url + 'panel/AjaxProject/getProjectsAndWorkPlan',
            dataType: "json",
            method: 'post',
            data: {},
            beforeSend: function () {
                $(".table-content").html("Cargando informacion...");
            },
            success: function (response) {
                if (response.success === 1) {
                    _this._projectList = response.data.projectList;
                    _this._setHeaderDates();
                    _this._setWorkPlan();
                    var htmlSource = $("#work-plan-table").html();
                    var template = Handlebars.compile(htmlSource);
                    var html = template({ days: _this._headerDays, projects: _this._projectList });
                    $(".table-content").html(html);
                    $(".table-content table").DataTable();
                }
                else {
                    // toastr.error(response.message, '', {"progressBar": true});
                    // _this.refreshCalendar();
                    // _this._dateStartDateSelected = null;
                }
            }
        });
        // let $template = $("#work-plan-table");
    };
    WorkPlanHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.cell-date', function (e) {
            e.preventDefault();
            var $cell = $(this);
            if ($.trim($cell.html()) == "") {
                $cell.html("<i class='fa fa-check'></i>");
            }
            else {
                $cell.html("");
            }
        });
    };
    return WorkPlanHandler;
}());
