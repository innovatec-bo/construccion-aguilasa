<script id="work-plan-add-form" type="text/x-handlebars-template">
  <form name="work-plan-form" data-parsley-validate>
    <input type="hidden" name="work-plan-id" value="">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Fiscal</label>
                <select class="form-control" name='fiscal-id' required>
                    <option></option>
                    {{#each fiscalList}}
                      <option value='{{id}}'>{{fullName}}</option>
                    {{/each}}
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Constructor</label>
                <select class="form-control" name='builder-id' required>
                    <option></option>
                    {{#each builderList}}
                      <option value='{{id}}'>{{fullName}}</option>
                    {{/each}}
                </select>
            </div>
        </div>
        <div class="col-md-11"> 
            <button type="button" class="btn btn-info btn-xs add-row" data-toogle='tooltip' data-placement='top' data-original-title="Nueva fila"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    {{> work-plan-table workplan=workplan}}
  </form>
</script>
<script id="work-plan-edit-form" type="text/x-handlebars-template">
  <form name="work-plan-form" data-parsley-validate>
    <input type="hidden" name="work-plan-id" value="{{workPlan.id}}">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Fiscal</label>
                <select class="form-control" name='fiscal-id' required>
                    <option></option>
                    {{#each fiscalList}}
                      {{var "optionSelected" ""}}
                      {{#ifCond id "==" ../workPlan.fiscalId}}
                        {{var "optionSelected" "selected"}}
                      {{/ifCond}}
                      <option value='{{id}}' {{optionSelected}}>{{fullName}}</option>
                    {{/each}}
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Constructor</label>
                <select class="form-control" name='builder-id' required>
                    <option></option>
                    {{#each builderList}}
                      {{var "optionSelected" ""}}
                      {{#ifCond id "==" ../workPlan.builderId}}
                        {{var "optionSelected" "selected"}}
                      {{/ifCond}}
                      <option value='{{id}}' {{optionSelected}}>{{fullName}}</option>
                    {{/each}}
                </select>
            </div>
        </div>
        <div class="col-md-11"> 
            <button type="button" class="btn btn-info btn-xs add-row" data-toogle='tooltip' data-placement='top' data-original-title="Nueva fila"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    {{> work-plan-table workplan=workplan}}
  </form>
</script>
<script id="work-plan-table" type="text/x-handlebars-template">
  <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <em class='table-error-message hidden'>Debe agregar proyectos. Si agrega una fila y no selecciona un proyecto, esa fila no sera registrada en el sistema.</em>
                <table class="table table-striped table-bordered table-hover work-plan-table">
                    <thead>
                        <tr>
                            <th rowspan="3" class="text-center vertical-align">PROYECTO</th>
                            <th rowspan="3" class="text-center vertical-align">LUGAR</th>
                            <th class="change-week previous-week" data-toggle='tooltip' data-placement='top' data-original-title="SEMANA ANTERIOR" data-container="body"><<</th>
                            <th colspan="5" class="table-month vertical-align">FEBRERO</th>
                            <th class="change-week next-week" data-original-title='SIGUIENTE SEMANA' data-placement='top' data-container="body" data-toggle='tooltip'>>></th>
                            <th rowspan="3" class="text-center vertical-align">TRABAJO</th>
                            <th rowspan="3" class="text-center vertical-align">OBSERVACION</th>
                            <th rowspan="3" class="text-center vertical-align" width='25px'>X</th>
                        </tr>
                        <tr>
                            <th class="width-30 text-center table-days">L</th>
                            <th class="width-30 text-center table-days">M</th>
                            <th class="width-30 text-center table-days">M</th>
                            <th class="width-30 text-center table-days">J</th>
                            <th class="width-30 text-center table-days">V</th>
                            <th class="width-30 text-center table-days">S</th>
                            <th class="width-30 text-center table-days">D</th>
                        </tr>
                        <tr>
                            <th class="width-30 text-center table-dates"></th>
                            <th class="width-30 text-center table-dates"></th>
                            <th class="width-30 text-center table-dates"></th>
                            <th class="width-30 text-center table-dates"></th>
                            <th class="width-30 text-center table-dates"></th>
                            <th class="width-30 text-center table-dates"></th>
                            <th class="width-30 text-center table-dates"></th>
                        </tr>
                    </thead>
                    <tbody id='project-list-content'>
                        {{#each workPlan.projectList}}
                          {{> work-plan-table-row project=this}}
                        {{/each}}
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
</script>
<script id="work-plan-table-row" type="text/x-handlebars-template">
  <tr data-row-index="{{index}}" data-project-id='{{projectId}}'>
    <td width="110px" class='additional-data'>
      <select class="form-control input-sm select2 project" data-select-index="{{index}}">
        <option value="{{projectId}}">{{projectCode}}</option>
      </select>
    </td>
    <td class='project-address'>{{projectAddress}}</td>
    <td class="date-to-work"></td>
    <td class="date-to-work"></td>
    <td class="date-to-work"></td>
    <td class="date-to-work"></td>
    <td class="date-to-work"></td>
    <td class="date-to-work"></td>
    <td class="date-to-work"></td>
    <td class='additional-data'><input class="table-input-work-plan detail" placeholder="Especifique el trabajo" type="text" name="work" value="{{workDetail}}"></td>
    <td class='additional-data'><input class="table-input-work-plan observation" placeholder="Observacion" type="text" name="observation" value="{{workObservation}}"></td>
    <td class="text-center delete-row"><i class="fa fa-times"></i></td>
  </tr>
</script>
<script id="work-plan-summary-table" type="text/x-handlebars-template">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <td rowspan="2" width="120px">{{totalDays}}</td>
                {{#each arrayMoment}}
                    <td class="width-30 text-center table-days"></td>
                {{/each}}
            </tr>
            <tr>
                {{#each arrayMoment}}
                    <td class="width-30 text-center table-dates"></td>
                {{/each}}
            </tr>
            </thead>
            <tbody>
            {{#each workPlanSummary}}
                <tr class="success">
                    <td colspan="{{../totalDays}}" class=""><strong>{{fullName}}</strong></td>
                    <td></td>
                </tr>
                {{#each builderList}}
                    <tr class="info">
                        <td colspan={{../../totalDays}}" class="">&nbsp<i class="fa fa-user fa-fw"></i> {{fullName}}</td>
                        <td></td>
                    </tr>
                    {{#each projectList}}
                        <tr data-fiscal-id>
                            <td>&nbsp&nbsp- {{code}}</td>
                            {{#each ../../../arrayMoment}}
                                <td class="work-date"></td>
                            {{/each}}
                        </tr>
                    {{/each}}
                {{/each}}
            {{/each}}
            </tbody>
        </table>
    </div>
</script>