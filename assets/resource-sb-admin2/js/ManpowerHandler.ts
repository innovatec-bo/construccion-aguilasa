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
    private _loadViewTemplate: any;
    private viewData: any;
    private stopTreeLoop: boolean;
    private _breadCrumb : any;
    private _laborCostMasterDetail: any;

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
            url : base_url + 'panel/AjaxProject/addManpowerProgress/'+_this._projectId,
            dataType  :"json",
            method : method,
            data:formData,
            beforeSend:function()
            {
                let message = "Cargando formulario..";
                if(formData)
                {
                    message = "Procesando.."
                }
                Swal({
                    html: "<h3>"+message+"</h3>",
                    allowOutsideClick:false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this.launchForm(response, "Registrar avance");
                }
                else if(response.success === 1 && formData)
                {
                    Swal({ title:'', html:response.message, type:"success"});
                }
                else
                {
                    Swal({ title:'', html:response.message, type:"error"});
                }
            }
        });
    }

    private edit(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxProject/edit/'+_this._questionId,
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
                Swal({
                    html: "<h3>"+message+"</h3>",
                    allowOutsideClick:false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
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
        this._loadViewTemplate = response.data.template;
        this._laborCostMasterDetail = response.data.laborCostMasterDetail;
        let $template = $("<div>"+this._loadViewTemplate+"</div>");
        let structureItemList = $template.find("#ht-structure-item-list").html();
        Handlebars.registerPartial("ht-structure-item-list", structureItemList);
        let structureItem = $template.find("#ht-structure-item").html();
        Handlebars.registerPartial("ht-structure-item", structureItem);
        let htmlSource = $template.find(response.data.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let item = {
            index:1,
            laborCostList:this._laborCostMasterDetail
        };
        let structureList = [item];
        let data = {structureList:structureList, builders:response.data.builders};
        let html = template(data);
        let _this = this;
        Swal({
            title: formTitle,
            html: html,
            showCancelButton: true,
            confirmButtonColor: '#E41C5E',
            cancelButtonColor: '#DDDDDD',
            confirmButtonText: 'Guardar',
            allowOutsideClick:false,
            showLoaderOnConfirm: true,
            customClass:"modal-manpower-form",
            width:'100%',
            preConfirm: () => {
                let $listContent = $("#structure-item-list-content");
                let $form = $("form[name=manpower-progress-form]");
                if(!$form.parsley().isValid())
                {
                    $form.parsley().validate();
                    return false;
                    // Swal.showValidationMessage('Corrija los errores e intente nuevamente');
                }
                else if($listContent.children().length <= 0)
                {
                    $(".table-error-message").removeClass("hide");
                    return false;
                }
            },
        }).then((result) => {
            if (result.value)
            {
                let $form = $("form[name=manpower-progress-form]");
                _this.add($form.serialize());
                // let questionId = parseInt($form.find("input[name=question-id]").val());
                // if(isNaN(questionId))
                // {
                //     _this.add($form.serialize());
                // }
                // else
                // {
                //     _this.edit($form.serialize());
                // }
            }
        });
        let date = new Date();
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            defaultDate: date,
            format: 'DD-MM-YYYY'
        });
        $(".select2-builders").select2();
        this._startSelect2();
        $(".input-masked").inputmask('decimal',{min:1, max:999999, groupSeparator: ',', autoGroup: true});
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

    private _addRow()
    {
        $(".table-error-message").addClass("hide");
        let $listContent = $("#structure-item-list-content");
        let $template = $("<div>"+this._loadViewTemplate+"</div>");
        let htmlSource   = $template.find('#ht-structure-item').html();
        let template = Handlebars.compile(htmlSource);
        let index = $listContent.children().length + 1;
        let data = {
            index:index,
            laborCostList:this._laborCostMasterDetail
        };
        let html = template(data);

        $listContent.append(html);
        // evaluateVisibilityBtnRemove();
        let selectorSelect2 = "[data-row-index='"+index+"'] select";
        this._startSelect2(selectorSelect2);
        $(".input-masked").inputmask('decimal',{min:1, max:999999, groupSeparator: ',', autoGroup: true});
    }

    private _removeRow()
    {

    }

    private _startSelect2(selector?)
    {
        let _this = this;
        selector = selector || '.select2-structure-code';
        $(selector).select2({
            containerCssClass: "select-xs",
            width:'100%',
            // escapeMarkup: function (markup) { return markup; },
            templateResult: function(state){
                let alreadySelected : any = [];
                $.each($(".select2-structure-code"), function(index, value){
                    alreadySelected.push($(value).val());
                    // console.log($(value).val());
                });
                if(!state.id)
                {
                    return state.text;
                }
                else
                {
                    if(alreadySelected.indexOf(state.id) < 0)
                    {
                        let $originalOption = $(state.element);
                        let data = {
                            structureCode: state.text,
                            activity: $originalOption.data('activity'),
                            execution: $originalOption.data('execution'),
                            quantity: $originalOption.data('quantity'),
                            unitOfMeasurement: $originalOption.data('unit-of-measurement'),
                            description: $originalOption.data('description')
                        };
                        let $template = $("<div>"+_this._loadViewTemplate+"</div>");
                        let htmlSource = $template.find('#ht-select2-template-result').html();
                        let template = Handlebars.compile(htmlSource);
                        let html = template(data);
                        let $state = $(html);
                        return $state;
                    }
                }
            }
        });
    }

    loadEventHandler()
    {
        let _this = this;
        $(document).on("click", ".add-manpower-progress", function(e){
            e.preventDefault();
            _this.add();
        });

        $(document).on('click','.add-row', function(e){
            e.preventDefault();
            _this._addRow();
        });

        $(document).on('select2:select','.select2-structure-code', function(e){
            $(this).parsley().validate();
            $(".table-error-message").addClass("hide");
            let $optionElement = $(e.params.data.element);
            let unitOfMeasurement = $optionElement.data('unit-of-measurement');
            let activity = $optionElement.data('activity');
            let execution = $optionElement.data('execution');
            let description = $optionElement.data('description');
            let quantity = $optionElement.data('quantity');
            $optionElement.closest('tr').find('.activity').text(activity);
            $optionElement.closest('tr').find('.execution').text(execution);
            $optionElement.closest('tr').find('.description').text(description);
            $optionElement.closest('tr').find('.unit-of-measurement').text(unitOfMeasurement);
            $optionElement.closest('tr').find('.quantity').text(quantity);
        });

        $(document).on("change","select[name='builders[]']",function(){
            $("select[name='builders[]']").parsley().validate();
        });

        $(document).on("click",".remove-row", function(){
           $(this).closest("tr").remove();

        });
    }
}