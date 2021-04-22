<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-modal-add-form" type="text/x-handlebars-template">
    <form role="form" name="modal-material-add-form" method="post" data-parsley-validate>
        <input type="hidden" name="id" value="">
        <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>C&oacute;digo</label>
					<input class="form-control input-sm" name="code" required>
				</div>
			</div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Unidad de medida</label>
					<select class="form-control input-sm" required name="unit-of-measurement">
						<option value="Pza">Pza</option>
						<option value="M">M</option>
					</select>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label>Descripci&oacute;n</label>
					<textarea class="form-control input-sm" name="description" required rows="2"></textarea>
				</div>
			</div>
		</div>
    </form>
</script>
