<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Historial de ingresos</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
		?>
    </div>
    <?php
    if($allInternals)
    {
    ?>
    <div class="row">
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
                            <th>Ingreso</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $row = "";
                        foreach ($allInternals as $item) 
                        {
                            // dd($item);
                            $row .= "
                            <tr>
                                <td>{$item['code_mat']}</td>
                                <td>{$item['description_mat']}</td>
                                <td>{$item['quantity_int']}</td>
                                <td>{$item['unit_of_measurement_mat']}</td>
                                <td>{$item['detail_mst']}</td>
                                <td>{$item['detail_mte']}</td>
                                <td>{$item['createdon_int']}</td>
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
    <?php
    }
    ?>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->