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
            <h1 class="page-header">Diseño</h1>
            <dl>
                <dt>Proyecto</dt>
                <dd><?=$project["code_pro"]?></dd>
                <dt>Estado</dt>
                <?php
                $status = "None";
                if(isset($statusList[$project["status_pro"]]))
                {
                    $status = $statusList[$project["status_pro"]];
                    $status = $status->toArray();
                    $status = $status["status_name_pst"];
                }

                ?>
                <dd><?=$status?></dd>
                <dt>Sistema</dt>
                <dd><?=isset($projectSystems[$project["system_pro"]])?$projectSystems[$project["system_pro"]]:""?></dd>
            </dl>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <section>
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <?php
                            $navTab = '';
                            $i = 1;
                            foreach ($statusList as $status)
                            {
                                $status = $status->toArray();
                                $class = $status["id_pst"] === $project["status_pro"]?"active":"";
                                $navTab .= '
                                <li role="presentation" class="'.$class.'">
                                    <a href="#step_'.$status["keyword_pst"].'" data-toggle="tab" aria-controls="step_'.$status["keyword_pst"].'" role="tab" title="'.$status["status_name_pst"].'">
                                        <span class="round-tab">
                                            <i class="'.$status["status_icon_pst"].'"></i>
                                        </span>
                                    </a>
                                </li>
                                ';
                                $i++;
                            }
                            echo $navTab;
                            ?>
                        </ul>
                    </div>

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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>'.$status["status_name_pst"].'</h3>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 status-content">';
                                        $data["status"] = $status["keyword_pst"];
                            $tapPane .= $this->load->view("default-template/panel/content/project-status/status-management-views", $data,TRUE);
                            $tapPane .=
                                        '</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-primary save-status" data-status-id="'.$status["id_pst"].'" data-status-keyword="'.$status["keyword_pst"].'">Guardar</button>
                                                </div>
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
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view("default-template/panel/content/project-status/ht-stakes-project");
?>