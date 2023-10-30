// export {};
declare let Handlebars: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let Object: any;
declare let window: any;
declare let Swal: any;
declare let bootbox: any;
declare let toastr: any;
declare let StructureUsageValidator: any;

class ManpowerHandler
{
    private _projectId: number;
    private loadViewResponse: any;
    private _loadViewTemplate: any;
    private viewData: any;
    private stopTreeLoop: boolean;
    private _breadCrumb : any;
    private _laborCostMasterDetail: any;
	private _structureUsageValidator : any;

    public constructor(private projectID: number)
    {
    	this._structureUsageValidator = null;
        this._projectId = projectID;
        this.viewData = {};
    }

	public setStructureUsageValidator(structureUsageValidator)
	{
		this._structureUsageValidator = structureUsageValidator
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
					Swal.close();
					_this.loadManpower();
					_this.loadManpowerLog();
					toastr.success(response.message, '', {'progressBar':true, "timeOut":15000});

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

        let data = {structureList:structureList, builders:response.data.builders, fiscals:response.data.fiscals, project: response.data.project, productionLimit: response.data.productionLimit};
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
            }
        });
        let date = new Date();
		let datesToBlock = _this._datesToBlock(response.data.dateRangesToBlock);
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            format: 'DD-MM-YYYY',
			useCurrent: false,
			disabledDates: datesToBlock
        });
		if(this._structureUsageValidator !== null)
			this._structureUsageValidator.loadFieldEvents();
        $(".select2-builders").select2({dropdownCssClass: "dd-select2-builders"});
        this._startSelect2();
        $(".input-masked").inputmask('decimal',{min:1, max:999999, groupSeparator: ',', autoGroup: true});
        $(".input-masked-price").inputmask('decimal',{min:0, max:999999, groupSeparator: ',', autoGroup: true});
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
                if(response.data.laborCostMasterDetail.length > 10)
				{
					let buttons = ['excel', 'csv','pdf','print'];
					$('#manpower-table table').DataTable({"buttons": buttons});
				}
                // console.log('loaded manpower list');
            }
        });
    }

    public loadBuildingPoints()
    {
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxProject/getBuildingPoints/'+_this._projectId,
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
                // let html = template({laborCostMasterDetail:response.data.laborCostMasterDetail});
                let html = template({buildingPoints:response.data.buildingPoints});
                $("#building-points").html(html);
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
		$(".input-masked-price").inputmask('decimal',{min:0, max:999999, groupSeparator: ',', autoGroup: true});
		let $form = $("form[name=manpower-progress-form]");
		$form.parsley()._refreshFields();
		// $form.parsley('addItem',$(html).find('input.quantity-to-use'));
		// this._structureUsageValidator.loadFieldEvents();
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
            dropdownCssClass: "dd-select2-structure-code",
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
            },
            language: {
              noResults: function() {
                return 'No se encontraron resultados';
              },
            },
            escapeMarkup: function(markup) {
              return markup;
            },
        });
    }


    public loadManpowerLog()
    {
        let _this = this;
        $.ajax({
            url : base_url + 'panel/AjaxProject/getManpowerLog/'+_this._projectId,
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
                let $template = $("<div>"+response.data.template+"</div>");
                let htmlSource   = $template.find(response.data.templateName).html();
                let template = Handlebars.compile(htmlSource);
                let html = template({log:response.data.log});
                $("#status-project-log-content").html(html);
                $('[data-toggle="tooltip"]').tooltip();
                let builderList : any = [];
                let builder = {};
                $.each(response.data.log, function(index, string){
                    let splitBuilderString = string.builderWithId;
                    splitBuilderString = splitBuilderString.split(",");
                    $.each(splitBuilderString, function(index, value){
                        let string = value;
                        let result = string.split("-");
                        builder = {"id":result[0].trim(), "fullName":result[1].trim()}
                        builderList[result[0]] = builder;
                        builder = {};
                    });
                });
                // builderList = _this.arrayValues(builderList);
                // let tag : string = "";
                // $.each(builderList, function(index, value){
                //     if(value !== undefined)
                //         tag += "<a href='"+base_url+"Home/testProductivityReport/12/03/2020'>"+value.fullName+"</a> ";
                // });
                // $("#builder-list").html(tag);
            }
        });
    }

    private arrayValues(arrayObj) 
    {
      let tempObj = {};
      Object.keys(arrayObj).forEach((prop) => {
        if (arrayObj[prop]) { tempObj[prop] = arrayObj[prop]; }
      });
      return tempObj;
    }

    public _addBuildingStructure(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxLaborCost/add/'+_this._projectId,
            dataType  :"json",
            method : method,
            data:formData,
            beforeSend:function()
            {
                // let message = "Cargando formulario..";
                // if(formData)
                // {
                //     message = "Procesando.."
                // }
                // Swal({
                //     html: "<h3>"+message+"</h3>",
                //     allowOutsideClick:false,
                //     onBeforeOpen: () => {
                //         Swal.showLoading();
                //     }
                // });
            },
            success:function(response){
                if(response.success === 1 && !formData)
                {
                    _this.launchFormBuildingStructureForm(response, "Agregar Estructura");
                }
                else if(response.success === 1 && formData)
                {
					toastr.success(response.message, '', {'progressBar':true, "timeOut":15000});
					_this.loadManpower();
                    console.log(response);
                }
                else
				{
					bootbox.hideAll();
					toastr.error(response.message, '', {'progressBar':true,"timeOut":15000});
					// bootbox.alert(response.message);
				}
            }
        });
         
    }

    private launchFormBuildingStructureForm (response, formTitle)
    {
        this._loadViewTemplate = response.data.template;
        this._laborCostMasterDetail = response.data.laborCostMasterDetail;
        let $template = $("<div>"+this._loadViewTemplate+"</div>");
        let htmlSource = $template.find(response.data.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let data = {project:response.data.project};
        let html = template(data);
        let _this = this;
        bootbox.confirm({ 
                            title: formTitle,
                            message: html,
                            buttons: {
                                confirm: {
                                    label: 'Guardar',
                                    className: 'btn btn-primary'
                                },
                                cancel: {
                                    label: 'Cancelar',
                                    className: 'btn btn-danger'
                                }
                            },
                            callback: function(result){ 
                                if(result)
                                {
                                    let $formExisting = $("form[name=add-existing-structure]");
                                    let $formNew = $("form[name=add-new-structure]");
                                    let formSerialized = "";
                                    if($formExisting.is(":visible"))
                                    {
                                        formSerialized = $formExisting.serialize();
                                    }
                                    else
                                    {
                                        formSerialized = $formNew.serialize();
                                    }
                                    _this._addBuildingStructure(formSerialized);
                                }
                            }
                        });

        startSelect2LaborCost();
        let $inputMasked = $(".input-masked");
        if($inputMasked.length > 0)
        {
            $inputMasked.inputmask();
        }
    }

	private _datesToBlock(list)
	{
		let dates = [];
		$.each(list, function (index, dateRange) {
			let startDate = moment(dateRange.from_bld, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD');
			let endDate = moment(dateRange.to_bld, "YYYY-MM-DD hh:mm:ss").format('YYYY-MM-DD');
			let range = moment.range(startDate, endDate);
			let arrayMoment = Array.from(range.by('day'));
			$.each(arrayMoment, function(index, moment){
				dates.push(moment.format('YYYY-MM-DD'));
			});
		});
		return dates;
	}

    loadEventHandler()
    {
        let _this = this;
        if(this._structureUsageValidator !== null)
			this._structureUsageValidator.loadEventHandlers();
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
			let $tr = $(this).closest('tr');

			$(".table-error-message").addClass("hide");

            let $optionElement = $(e.params.data.element);
            let unitOfMeasurement = $optionElement.data('unit-of-measurement');
            let activity = $optionElement.data('activity');
            let execution = $optionElement.data('execution');
            let description = $optionElement.data('description');
            let unitPrice = $optionElement.data('unit-price');
            let quantity = typeof $optionElement.data('quantity') == 'number'? $optionElement.data('quantity'): $optionElement.data('quantity').replace(/,/g,"");
            let totalWorkedUp = typeof $optionElement.data('workedUp') == 'number'?$optionElement.data('workedUp'): $optionElement.data('workedUp').replace(/,/g,"");
			$tr.attr('data-quantity-to-use', quantity);
            $tr.find('.quantity-to-use').attr('data-parsley-max', parseFloat(quantity) - parseFloat(totalWorkedUp));
			$tr.attr('data-total-worked-up', totalWorkedUp);
			$tr.attr('data-unit-of-measurement', unitOfMeasurement);
            $optionElement.closest('tr').find('.activity').text(activity);
            $optionElement.closest('tr').find('.execution').text(execution);
            $optionElement.closest('tr').find('.description').text(description);
            $optionElement.closest('tr').find('.unit-of-measurement').text(unitOfMeasurement);
            $optionElement.closest('tr').find('.unit-price').val(unitPrice);
            $optionElement.closest('tr').find('.quantity').text(quantity);
        });

        $(document).on("change","select[name='builders[]']",function(){
            $("select[name='builders[]']").parsley().validate();
        });

        $(document).on("click",".remove-row", function(){
           $(this).closest("tr").remove();
           _this._structureUsageValidator.setIncomingProduction();

        });
        $(document).on("click",'[data-toggle="tooltip"]', function(e){
          e.preventDefault();
        });

        $(document).on("click", ".add-building-structure",function(e){
            e.preventDefault();
            _this._projectId = parseInt($(this).data('project-id'));
            _this._addBuildingStructure();
        });

        $(document).on("select2:select",'select.select2-labor-cost',function(e){
               console.log(e);
               let data = e.params.data;
               let $form = $("form[name=add-existing-structure]");
               $form.find("select[name=activity]").val(data.structure_activity);
               $form.find("select[name=execution]").val(data.structure_execution);
               // $form.find("input[name=quantity]").val(data.structure_quantity);
               $form.find("input[name=price]").val(data.structure_unit_price);
               console.log(data);
        });
    }
}
