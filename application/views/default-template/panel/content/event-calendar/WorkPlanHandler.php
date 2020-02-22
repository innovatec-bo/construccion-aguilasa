<script id="work-plan-table" type="text/x-handlebars-template">

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