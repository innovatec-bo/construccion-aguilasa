<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 06/06/2018
 * Time: 10:23 AM
 */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Diseño <em class="subtext"><?=$project["project_name_pro"]?></h1></em>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-10">
            <div class="tabbable">
                <ul class="nav nav-tabs wizard">
                    <?php
                    $navTab = '';
                    $i = 1;
                    $unsigned = '
                                <li class="completed">
                                    <a href="#step_unsigned" data-toggle="tab" aria-expanded="false" id="unsigned">Sin asignar</a>
                                </li>
                                ';

                    foreach ($statusList as $status)
                    {
                        $status = $status->toArray();
                        $class = $status["id_pst"] === $project["status_pro"]?"active":"";
                        $navTab .= '
                                <li class="'.$class.'">
                                    <a href="#step_'.$status["keyword_pst"].'" data-toggle="tab" aria-expanded="false" id="'.$status["keyword_pst"].'">'.$status["status_name_pst"].'</a>
                                </li>
                                ';
                        $i++;
                    }
                    echo $unsigned.$navTab;
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="tabbable">
                <a href="#next-step" data-toggle="tab" aria-expanded="false" id="next-step">Siguiente paso</a>
            </div>
        </div>
        <div class="col-md-9">
            <section>
                <div class="wizard">
                    <form role="form" name="status-management" data-parsley-validate>
                        <input type="hidden" value="<?=$project["id_pro"]?>" name="project-id">
                        <div class="tab-content">
                            <?php
                            $tapPane = '';
                            $i = 1;
                            foreach ($statusList as $status)
                            {
                                $status = $status->toArray();
                                $class = $status["id_pst"] === $project["status_pro"]?"active":"";
                                $tapPane .= '
                                <div class="tab-pane '.$class.'" role="tabpanel" id="step_'.$status["keyword_pst"].'">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Formulario de '.$status["status_name_pst"].'
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12 status-content">';
                                                $data["status"] = $status["keyword_pst"];
                                    $tapPane .= $this->load->view("default-template/panel/content/project-status/status-management-views", $data,TRUE);
                                    $tapPane .=
                                                '</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                ';
                                        $tapPane .= '                   
                                                    <button type="button" class="btn btn-primary save-status" data-status-id="'.$status["id_pst"].'" data-status-keyword="'.$status["keyword_pst"].'">Guardar</button>
                                                ';
                                    $tapPane .= '
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                </div>
                                ';
                                $i++;
                            }
                            echo $tapPane;
                            ?>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Historial
                </div>
                <div class="panel-body" style="overflow: auto;height: 50vh;">
                    <h6>ESTAQUEADO</h6>
                    <blockquote>
                        <dl>
                            <dt>Fecha</dt>
                            <dd>16/07/2018</dd>
                            <dt>Responsable</dt>
                            <dd>Fulano de tal</dd>
                            <dt>Comentario</dt>
                            <dd>Ninguno</dd>
                        </dl>
                    </blockquote>
                    <h6>DIGITALIZACION</h6>
                    <blockquote>
                        <dl>
                            <dt>Fecha</dt>
                            <dd>16/07/2018</dd>
                            <dt>Responsable</dt>
                            <dd>Fulano de tal</dd>
                            <dt>Comentario</dt>
                            <dd>Ninguno</dd>
                        </dl>
                    </blockquote>
                    <h6>DIGITALIZACION</h6>
                    <blockquote>
                        <dl>
                            <dt>Fecha</dt>
                            <dd>16/07/2018</dd>
                            <dt>Responsable</dt>
                            <dd>Fulano de tal</dd>
                            <dt>Comentario</dt>
                            <dd>Ninguno</dd>
                        </dl>
                    </blockquote>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view("default-template/panel/content/project-status/ht-stakes-project");
?>