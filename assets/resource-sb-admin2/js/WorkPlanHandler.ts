// export {};
declare let toastr: any;
declare let Date: any;
declare let Handlebars: any;
declare let FullCalendar: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let swal: any;
declare let window: any;
declare let moment: any;
declare let select2ProjectGeneralList : any;
declare let PerfectScrollbar : any;

class WorkPlanHandler
{
    private _workPlanId : number;
    private _headerDays : any;
    private _bodyChecks : any;
    private _testData : any;
    private _weekNumber : any;
    private _projectList : any;
    private _masterTemplate : any;

    constructor()
    {
        moment.locale('es');
        this._headerDays = [];
        this._bodyChecks = [];
        this._projectList = [];
        this._testData = [{"code":"ra.22.2221","dateList":["2020-01-01","2020-01-02","2020-01-03"]},{"code":"ra.22.2222","dateList":["2020-01-04","2020-01-05","2020-01-06"]}];        
        this._weekNumber = moment().week();
        
    }
    
    public add(formData?)
    {
        this._weekNumber = moment().week();
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxWorkPlan/add',
            dataType  :"json",
            method : method,
            data:formData,
            beforeSend:function(){
                // _this._beforeSend(method);
            },
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this._masterTemplate = $("<div>"+response.data.template+"</div>");
                    _this._launchForm(response, 'Crear plan de trabajo');
                }
                else if(response.success === 1 && formData)
                {
                    toastr.success(response.message, '', {'progressBar':true});
                    $("#work-plan-index").DataTable().ajax.reload(null, false);
                }
                else
                {
                    toastr.error(response.message, '', {'progressBar':true})
                }
            }
        });
    }

    public edit(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxWorkPlan/edit/'+_this._workPlanId,
            dataType  :"json",
            method : method,
            data:formData,
            beforeSend:function(){
                // _this._beforeSend(method);
            },
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this._masterTemplate = $("<div>"+response.data.template+"</div>");
                    _this._launchForm(response, 'Editar plan de trabajo');
                }
                else if(response.success === 1 && formData)
                {
                    toastr.success(response.message, '', {'progressBar':true});
                    $("#work-plan-index").DataTable().ajax.reload(null, false);
                }
                else
                {
                    toastr.error(response.message, '', {'progressBar':true})
                }
            }
        });
    }

    public delete()
    {
        let _this = this;
        swal.fire({
            title: "Eliminar Plan de trabajo?",
            html: "",
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick:false,
            width:'50%'
        }).then((result) => {
            if (result.value)
            {
                $.ajax({
                    url : base_url + 'panel/AjaxWorkPlan/delete/'+_this._workPlanId,
                    dataType  :"json",
                    method : "post",
                    data:{},
                    beforeSend:function(){
                        // _this._beforeSend(method);
                    },
                    success:function(response){
                        if(response.success === 1)
                        {
                            toastr.success(response.message, '', {'progressBar':true});
                            $("#work-plan-index").DataTable().ajax.reload(null, false);
                        }
                        else
                        {
                            toastr.error(response.message, '', {'progressBar':true})
                        }
                    }
                });        
            }
        });
    }

    private _launchForm(response, title)
    {
        let _this = this;
        let workPlanTable = _this._masterTemplate.find("#work-plan-table").html();
        Handlebars.registerPartial("work-plan-table", workPlanTable);
        let workPlanTableRow = _this._masterTemplate.find("#work-plan-table-row").html();
        Handlebars.registerPartial("work-plan-table-row", workPlanTableRow);
        let htmlSource = _this._masterTemplate.find(response.data.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let html = template({workPlan:response.data.workPlanMasterDetail, fiscalList:response.data.fiscalList, builderList:response.data.builderList});
        swal.fire({
            title: title,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick:false,
            showLoaderOnConfirm: true,
            customClass:"modal-workplan-form",
            width:'100%',
            preConfirm: () => {
                let $listContent = $("#project-list-content");
                let $form = $("form[name=work-plan-form]");
                if(!$form.parsley().isValid())
                {
                    $form.parsley().validate();
                    return false;
                }
                else if($listContent.children().length <= 0)
                {
                    $(".table-error-message").removeClass("hidden");
                    return false;
                }
            },
        }).then((result) => {
            if (result.value)
            {
                let $form = $("form[name=work-plan-form]");
                let workPlanId = parseInt($form.find("input[name=work-plan-id]").val());
                if(isNaN(workPlanId))
                {
                    _this.add(_this._prepareDataToSave());
                }
                else
                {
                    _this.edit(_this._prepareDataToSave());
                }
            }
        });
        select2ProjectGeneralList();
        $('[data-toogle=tooltip]').tooltip();
        _this._projectList = response.data.workPlanMasterDetail.projectList;
        if($.isNumeric(response.data.workPlanMasterDetail.weekNumber))
            _this._weekNumber = response.data.workPlanMasterDetail.weekNumber;
        _this._printWeek();
    }

    private _prepareDataToSave()
    {
        let datesToWork = [];
        let $tbody = $("#project-list-content");
        let workPlan = {
            id:"",
            fiscalId:"",
            builderId:"",
            weekNumber:this._weekNumber,
            datesToWork:[]
        };
        workPlan.id = $(".modal-workplan-form").find('select[name=work-plan-id]').val();
        workPlan.fiscalId = $(".modal-workplan-form").find('select[name=fiscal-id] option:selected').val();
        workPlan.builderId = $(".modal-workplan-form").find('select[name=builder-id] option:selected').val();

        $.each($tbody.children(), function(index, tr){
            let projectId = $(tr).find('.select2.project option:selected').val();
            let detail = $(tr).find('.detail').val();
            let observation = $(tr).find('.observation').val();
            $.each($(tr).children('.date-to-work'), function(j, td){
                let $td = $(td);
                let $th = $td.closest('table').find('th.table-dates').eq($td.index()-2);
                if($td.hasClass('cell-selected'))
                {
                    let date = $th.data('date');
                    datesToWork.push({'projectId':projectId, 'detail':detail, 'observation':observation, 'date': date});
                }
            });
        });
        workPlan.datesToWork = datesToWork;
        return workPlan;
    }

    private _printWeek()
    {
        let begin = moment().startOf('week').isoWeekday(1);
        let startDate = begin.week(this._weekNumber).format('YYYY-MM-DD');
        let endDate = moment(startDate, "YYYY-MM-DD").add(6, 'days').format('YYYY-MM-DD');
        let range = moment.range(startDate, endDate);
        let arrayMoment = Array.from(range.by('day'));
        let arrayDates = [];
        let monthNameList = [];
        let $tableDates = $('.table-dates');
        let $tableMonth = $('.table-month');
        $.each(arrayMoment, function(i, moment){
            monthNameList.push(moment.format('MMMM'));
            arrayDates.push(moment.format('DD'));
            $($tableDates[i]).text(moment.format('DD'));
            $($tableDates[i]).data('date',moment.format('YYYY-MM-DD'));
        });
        monthNameList = monthNameList.filter((a, b) => monthNameList.indexOf(a) === b);
        $tableMonth.text(monthNameList.join('/'));
        this._printProjectWeek();
    }

    public printWorkPlanSummary(startDate, endDate)
    {
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxWorkPlan/getWorkPlanSummary/'+_this._workPlanId+'/'+startDate+'/'+endDate,
            dataType  :"json",
            method : "GET",
            beforeSend:function(){
                // _this._beforeSend(method);
            },
            success:function(response){
                if(response.success === 1)
                {
                    _this._masterTemplate = $("<div>"+response.data.template+"</div>");
                    _this._printSummaryWeek(response, startDate, endDate);
					new PerfectScrollbar('#work-plan-summary-table tbody', {
						wheelSpeed: 2,
						wheelPropagation: true,
						minScrollbarLength: 50
					});
                    // console.log(response);
                }
                else
                {
                    toastr.error(response.message, '', {'progressBar':true});
                }
            }
        });
    }

    private _printSummaryWeek(response, startDate, endDate)
    {
        startDate = moment(startDate, "YYYY-MM-DD");
        endDate = moment(endDate, "YYYY-MM-DD");
        let range = moment.range(startDate, endDate);
        let arrayMoment = Array.from(range.by('day'));

        let workPlanTable = this._masterTemplate.find("#work-plan-table").html();
        Handlebars.registerPartial("work-plan-table", workPlanTable);
        let workPlanTableRow = this._masterTemplate.find("#work-plan-table-row").html();
        Handlebars.registerPartial("work-plan-table-row", workPlanTableRow);
        let htmlSource = this._masterTemplate.find(response.data.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let html = template({totalDays:arrayMoment.length, arrayMoment:arrayMoment, workPlanSummary:response.data.workPlanSummary});
        $("#work-plan-summary-table").html(html);
        let arrayDates = [];
        let monthNameList = [];
        let $tableDays = $(".table-days");
        let $tableDates = $('.table-dates');
        // let $tableMonth = $('.table-month');
        $.each(arrayMoment, function(i, moment){
            monthNameList.push(moment.format('MMMM'));
            arrayDates.push(moment.format('DD'));
            $($tableDays[i]).text(moment.format("dd"));
            $($tableDates[i]).text(moment.format('DD'));
            $($tableDates[i]).data('date',moment.format('YYYY-MM-DD'));
        });
        // monthNameList = monthNameList.filter((a, b) => monthNameList.indexOf(a) === b);
        // $tableMonth.text(monthNameList.join('/'));
        // this._printProjectWeek();
        $.each(response.data.workPlanSummary, function(i, fiscal){
            $.each(fiscal.builderList, function(j, builder){
                $.each(builder.projectList, function(j, project){
                    let $cellList = $('tr[data-fiscal-id='+fiscal.id+'][data-builder-id='+builder.id+'][data-project-id='+project.id+']').find("td.work-date");
                    $.each(arrayMoment, function(j, moment){
                        $.each(project.dateList, function(k, workDate){
                            //la primera vez que itera pinta la penultima fecha , la segunda vez que itera pinta la ultima fecha y despinta la penultima
                            if(moment.format('YYYY-MM-DD') == workDate)
                            {
                                $($cellList[j]).addClass('cell-selected');
                                // testArray.push("+ "+j+" "+project.projectId+moment.format('YYYY-MM-DD')+" "+workDate);
                                return false;
                                // console.log("+",j,project.projectId, moment.format('YYYY-MM-DD'));
                            }
                            else
                            {
                                $($cellList[j]).removeClass('cell-selected');
                                // testArray.push("- "+j+" "+project.projectId+moment.format('YYYY-MM-DD')+" "+workDate);
                                // console.log('-',j,project.projectId, moment.format('YYYY-MM-DD'));
                            }
                        });
                    });
                });
            });
        });
        $('input[name=work-plan-report-year-month]').datetimepicker({
            ignoreReadonly: true,
            defaultDate:moment().endOf('month').format('YYYY-MM-DD'),
            format: 'MM-YYYY',
            locale:'es',
            useCurrent: true
        });
    }

    private _printProjectWeek()
    {
        let begin = moment().startOf('week').isoWeekday(1);
        let startDate = begin.week(this._weekNumber).format('YYYY-MM-DD');
        let endDate = moment(startDate, "YYYY-MM-DD").add(6, 'days').format('YYYY-MM-DD');
        let range = moment.range(startDate, endDate);
        let arrayMoment = Array.from(range.by('day'));
        let $tableDates = $('.table-dates');

        let testArray = [];
        $.each(this._projectList, function(i, project){
            let $cellList = $('tr[data-project-id='+project.projectId+']').find("td.date-to-work");
            $.each(arrayMoment, function(j, moment){
                $.each(project.projectDateList, function(k, dateToWork){
                    //la primera vez que itera pinta la penultima fecha , la segunda vez que itera pinta la ultima fecha y despinta la penultima
                    if(moment.format('YYYY-MM-DD') == dateToWork)
                    {
                        $($cellList[j]).addClass('cell-selected');
                        testArray.push("+ "+j+" "+project.projectId+moment.format('YYYY-MM-DD')+" "+dateToWork);
                        return false;
                        // console.log("+",j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                    else
                    {
                        $($cellList[j]).removeClass('cell-selected');
                        testArray.push("- "+j+" "+project.projectId+moment.format('YYYY-MM-DD')+" "+dateToWork);
                        // console.log('-',j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                });
            });
        });
    }

    private _addRow()
    {
        let htmlSource = this._masterTemplate.find('#work-plan-table-row').html();
        let template = Handlebars.compile(htmlSource);
        let index = $("#project-list-content").children().length;
        let data = {
            index: index +1
        };
        let html = template(data);
        $('.work-plan-table tbody').append(html);
        $(".table-error-message").addClass("hidden");
        select2ProjectGeneralList();
    }

    private _deleteRow(tr)
    {
        tr.remove();
    }

    public loadEventHandlers()
    {
        let _this    = this;
        $(document).on('click', '.date-to-work', function(e){
            e.preventDefault();
            let $cell = $(this);
            if(!$cell.hasClass('cell-selected'))
            {
                $cell.addClass('cell-selected');
            }
            else
            {
                $cell.removeClass('cell-selected');
            }
        });

        $(document).on('click', '.change-week', function(e){
            e.preventDefault();
            if($(this).hasClass('previous-week'))
                _this._weekNumber--;
            else if($(this).hasClass('next-week'))
                _this._weekNumber++;

            _this._printWeek();
        });

        $(document).on('click', '.add-row', function(e){
            e.preventDefault();
            _this._addRow();            
        });

        $(document).on('click', '.delete-row', function(e){
            e.preventDefault();
            let $tr = $(this).closest('tr');
            _this._deleteRow($tr);
        });

        $(document).on("change",".select2.project",function(e){
            e.preventDefault();
            let $tr = $(this).closest('tr');
            let projectData = $(this).select2('data');
            projectData = projectData[0];
            $tr.find('.project-address').text(projectData.address);
        });

        $(document).on("click", ".edit-work-plan", function(e){
            e.preventDefault();
            let workPlanId = $(this).data('work-plan-id');
            _this._workPlanId = parseInt(workPlanId);
            _this.edit();
        });

        $(document).on("click", ".delete-work-plan", function(e){
            e.preventDefault();
            let workPlanId = $(this).data('work-plan-id');
            _this._workPlanId = parseInt(workPlanId);
            _this.delete();
        });

        $(document).on("click", "#download-work-plan-report", function(e){
            $("form[name=work-plan-report]").submit();
        });

        $(document).on("click", ".load-work-plan-report", function(e){
            let startMonth = moment($("input[name=work-plan-report-from]").val(), "DD-MM-YYYY").format("YYYY-MM-01");
            let endMonth = moment($("input[name=work-plan-report-from]").val(), "DD-MM-YYYY").endOf('month').format("YYYY-MM-DD");
            // console.log(startMonth, endMonth);
            _this.printWorkPlanSummary(startMonth, endMonth);
        });
    }
}
