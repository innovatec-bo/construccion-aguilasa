<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-modal-add-form" type="text/x-handlebars-template">
    <form role="form" name="modal-blocked-log-date-range-add-form" method="post" data-parsley-validate>
        <input type="hidden" name="id" value="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>A&ntilde;o</label>
					<select class="form-control input-sm" name="year">
						<?php
						$html = '';
						foreach(range(date("Y"), 2017) as $year)
						{
							$html .= '<option value="'.$year.'">'.$year.'</option>';
						}
						echo $html;
						?>
<!--						<option value="2020">2020</option>-->
<!--						<option value="2019">2019</option>-->
<!--						<option value="2018">2018</option>-->
<!--						<option value="2017">2017</option>-->
					</select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Mes</label>
					<select class="form-control input-sm" name="month">
						<option value="01">Enero</option>
						<option value="02">Febrero</option>
						<option value="03">Marzo</option>
						<option value="04">Abril</option>
						<option value="05">Mayo</option>
						<option value="06">Junio</option>
						<option value="07">Julio</option>
						<option value="08">Agosto</option>
						<option value="09">Septiembre</option>
						<option value="10">Octubre</option>
						<option value="11">Noviembre</option>
						<option value="12">Diciembre</option>
					</select>
                </div>
            </div>
        </div>
    </form>
</script>
