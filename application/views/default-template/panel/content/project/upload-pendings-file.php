<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Cargar archivo de pendientes</h1>
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
            <form name="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Archivo de pendientes</label>
                    <input type="file" name="pendings-file">
                </div>
                <div class="form-group">
                    <label>Operacion</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="create-pending-summary" value="1">Crear lista de pendientes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="create-pending-summary" value="0" checked>Previsualizar pendientes
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Procesar</button>
            </form>
        </div>
		<div class="col-md-12">
        <div class="panel-group">
            <?php
            $preview = $preview??[];
            $totalGeneral = 0;
            $i = 0;
            foreach($preview as $project)
            {
                $totalInProject = count($project['materials']);
                $totalGeneral += $totalInProject;
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$i?>" aria-expanded="false" class="collapsed">
                            <?=$project['project']?> (<?=$totalInProject?>)
                        </a>
                    </h4>
                </div>
                <div id="collapse-<?=$i?>" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body p-1">
                    <table class="table table-bordered table-condensed mb-0">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Texto breve del material</th>
                                <th>Ctd.nec.</th>
                                <th>Ctd.dif.</th>
                                <th>Lote</th>
                                <th>UMB</th>
                                <th>Tension</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($project['materials'] as $material)
                        {
                        ?>
                        <tr>
                            <td class="text-center text-info"><?=$material['code']?></td>
                            <td class="text-left text-info"><?=$material['detail']?></td>
                            <td class="text-center text-info"><?=$material['nec']?></td>
                            <td class="text-center text-info"><?=$material['dif']?></td>
                            <td class="text-center text-info"><?=$material['lote']?></td>
                            <td class="text-center text-info"><?=$material['umb']?></td>
                            <td class="text-center text-info"><?=$material['tension']?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <?php
            $i++;
            }
            ?>
            </div>
		</div>
	</div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
