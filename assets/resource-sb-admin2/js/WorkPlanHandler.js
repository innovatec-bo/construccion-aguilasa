var WorkPlanHandler = /** @class */ (function () {
    function WorkPlanHandler() {
        moment.locale('es');
        this._headerDays = [];
        this._bodyChecks = [];
        this._projectList = [];
        this._testData = [{ "code": "ra.22.2221", "dateList": ["2020-01-01", "2020-01-02", "2020-01-03"] }, { "code": "ra.22.2222", "dateList": ["2020-01-04", "2020-01-05", "2020-01-06"] }];
        this._weekNumber = moment().week();
        this._workPlanId = 1;
    }
    WorkPlanHandler.prototype.edit = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxWorkPlan/edit/' + _this._workPlanId,
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                // _this._beforeSend(method);
            },
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this._launchForm(response);
                }
                else if (response.success === 1 && formData) {
                    // toastr.success(response.message, '', {"progressBar": true});
                }
                else {
                    // toastr.error(response.message, '', {"progressBar": true});
                }
            }
        });
    };
    WorkPlanHandler.prototype._launchForm = function (response) {
        var _this = this;
        var $template = $("<div>" + response.data.template + "</div>");
        var htmlSource = $template.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var html = template({ workPlan: response.data.workPlanMasterDetail, fiscalList: response.data.fiscalList, builderList: response.data.builderList });
        $('#work-plan-form-content').html(html);
        _this._projectList = response.data.workPlanMasterDetail.projectList;
        _this._printWeek();
    };
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
    WorkPlanHandler.prototype._printWeek = function () {
        var begin = moment().startOf('week').isoWeekday(1);
        var startDate = begin.week(this._weekNumber).format('YYYY-MM-DD');
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
        this._printProjectWeek();
    };
    WorkPlanHandler.prototype._printProjectWeek = function () {
        var begin = moment().startOf('week').isoWeekday(1);
        var startDate = begin.week(this._weekNumber).format('YYYY-MM-DD');
        var endDate = moment(startDate, "YYYY-MM-DD").add(6, 'days').format('YYYY-MM-DD');
        var range = moment.range(startDate, endDate);
        var arrayMoment = Array.from(range.by('day'));
        var $tableDates = $('.table-dates');
        var testArray = [];
        $.each(this._projectList, function (i, project) {
            var $cellList = $('tr[data-project-id=' + project.projectId + ']').find("td.date-to-work");
            $.each(arrayMoment, function (j, moment) {
                $.each(project.projectDateList, function (k, dateToWork) {
                    //la primera vez que itera pinta la penultima fecha , la segunda vez que itera pinta la ultima fecha y despinta la penultima
                    if (moment.format('YYYY-MM-DD') == dateToWork) {
                        $($cellList[j]).addClass('cell-selected');
                        $($cellList[j]).html("<i class='fa fa-check'></i>");
                        testArray.push("+ " + j + " " + project.projectId + moment.format('YYYY-MM-DD') + " " + dateToWork);
                        return false;
                        // console.log("+",j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                    else {
                        $($cellList[j]).removeClass('cell-selected');
                        $($cellList[j]).html("");
                        testArray.push("- " + j + " " + project.projectId + moment.format('YYYY-MM-DD') + " " + dateToWork);
                        // console.log('-',j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                });
            });
        });
        console.log(testArray);
    };
    WorkPlanHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.date-to-work', function (e) {
            e.preventDefault();
            var $cell = $(this);
            if ($.trim($cell.html()) == "") {
                $cell.html("<i class='fa fa-check'></i>");
                $cell.addClass('cell-selected');
            }
            else {
                $cell.html("");
                $cell.removeClass('cell-selected');
            }
        });
        $(document).on('click', '.change-week', function (e) {
            e.preventDefault();
            if ($(this).hasClass('previous-week'))
                _this._weekNumber--;
            else if ($(this).hasClass('next-week'))
                _this._weekNumber++;
            _this._printWeek();
        });
    };
    return WorkPlanHandler;
}());
// var begin = moment().startOf('week').isoWeekday(1);
// begin.week(1).format('YYYY-MM-DD');
