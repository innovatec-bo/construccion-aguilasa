<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Resumen de operacion</h1>
            <a class="btn btn-info hidden-print pull-right" href='javascript:void(0)' onclick='window.print();'><i class="fa fa-print fa-fw"></i>Imprimir</a>
        </div>
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
		?>
    </div>
    <?php
    if($materials)
    {
    ?>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>ID</label>
                <div class="input-group date date-time-picker input-group-sm">
                    <input name="entry-date" value="<?=$operation->getId()?>" readonly="" required="" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        if (is_numeric($operation->getOperationTypeId())) 
        {
        ?>
        <div class="col-md-3">
            <div class="form-group">
				<label>Tipo de operacion</label>
				<div class="form-group">
					<input type="text" class="form-control" autocomplete="off" value="<?=$operation->operationType()->getName()?>" readonly>
				</div>
			</div>
        </div>
        <?php
        }
        if (is_numeric($operation->getProjectId())) 
        {
        ?>
        <div class="col-md-3">
            <div class="form-group">
				<label>Proyecto</label>
				<div class="form-group">
					<input type="text" class="form-control" autocomplete="off" value="<?=$operation->project()->getCode()?>" readonly>
				</div>
			</div>
        </div>
        <?php
        }
        if (is_numeric($operation->getFiscalId())) 
        {
        ?>
        <div class="col-md-3">
            <div class="form-group">
				<label>Fiscal</label>
				<div class="form-group">
					<input type="text" class="form-control" autocomplete="off" value="<?=$operation->fiscal()->getFullName()?>" readonly>
				</div>
			</div>
        </div>
        <?php
        }
        if (is_numeric($operation->getBuilderId()))
        {
        ?>
        <div class="col-md-3">
            <div class="form-group">
				<label>Constructor</label>
				<div class="form-group">
					<input type="text" class="form-control" autocomplete="off" value="<?=$operation->builder()->getFullName()?>" readonly>
				</div>
			</div>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>Fecha</label>
				<div class="input-group date date-time-picker input-group-sm">
                    <?php
                    $carbonDate = new Carbon\Carbon($operation->getEntryDate());
                    ?>
					<input name="entry-date" value="<?=$carbonDate->format('d-m-Y H:i:s')?>" readonly="" required="" class="form-control" data-parsley-errors-container="#error-entry-date">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<div id="error-entry-date"></div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<label>Detalle</label>
				<div class="form-group">
					<input type="text" class="form-control" name="detail" autocomplete="off" value="<?=$operation->getDetail()?>">
				</div>
			</div>
		</div>
	</div>
    <div class="row mb-3">
        <div class="col-md-12">
        <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="user-index">
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Descripcion</th>
                            <th>Cantidad<br>ingresada</th>
                            <th>Unidad de<br>medida</th>
                            <th>Status</th>
                            <th>Tension</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $row = "";
                        foreach ($materials as $item) 
                        {
                            $row .= "
                            <tr>
                                <td>{$item['code_mat']}</td>
                                <td>{$item['description_mat']}</td>
                                <td>{$item['quantity_int']}</td>
                                <td>{$item['unit_of_measurement_mat']}</td>
                                <td>{$item['detail_mst']}</td>
                                <td>{$item['detail_mte']}</td>
                            </tr>
                            ";
                        }
                        echo $row;
                    ?>  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="visible-print-inline">
        <span style="width: 300px;margin-left:25%">
            Entregue conforme
        </span>
        <span style="width: 300px;margin-left: 100px">
            Recibi conforme
        </span>
    </div>
    <?php
    }
    ?>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
