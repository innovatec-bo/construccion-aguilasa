// export {};
declare let Handlebars: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let Object: any;
declare let window: any;
declare let Swal: any;

class ManpowerHandler
{
    private _projectId: number;
    private loadViewResponse: any;
    private loadViewTemplate: any;
    private viewData: any;
    private stopTreeLoop: boolean;
    private _breadCrumb : any;
    private nextStep: any;

    public constructor(private projectID: number)
    {
        this._projectId = projectID;
        this.viewData = {};
    }

    private add(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxQuestion/add/'+_this._surveyId,
            dataType  :"json",
            method : method,
            data:formData,
            beforeSend:function()
            {
                let message = "Opening form..";
                if(formData)
                {
                    message = "Processing.."
                }
                swal({
                    html: "<h3>"+message+"</h3>",
                    allowOutsideClick:false,
                    onBeforeOpen: () => {
                        swal.showLoading();
                    }
                });
            },
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this.launchForm(response, "New Question");
                }
                else if(response.success === 1 && formData)
                {
                    swal({ title:'', html:response.message, type:"success"});
                    _this.loadQuestions();
                }
                else
                {
                    swal({ title:'', html:response.message, type:"error"});
                }
            }
        });
    }

    private edit(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxQuestion/edit/'+_this._questionId,
            dataType  :"json",
            method : method,
            data:formData,
            beforeSend:function()
            {
                let message = "Opening form..";
                if(formData)
                {
                    message = "Processing.."
                }
                swal({
                    html: "<h3>"+message+"</h3>",
                    allowOutsideClick:false,
                    onBeforeOpen: () => {
                        swal.showLoading();
                    }
                });
            },
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this.launchForm(response, "Edit Question");

                }
                else if(response.success === 1 && formData)
                {
                    swal({ title:'', html:response.message, type:"success"});
                    _this.loadQuestions();
                }
                else
                {
                    swal({ title:'', html:response.message, type:"error"});
                }
            }
        });
    }

    private launchForm (response, formTitle)
    {
        let htmlTemplate = response.template;
        let $template = $("<div>"+htmlTemplate+"</div>");
        let htmlSource = $template.find(response.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let data = {question:response.data.question};
        let html = template(data);
        let _this = this;
        swal({
            title: formTitle,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: language.btn_save,
            allowOutsideClick:false,
            showLoaderOnConfirm: true,
            customClass:"question-form",
            preConfirm: () => {
                let $form = $("form[name=question-form]");
                if(!$form.parsley().isValid())
                {
                    $form.parsley().validate();
                    swal.showValidationMessage('Corrija los errores e intente nuevamente');
                }
            },
        }).then((result) => {
            if (result.value)
            {
                let $form = $("form[name=question-form]");
                let questionId = parseInt($form.find("input[name=question-id]").val());
                if(isNaN(questionId))
                {
                    _this.add($form.serialize());
                }
                else
                {
                    _this.edit($form.serialize());
                }
            }
        });
    }

    public loadManpower()
    {
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxProject/getManpower/'+_this._projectId,
            dataType  :"json",
            method : 'GET',
            beforeSend:function()
            {
                // swal({
                //     html: "<h3>Loading</h3>",
                //     allowOutsideClick:false,
                //     onBeforeOpen: () => {
                //         swal.showLoading();
                //     }
                // });
            },
            success:function(response){
                // console.log(response);
                let $template = $("<div>"+response.data.template+"</div>");
                let htmlSource   = $template.find(response.data.templateName).html();
                let template = Handlebars.compile(htmlSource);
                let html = template({laborCostMasterDetail:response.data.laborCostMasterDetail});
                $("#manpower-table").html(html);
            }
        });
    }

    loadEventHandler()
    {
        let _this = this;
        $(document).on("click", ".add-manpower-progress", function(e){
            e.preventDefault();
            console.log(_this._projectId);
        });
    }
}