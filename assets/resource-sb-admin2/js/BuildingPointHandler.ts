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

class BuildingPointHandler
{
	private _projectId : number;
    private _buildingPointId : number;
	private _masterTemplate : any;

    constructor(private projectID: number)
    {
		this._projectId = projectID;
    }
    
    public add(formData?)
    {
        let _this = this;
        let method = !formData?"GET":"POST";
        $.ajax({
            url : base_url + 'panel/AjaxBuildingPoint/add/'+_this._projectId,
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
                    _this._launchForm(response, 'Crear punto de construccion');
                }
                else if(response.success === 1 && formData)
                {
                    toastr.success(response.message, '', {'progressBar':true});
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
            url : base_url + 'panel/AjaxWorkPlan/edit/'+_this._buildingPointId,
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
                    url : base_url + 'panel/AjaxWorkPlan/delete/'+_this._buildingPointId,
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
        let htmlSource = _this._masterTemplate.find(response.data.templateName).html();
        let template = Handlebars.compile(htmlSource);
        let html = template({buildingPoint:response.data.buildingPoint});
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
            customClass:"modal-building-point-form",
            width:'100%',
            preConfirm: () => {

                let $form = $("form[name=building-point-form]");
                if(!$form.parsley().isValid())
                {
                    $form.parsley().validate();
                    return false;
                }
            },
        }).then((result) => {
            if (result.value)
            {
                let $form = $("form[name=building-point-form]");
                let buildingPointId = parseInt($form.find("input[name=building-point-id]").val());
                if(isNaN(buildingPointId))
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

    public loadEventHandlers()
    {
        let _this    = this;

		$(document).on("click", ".add-building-point", function(e){
			e.preventDefault();
			_this.add();
		});

        $(document).on("click", ".edit-work-plan", function(e){
            e.preventDefault();
            let workPlanId = $(this).data('work-plan-id');
            _this._buildingPointId = parseInt(workPlanId);
            _this.edit();
        });

        $(document).on("click", ".delete-work-plan", function(e){
            e.preventDefault();
            let workPlanId = $(this).data('work-plan-id');
            _this._buildingPointId = parseInt(workPlanId);
            _this.delete();
        });
    }
}
