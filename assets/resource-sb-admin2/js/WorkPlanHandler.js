var WorkPlanHandler = /** @class */ (function () {
    function WorkPlanHandler() {
        moment.locale('es');
        this._headerDays = [];
        this._bodyChecks = [];
        this._projectList = [];
        this._testData = [{ "code": "ra.22.2221", "dateList": ["2020-01-01", "2020-01-02", "2020-01-03"] }, { "code": "ra.22.2222", "dateList": ["2020-01-04", "2020-01-05", "2020-01-06"] }];
        this._weekNumber = moment().week();
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
    WorkPlanHandler.prototype.printWeek = function (weekNumber) {
        var begin = moment().startOf('week').isoWeekday(1);
        var startDate = begin.week(weekNumber).format('YYYY-MM-DD');
        var endDate = moment(startDate, "YYYY-MM-DD").add(6, 'days').format('YYYY-MM-DD');
        var range = moment.range(startDate, endDate);
        var arrayMoment = Array.from(range.by('day'));
        var arrayDates = [];
        var monthNameList = [];
        var $tableDates = $('.table-dates');
        var $tableMonth = $('.table-month');
        $.each(arrayMoment, function (i, moment) {
            monthNameList.push(moment.format('MMMM'));
            arrayDates.push(moment.format('DD'));
            $($tableDates[i]).text(moment.format('DD'));
        });
        monthNameList = monthNameList.filter(function (a, b) { return monthNameList.indexOf(a) === b; });
        $tableMonth.text(monthNameList.join('/'));
        console.log(monthNameList, arrayDates);
    };
    WorkPlanHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.cell-date', function (e) {
            e.preventDefault();
            var $cell = $(this);
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    if ($.trim($cell.html()) == "") {
                        $cell.html("<i class='fa fa-check'></i>");
                    }
                    else {
                        $cell.html("");
                    }
                }
            });
        });
        $(document).on('click', '.change-week', function (e) {
            e.preventDefault();
            if ($(this).hasClass('previous-week'))
                _this._weekNumber--;
            else if ($(this).hasClass('next-week'))
                _this._weekNumber++;
            _this.printWeek(_this._weekNumber);
        });
    };
    return WorkPlanHandler;
}());
// var begin = moment().startOf('week').isoWeekday(1);
// begin.week(1).format('YYYY-MM-DD');
