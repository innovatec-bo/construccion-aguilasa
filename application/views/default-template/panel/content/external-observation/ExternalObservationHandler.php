<script id="ht-fix-external-observation" type="text/x-handlebars-template">
	<form role="form" name="fix-external-observation" data-parsley-validate="">
		<input type="hidden" value="{{externalObservationId}}" name="external-observation-id">
		<div class="form-group mb-1">
			<div class="input-group date date-time-picker-popover">
				<input name="fixed-date" readonly="" class="form-control" required="">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<div class="form-group mb-1">
			<textarea class="form-control input-sm" name="fix-detail" rows="3" required placeholder="Ingrese un detalle del correcci&oacute;n"></textarea>
		</div>
		<button type="submit" class="btn btn-primary btn-xs">Solucionado <i class="fa fa-check fa-fw"></i></button>
		<button type="button" class="btn btn-danger btn-xs close-popover">Cancelar <i class="fa fa-times fa-fw"></i></button>
	</form>
</script>
