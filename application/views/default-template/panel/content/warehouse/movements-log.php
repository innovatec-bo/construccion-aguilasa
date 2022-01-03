<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Historial de movimientos</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
		?>
    </div>
	<div class="row">
        <div class="col-md-12">
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" name="project-code" class="form-control" placeholder="Codigo de proyecto">
                </div>
                <button type="submit" class="btn btn-default">Ver</button>
            </form>
        </div>
	</div>
    <?php
    if($log)
    {
    ?>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center"><?=$projectCode?></h2>
            <div class="text-center"><em>Se encontraron <?=count($log)?> movimiento(s)</em></div>
        <ul class="timeline">
            <?php
                $html = '';
                $i = 0;
                foreach ($log as $item) 
                {
                    $class = $i%2 != 0?'timeline-inverted':'';
                    $html .= '
                    <li class="'.$class.'">
                        <div class="timeline-badge"><i class="fa fa-file-o"></i>
                        </div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">'.$item['name_mqt'].'</h4>
                                <p>
                                    <small class="text-muted"><i class="fa fa-clock-o"></i> '.$item['entry_date_msu'].'</small>
                                </p>
                                <p>
                                    <strong>Fiscal:</strong> '.$item['fiscal_full_name'].'<br>
                                    <strong>Constructor:</strong> '.$item['builder_full_name'].'<br>
                                    <strong>Codigo de movimiento:</strong> '.$item['id_msu'].'<br>
                                    <strong>Numero correlativo:</strong> '.$item['correlative_counter_msu'].'<br>
                                </p>
                            </div>
                            <!-- <div class="timeline-body">
                                <p><a href="javascript:void(0)">Ver lista de materiales</a></p>
                            </div> -->
                        </div>
                    </li>
                    ';
                    $i++;
                }
                echo $html;
            ?>
        </ul>
        </div>
    </div>
    <?php
    }
    ?>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
