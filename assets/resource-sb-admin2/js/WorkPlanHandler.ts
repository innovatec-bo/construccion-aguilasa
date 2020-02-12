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
    private _headerDays : any;
    private _bodyChecks : any;
    private _testData : any;
    private _projectList : any;
    constructor()
    {
        moment.locale('es');
        this._headerDays = [];
        this._bodyChecks = [];
        this._projectList = [];
        this._testData = [{"code":"ra.22.2221","dateList":["2020-01-01","2020-01-02","2020-01-03"]},{"code":"ra.22.2222","dateList":["2020-01-04","2020-01-05","2020-01-06"]}];        
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

    public loadEventHandlers()
    {
        let _this = this;
        $(document).on('click', '.cell-date', function(e){
            e.preventDefault();
            let $cell = $(this);

            if($.trim($cell.html()) == "")
            {
                $cell.html("<i class='fa fa-check'></i>");
            }
            else
            {
                $cell.html("");   
            }
        });
    }
}