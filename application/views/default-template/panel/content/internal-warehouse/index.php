<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Operaciones de ingreso</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
		?>
    </div>
    <?php
    if($allOperations)
    {
    ?>
    <div class="row">
        <div class="col-md-12">
        <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="user-index">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $row = "";
                        foreach ($allOperations as $item) 
                        {
                            $carbonDate = new Carbon\Carbon($item->entry_date_iwo);
                            $diffForHumans = $carbonDate->locale('Es')->diffForHumans();
                            $row .= "
                            <tr>
                                <td>{$item->id_iwo}</td>
                                <td>{$item->detail_iwo}</td>
                                <td>{$item->entry_date_iwo} (".$diffForHumans.")</td>
                                <td>
                                    <a href='".base_url('panel/InternalWarehouse/show/'.$item->id_iwo)."' target='_blank'>Ver</a>
                                </td>
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
