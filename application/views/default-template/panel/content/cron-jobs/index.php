<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tareas Programadas/Cron Jobs</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
		<div class="col-md-12">
			<div class="alert alert-info">
				<i class="fa fa-info-circle"></i>
				La presente vista incorpora una lista de algunos cronjobs que se ejecutan de forma programada.
			</div>
		</div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="process-lines-enabled-index">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Minuto</th>
                        <th>Hora</th>
                        <th>Fecha</th>
                        <th>Mes</th>
                        <th>Dia</th>
                        <th>Tarea</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $html = "";
                        $i = 1;
                        foreach ($cronJobs as $row) 
                        {
                            $html .= "
                            <tr>
                                <td>{$i}</td>
                                <td class='text-center'>{$row['minute']}</td>
                                <td class='text-center'>{$row['hour']}</td>
                                <td class='text-center'>{$row['day']}</td>    
                                <td class='text-center'>{$row['month']}</td>
                                <td class='text-center'>{$row['weekday']}</td>
                                <td class='text-center'>{$row['detail']}</td>
                                <td>
                                    <button type='button' class='btn btn-primary btn-sm'>Ejecutar</button>
                                </td>
                            </tr>    
                            ";
                            $i++;
                        }
                        echo $html;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->