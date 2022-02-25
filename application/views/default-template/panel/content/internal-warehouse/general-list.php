<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Materiales Igresados en almacen interno</h1>
            <a class="btn btn-info hidden-print pull-right" href='javascript:void(0)' onclick='window.print();'><i class="fa fa-print fa-fw"></i>Imprimir</a>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
		?>
    </div>
    <?php
    if($grouped)
    {
    ?>
    <div class="row mb-3">
        <div class="col-md-12">
        <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="user-index">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>C&oacute;digo</th>
                            <th>Descripcion</th>
                            <th>Cantidad<br>ingresada</th>
                            <th>Unidad de<br>medida</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $row = "";
                        $i = 1;
                        foreach ($grouped as $item) 
                        {
                            $row .= "
                                <tr>
                                    <td>{$i}</td>
                                    <td>{$item['code_mat']}</td>
                                    <td>{$item['description_mat']}</td>
                                    <td>{$item['total']}</td>
                                    <td>{$item['unit_of_measurement_mat']}</td>
                                </tr>
                            ";
                            $i++;
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