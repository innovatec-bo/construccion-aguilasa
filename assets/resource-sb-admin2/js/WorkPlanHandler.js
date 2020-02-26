var WorkPlanHandler = /** @class */ (function () {
    function WorkPlanHandler() {
        moment.locale('es');
        this._headerDays = [];
        this._bodyChecks = [];
        this._projectList = [];
        this._testData = [{ "code": "ra.22.2221", "dateList": ["2020-01-01", "2020-01-02", "2020-01-03"] }, { "code": "ra.22.2222", "dateList": ["2020-01-04", "2020-01-05", "2020-01-06"] }];
        this._weekNumber = moment().week();
    }
    WorkPlanHandler.prototype.add = function (formData) {
        var _this = this;
        var method = !formData ? "GET" : "POST";
        $.ajax({
            url: base_url + 'panel/AjaxWorkPlan/add',
            dataType: "json",
            method: method,
            data: formData,
            beforeSend: function () {
                // _this._beforeSend(method);
            },
            success: function (response) {
                if (response.success === 1 && !formData) {
                    _this._masterTemplate = $("<div>" + response.data.template + "</div>");
                    _this._launchForm(response, 'Crear plan de trabajo');
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
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
                    _this._masterTemplate = $("<div>" + response.data.template + "</div>");
                    _this._launchForm(response, 'Editar plan de trabajo');
                }
                else if (response.success === 1 && formData) {
                    toastr.success(response.message, '', { 'progressBar': true });
                    $("#work-plan-index").DataTable().ajax.reload(null, false);
                }
                else {
                    toastr.error(response.message, '', { 'progressBar': true });
                }
            }
        });
    };
    WorkPlanHandler.prototype["delete"] = function () {
        var _this = this;
        swal.fire({
            title: "Eliminar Plan de trabajo?",
            html: "",
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            width: '50%'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: base_url + 'panel/AjaxWorkPlan/delete/' + _this._workPlanId,
                    dataType: "json",
                    method: "post",
                    data: {},
                    beforeSend: function () {
                        // _this._beforeSend(method);
                    },
                    success: function (response) {
                        if (response.success === 1) {
                            toastr.success(response.message, '', { 'progressBar': true });
                            $("#work-plan-index").DataTable().ajax.reload(null, false);
                        }
                        else {
                            toastr.error(response.message, '', { 'progressBar': true });
                        }
                    }
                });
            }
        });
    };
    WorkPlanHandler.prototype._launchForm = function (response, title) {
        var _this = this;
        var workPlanTable = _this._masterTemplate.find("#work-plan-table").html();
        Handlebars.registerPartial("work-plan-table", workPlanTable);
        var workPlanTableRow = _this._masterTemplate.find("#work-plan-table-row").html();
        Handlebars.registerPartial("work-plan-table-row", workPlanTableRow);
        var htmlSource = _this._masterTemplate.find(response.data.templateName).html();
        var template = Handlebars.compile(htmlSource);
        var html = template({ workPlan: response.data.workPlanMasterDetail, fiscalList: response.data.fiscalList, builderList: response.data.builderList });
        swal.fire({
            title: title,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            customClass: "modal-workplan-form",
            width: '100%',
            preConfirm: function () {
                var $listContent = $("#project-list-content");
                var $form = $("form[name=work-plan-form]");
                if (!$form.parsley().isValid()) {
                    $form.parsley().validate();
                    return false;
                }
                else if ($listContent.children().length <= 0) {
                    $(".table-error-message").removeClass("hidden");
                    return false;
                }
            }
        }).then(function (result) {
            if (result.value) {
                var $form = $("form[name=work-plan-form]");
                var workPlanId = parseInt($form.find("input[name=work-plan-id]").val());
                if (isNaN(workPlanId)) {
                    _this.add(_this._prepareDataToSave());
                }
                else {
                    _this.edit(_this._prepareDataToSave());
                }
            }
        });
        select2ProjectGeneralList();
        $('[data-toogle=tooltip]').tooltip();
        _this._projectList = response.data.workPlanMasterDetail.projectList;
        _this._printWeek();
    };
    WorkPlanHandler.prototype._prepareDataToSave = function () {
        var datesToWork = [];
        var $tbody = $("#project-list-content");
        var workPlan = {
            id: "",
            fiscalId: "",
            builderId: "",
            datesToWork: []
        };
        workPlan.id = $(".modal-workplan-form").find('select[name=work-plan-id]').val();
        workPlan.fiscalId = $(".modal-workplan-form").find('select[name=fiscal-id] option:selected').val();
        workPlan.builderId = $(".modal-workplan-form").find('select[name=builder-id] option:selected').val();
        $.each($tbody.children(), function (index, tr) {
            var projectId = $(tr).find('.select2.project option:selected').val();
            var detail = $(tr).find('.detail').val();
            var observation = $(tr).find('.observation').val();
            $.each($(tr).children('.date-to-work'), function (j, td) {
                var $td = $(td);
                var $th = $td.closest('table').find('th.table-dates').eq($td.index() - 2);
                if ($td.hasClass('cell-selected')) {
                    var date = $th.data('date');
                    datesToWork.push({ 'projectId': projectId, 'detail': detail, 'observation': observation, 'date': date });
                }
            });
        });
        workPlan.datesToWork = datesToWork;
        return workPlan;
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
            $($tableDates[i]).data('date', moment.format('YYYY-MM-DD'));
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
                        testArray.push("+ " + j + " " + project.projectId + moment.format('YYYY-MM-DD') + " " + dateToWork);
                        return false;
                        // console.log("+",j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                    else {
                        $($cellList[j]).removeClass('cell-selected');
                        testArray.push("- " + j + " " + project.projectId + moment.format('YYYY-MM-DD') + " " + dateToWork);
                        // console.log('-',j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                });
            });
        });
    };
    WorkPlanHandler.prototype._addRow = function () {
        var htmlSource = this._masterTemplate.find('#work-plan-table-row').html();
        var template = Handlebars.compile(htmlSource);
        var index = $("#project-list-content").children().length;
        var data = {
            index: index + 1
        };
        var html = template(data);
        $('.work-plan-table tbody').append(html);
        $(".table-error-message").addClass("hidden");
        select2ProjectGeneralList();
    };
    WorkPlanHandler.prototype._deleteRow = function (tr) {
        tr.remove();
    };
    WorkPlanHandler.prototype.loadEventHandlers = function () {
        var _this = this;
        $(document).on('click', '.date-to-work', function (e) {
            e.preventDefault();
            var $cell = $(this);
            if (!$cell.hasClass('cell-selected')) {
                $cell.addClass('cell-selected');
            }
            else {
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
        $(document).on('click', '.add-row', function (e) {
            e.preventDefault();
            _this._addRow();
        });
        $(document).on('click', '.delete-row', function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            _this._deleteRow($tr);
        });
        $(document).on("change", ".select2.project", function (e) {
            e.preventDefault();
            var $tr = $(this).closest('tr');
            var projectData = $(this).select2('data');
            projectData = projectData[0];
            $tr.find('.project-address').text(projectData.address);
        });
        $(document).on("click", ".edit-work-plan", function (e) {
            e.preventDefault();
            var workPlanId = $(this).data('work-plan-id');
            _this._workPlanId = parseInt(workPlanId);
            _this.edit();
        });
        $(document).on("click", ".delete-work-plan", function (e) {
            e.preventDefault();
            var workPlanId = $(this).data('work-plan-id');
            _this._workPlanId = parseInt(workPlanId);
            _this["delete"]();
        });
    };
    return WorkPlanHandler;
}());
