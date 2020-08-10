<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 10/05/2019
 * Time: 11:50 AM
 */
?>
<script id="ht-available-builders-list" type="text/x-handlebars-template">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">Constructores</h3>
		</div>
		<div class="panel-body p-0">
			<div class="list-group mb-0 perfect-scroll-bar" data-scroll-bar-identifier="available-builders" id="builder-list" style="height: 300px !important;position: relative;border: 1px solid #dddddd;">
				{{#each data.availableBuilders}}
					<li class="list-group-item" data-builder-id='{{builder_id}}'>{{builder_fullname}}</li>
				{{/each}}
			</div>
		</div>
	</div>
</script>
<script id="ht-distribution-list" type="text/x-handlebars-template">
	{{#each data.distributionList}}
		<div class="col-md-4">
			<div class="panel panel-primary fiscal-panel" data-fiscal-id="{{id}}">
				<div class="panel-heading">
					<h3 class="panel-title">{{fullName}}</h3>
				</div>
				<div class="panel-body p-0">
					<div class="list-group mb-0 builder-list-group perfect-scroll-bar" data-scroll-bar-identifier="assigned-builders-{{id}}" style="height: 150px !important;position: relative;border: 1px solid #dddddd;">
						{{#each builders}}
							<li class="list-group-item" data-builder-id='{{id}}'>{{fullName}}</li>
						{{/each}}
					</div>
				</div>
			</div>
		</div>
	{{/each}}
</script>
