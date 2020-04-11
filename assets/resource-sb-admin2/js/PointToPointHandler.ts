// export {};
declare let Handlebars: any;
declare let blockArea: any;
declare let base_url: any;
declare let $: any;
declare let Object: any;
declare let window: any;
declare let Swal: any;
declare let bootbox: any;
declare let toastr : any;

class PointToPointHandler
{
    private _projectId: number;
    private _pointId: number;
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
            url : base_url + 'panel/AjaxProject/addPointToPointProgress/'+_this._projectId+"/"+_this._pointId,
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
                Swal.close();
                if(response.success === 1 && !formData)
                {
                    _this.launchForm(response, "Registrar avance en punto "+response.data.point.point_label);
                }
                else if(response.success === 1 && formData)
                {
                    toastr.success(response.message, '', {'progressBar':true});
                    _this.loadManpowerLog();
                    _this.loadBuildingPoints();
                }
                else
                {
                    Swal({ title:'', html:response.message, type:"error"});
                }
            }
        });
    }

    private _addMassiveProgress(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxProject/addMassivePointToPointProgress/'+_this._projectId,
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
                Swal.close();
                if(response.success === 1 && !formData)
                {
                    _this.launchFormMassiveProgress(response, "Completar puntos");
                }
                else if(response.success === 1 && formData)
                {
                    toastr.success(response.message, '', {'progressBar':true});
                    _this.loadManpowerLog();
                    _this.loadBuildingPoints();
                }
                else
                {
                    Swal({ title:'', html:response.message, type:"error"});
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
        let data = {point:response.data.point, builders:response.data.builders, response:response};
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
                let $form = $("form[name=point-to-point-progress-form]");
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
                let $form = $("form[name=point-to-point-progress-form]");
                _this.add($form.serialize());
            }
        });
        let date = new Date();
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            defaultDate: date,
            format: 'DD-MM-YYYY'
        });
        $(".select2-builders").select2({dropdownCssClass: "dd-select2-builders"});
        this._startSelect2();
        $(".input-masked").inputmask('decimal',{min:1, max:999999, groupSeparator: ',', autoGroup: true});
    }

    private launchFormMassiveProgress(response, formTitle)
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
        let data = {point:response.data.point, builders:response.data.builders, response:response};
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
                let $form = $("form[name=point-to-point-massive-progress-form]");
                if(!$form.parsley().isValid())
                {
                    $form.parsley().validate();
                    return false;
                }
            },
        }).then((result) => {
            if (result.value)
            {
                let $form = $("form[name=point-to-point-massive-progress-form]");
                _this._addMassiveProgress($form.serialize());
            }
        });
        let date = new Date();
        $('.date-time-picker').datetimepicker({
            ignoreReadonly: true,
            defaultDate: date,
            format: 'DD-MM-YYYY'
        });
        $(".select2-builders").select2({dropdownCssClass: "dd-select2-builders"});
        this._startSelect2();
        $(".input-masked").inputmask('decimal',{min:1, max:999999, groupSeparator: ',', autoGroup: true});
        if($('#select2-points').length > 0)
        {
            $('#select2-points').select2();
        }
    }

    public loadBuildingPoints()
    {
        let _this = this;
        let $buildingPointsContent = $("#building-points");
        blockArea($buildingPointsContent);
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
                if(response.data.buildingPoints.length > 0)
                    $buildingPointsContent.html(html);
                else
                    $buildingPointsContent.html("<div class='col-md-9'><h1>No se encontraron puntos</h1></div>");
                if(response.data.buildingPoints.length <= 7)
                {
                    $('.add-massive-point-to-point-progress').removeClass('hide');
                }
            }
        });
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
                return '<a href="#" class="btn btn-default btn-block add-building-structure" data-project-id="'+_this._projectId+'">Agregar estructura</a>';
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
            }
        });
    }

    loadEventHandler()
    {
        let _this = this;

        $(document).on("click", ".add-point-to-point-progress", function(e){
            e.preventDefault();
            _this._pointId = parseInt($(this).data("point-id"));
            _this.add();
        });

        $(document).on("click", ".add-massive-point-to-point-progress", function(e){
            e.preventDefault();
            _this._pointId = parseInt($(this).data("point-id"));
            _this._addMassiveProgress();
        });

        $(document).on("change","select[name='builders[]']",function(){
            $("select[name='builders[]']").parsley().validate();
        });

        $(document).on("click",'[data-toggle="tooltip"]', function(e){
          e.preventDefault();
        });
    }
}