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

class WorkPlanHandler
{
    private _workPlanId : number;
    private _headerDays : any;
    private _bodyChecks : any;
    private _testData : any;
    private _projectList : any;
    private _weekNumber : any;
    private _projectList : any;
    constructor()
    {
        moment.locale('es');
        this._headerDays = [];
        this._bodyChecks = [];
        this._projectList = [];
        this._testData = [{"code":"ra.22.2221","dateList":["2020-01-01","2020-01-02","2020-01-03"]},{"code":"ra.22.2222","dateList":["2020-01-04","2020-01-05","2020-01-06"]}];        
        this._weekNumber = moment().week();
        this._workPlanId = 1;
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
                    _this._launchForm(response)
                }
                else if(response.success === 1 && formData)
                {
                    // toastr.success(response.message, '', {"progressBar": true});
                }
                else
                {
                    // toastr.error(response.message, '', {"progressBar": true});
                }
            }
        });
    }

    private _launchForm(response)
    {
        let _this = this;
        let $template = $("<div>"+response.data.template+"</div>");
        let htmlSource = $template.find(response.data.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let html = template({workPlan:response.data.workPlanMasterDetail, fiscalList:response.data.fiscalList, builderList:response.data.builderList});
        $('#work-plan-form-content').html(html);
        _this._projectList = response.data.workPlanMasterDetail.projectList;
        _this._printWeek();
        
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
                        $($cellList[j]).html("<i class='fa fa-check'></i>");
                        testArray.push("+ "+j+" "+project.projectId+moment.format('YYYY-MM-DD')+" "+dateToWork);
                        return false;
                        // console.log("+",j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                    else
                    {
                        $($cellList[j]).removeClass('cell-selected');
                        $($cellList[j]).html("");
                        testArray.push("- "+j+" "+project.projectId+moment.format('YYYY-MM-DD')+" "+dateToWork);
                        // console.log('-',j,project.projectId, moment.format('YYYY-MM-DD'));
                    }
                });
            });
        });
        console.log(testArray);
        
    }

    public loadEventHandlers()
    {
        let _this = this;
        $(document).on('click', '.date-to-work', function(e){
            e.preventDefault();
            let $cell = $(this);
            if($.trim($cell.html()) == "")
            {
                $cell.html("<i class='fa fa-check'></i>");
                $cell.addClass('cell-selected');
            }
            else
            {
                $cell.html("");   
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
    }
}
// var begin = moment().startOf('week').isoWeekday(1);
// begin.week(1).format('YYYY-MM-DD');