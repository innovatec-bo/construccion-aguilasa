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
        let html = template({workplan:response.data.workplanMasterDetail});

        $('#work-plan-form-content').html(html);
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

    public printWeek(weekNumber)
    {
        let begin = moment().startOf('week').isoWeekday(1);
        let startDate = begin.week(weekNumber).format('YYYY-MM-DD');
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

        console.log(monthNameList, arrayDates);
    }

    public loadEventHandlers()
    {
        let _this = this;
        $(document).on('click', '.cell-date', function(e){
            e.preventDefault();
            let $cell = $(this);
            swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.value)
                {
                    if($.trim($cell.html()) == "")
                    {
                        $cell.html("<i class='fa fa-check'></i>");
                    }
                    else
                    {
                        $cell.html("");   
                    }    
                }
            });
            
        });

        $(document).on('click', '.change-week', function(e){
            e.preventDefault();
            if($(this).hasClass('previous-week'))
                _this._weekNumber--;
            else if($(this).hasClass('next-week'))
                _this._weekNumber++;

            _this.printWeek(_this._weekNumber);
        });
    }
}
// var begin = moment().startOf('week').isoWeekday(1);
// begin.week(1).format('YYYY-MM-DD');