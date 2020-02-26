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
                    toastr.success(response.message, '', {'progressBar':true})
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

    private _setHeaderDates()
    {
        let _this = this;
        let startOfMonth = moment('2020-01-01').startOf('month').format('YYYY-MM-DD HH:mm');
        let endOfMonth   = moment('2020-01-01').endOf('month').format('YYYY-MM-DD HH:mm');

        let range = moment.range('2020-01-01', '2020-01-31');

        let arrayMoment = Array.from(range.by('day'));
        $.each(arrayMoment, function(index, value){
            let day = value.format('dd')+" "+value.format('DD');
            _this._headerDays.push(day);
        });
    }

    private _setWorkPlan()
    {
        let _this = this;
        let startOfMonth = moment('2020-01-01').startOf('month').format('YYYY-MM-DD HH:mm');
        let endOfMonth   = moment('2020-01-01').endOf('month').format('YYYY-MM-DD HH:mm');

        let range = moment.range('2020-01-01', '2020-01-31');

        let arrayMoment = Array.from(range.by('day'));

        $.each(_this._projectList, function(i, project){            
            let workPlan = [];
            $.each(arrayMoment, function(k, moment){
                let monthDate = moment.format('YYYY-MM-DD');
                let workDate = 0;
                $.each(project.dateList, function(j, dateToWork){
                    if(monthDate == dateToWork)
                    {
                        workDate = 1;
                    }
                });
                workPlan.push({"date":monthDate, "workDate":workDate});
            });
            project.workPlan = workPlan;
        });
        
    }

    public printTable()
    {
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxProject/getProjectsAndWorkPlan',
            dataType  :"json",
            method : 'post',
            data:{},
            beforeSend:function(){
                $(".table-content").html("Cargando informacion...");
            },
            success:function(response){
                if(response.success === 1)
                {
                    _this._projectList = response.data.projectList;
                    _this._setHeaderDates();
                    _this._setWorkPlan();
                    let htmlSource = $("#work-plan-table").html();
                    let template = Handlebars.compile(htmlSource);
                    let html = template({days:_this._headerDays, projects:_this._projectList});
                    $(".table-content").html(html);
                    $(".table-content table").DataTable();
                }
                else
                {
                    // toastr.error(response.message, '', {"progressBar": true});
                    // _this.refreshCalendar();
                    // _this._dateStartDateSelected = null;
                }
            }
        });

        // let $template = $("#work-plan-table");
        
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
        let _this = this;
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
    }
}