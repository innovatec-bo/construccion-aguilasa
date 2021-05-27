<?php
$tension = [
		1 => "Media",
		2 => "Baja",
		3 => "Transformador",
		4 => "Indefinido"
]
?>
<!---->
<div class="container-fluid box-shadow-2 <?=$visiblePrintBlock?>" id="invoice-template">
	<div class="row">
		<div class="col-md-12 hidden-print">
			<button type="button" class="btn btn-outline btn-default my-1" onclick="window.print();"> <i class="fa fa-print"></i></button>
		</div>
		<div class="col-xs-12">
			<div class="invoice-title">
				<h2><?=$viewTitle?></h2><h3 class="pull-right">C&oacute;digo: <?=$materialSummary['summary_id']?></h3>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<address>
						<strong>Fiscal:</strong><br>
						<?=$materialSummary['fiscal_full_name']?><br>
					</address>
				</div>
				<div class="col-xs-6 text-right">
					<address>
						<strong>Constructor:</strong><br>
						<?=$materialSummary['builder_full_name']?><br>
					</address>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<address>
						<strong>Proyecto:</strong><br>
						<?=$materialSummary['project_code']?><br>
						<?=$summaryType->getName()." Nro. ".$materialSummary['summary_correlative_counter']?>

					</address>
				</div>
				<div class="col-xs-6 text-right">
					<address>
						<strong>Fecha de solicitud:</strong><br>
						<?=$materialSummary['summary_entry_date']?><br><br>
					</address>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Detalle</strong></h3>
				</div>
				<div class="panel-body">
					<table class="table table-condensed">
						<thead>
						<tr>
							<td><strong>COD</strong></td>
							<td class="text-center"><strong>Descripci&oacute;n</strong></td>
							<td class="text-right"><strong>Cantidad</strong></td>
							<td class="text-right"><strong>Estado</strong></td>
							<td class="text-right"><strong>Tension</strong></td>
						</tr>
						</thead>
						<tbody>
						<?php
						$rows = '';
						foreach ($materialList as $row)
						{
							$tensionName = $tension[$row['material_tension_id']]??"Indefinido";
							$rows .= "
							<tr>
								<td class='text-center'>{$row['material_code']}</td>
								<td class='text-left'>{$row['material_description']}</td>
								<td class='text-right'>{$row['material_quantity']} {$row['material_unit_of_measurement']}</td>
								<td class='text-right'>{$row['material_status_code']}</td>
								<td class='text-right'>{$tensionName}</td>
							</tr>
							";
						}
						echo $rows;
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row my-3 visible-print">
		<div class="col-xs-offset-1 col-xs-5 text-center mt-3">
			<span style="border-top: 1px solid gray;padding: 5px 40px 5px 40px;">Entregue Conforme</span>
		</div>

		<div class="col-xs-4 text-center mt-3">
			<span style="border-top: 1px solid gray;padding: 5px 40px 5px 40px;">Recibi Conforme</span>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
