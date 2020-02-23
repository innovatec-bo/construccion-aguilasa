<script id="work-plan-edit-form" type="text/x-handlebars-template">
  <div class="row">
      <div class="col-md-3">
          <div class="form-group">
              <label>Fiscal</label>
              <select class="form-control">
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
              <select class="form-control">
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
          <button type="button" class="btn btn-info btn-xs" data-toogle='tooltip' data-placement='top' data-original-title="Nueva fila"><i class="fa fa-plus"></i></button>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12">
          <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead>
                      <tr>
                          <th rowspan="3" class="text-center vertical-align">PROYECTO</th>
                          <th rowspan="3" class="text-center vertical-align">LUGAR</th>
                          <th class="change-week previous-week" data-toggle='tooltip' data-placement='top' data-original-title="SEMANA ANTERIOR" data-container="body"><<</th>
                          <th colspan="5" class="table-month vertical-align">FEBRERO</th>
                          <th class="change-week next-week" data-original-title='SIGUIENTE SEMANA' data-placement='top' data-container="body" data-toggle='tooltip'>>></th>
                          <th rowspan="3" class="text-center vertical-align">TRABAJO</th>
                          <th rowspan="3" class="text-center vertical-align">OBSERVACION</th>
                          <th rowspan="3" class="text-center vertical-align">X</th>
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
                  <tbody>
                      {{#each workPlan.projectList}}
                        <tr data-project-id='{{projectId}}'>
                          <td>{{projectCode}}</td>
                          <td>{{projectAddress}}</td>
                          <td class="date-to-work"></td>
                          <td class="date-to-work"></td>
                          <td class="date-to-work"></td>
                          <td class="date-to-work"></td>
                          <td class="date-to-work"></td>
                          <td class="date-to-work"></td>
                          <td class="date-to-work"></td>
                          <td><input class="table-input-work-plan" placeholder="Especifique el trabajo" type="text" name="work"></td>
                          <td><input class="table-input-work-plan" placeholder="Observacion" type="text" name="observation"></td>
                          <td class="text-center delete-row"><i class="fa fa-times"></i></td>
                        </tr>  
                      {{/each}}
                      <tr>
                          <td>RD.02.2222</td>
                          <td>VIADUCTO COTOCA</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>Maniobra para recableo de linea MT.</td>
                          <td>Coordinacion con Paul Rojas y Dario Flores</td>
                          <td class="text-center">x</td>
                      </tr>
                      <tr>
                          <td>RD.02.2222</td>
                          <td>VIADUCTO COTOCA</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>Maniobra para recableo de linea MT.</td>
                          <td>Coordinacion con Paul Rojas y Dario Flores</td>
                          <td class="text-center">x</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>    
  </div>
  <div class="row">
      <div class="col-lg-12">
          <button type="button" class="btn btn-primary">Guardar</button>
      </div>
  </div>
</script>
<script id="work-plan-table" type="text/x-handlebars-template">
    <table class='table table-striped table-bordered work-plan-table'>
        <thead>
          <tr>
            <th class='shadow-right'>Proyecto</th>
            {{#each days}}
            	<th class='text-center days-width'>{{this}}</th>
            {{/each}}
            <th class='text-center shadow-left'>Total</th>
          </tr>
        </thead>
        <tbody>
        	{{#each projects}}
              	<tr>
	                <td class='shadow-right'>{{code}}</td>
	                {{#each workPlan}}
	                	<td class='cell-date text-center' data-date='{{date}}' date-project-code="{{../code}}">
	                		{{#ifCond workDate "==" 1}}
	                			<i class="fa fa-check"></i>
	                		{{/ifCond}}
	                		{{#ifCond workDate "!=" 1}}
	                			
	                		{{/ifCond}}
	                	</td>
	                {{/each}}
	                <td class='text-center shadow-left'>{{totalDates}}</td>
              	</tr>
          	{{/each}}
        </tbody>
  	</table>  
</script>
<script id="form-add" type="text/x-handlebars-template">
  
</script>