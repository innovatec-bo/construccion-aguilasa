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
                    $activeFound = FALSE;
                    foreach ($statusList as $status)
                    {
                        $status = $status->toArray();
                        $class = 'completed';
                        if($status["id_pst"] === $project["status_pro"])
                        {
                            $class = 'active';
                            $activeFound = TRUE;
                        }
                        elseif($activeFound)
                        {
                            $class = '';
                        }
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
                        <input type="hidden" value='<?=$responsibleList?>' name="responsible-list">
                        <div class="tab-content" id="status-form-content">
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
                    <?php
                    $html = '';
                    foreach ($projectLog as $log)
                    {
                        $originalDate = $log['manual_entry_date_psl'];
                        $newDate = date("d-m-Y", strtotime($originalDate));
                        $detail = '';
                        if($log['log_detail_psl'] != "")
                        {
                            $detail = '
                                <dt>Observaciones</dt>
                                <dd>'.$log['log_detail_psl'].'</dd>
                            ';
                        }

                        $html .= '
                        <h6>'.$log['status_name_pst'].' <span class="pull-right">'.$newDate.'</span></h6>
                        <blockquote>
                            <dl>
                                <dt>Responsable</dt>
                                <dd>Fulano de tal</dd>
                                '.$detail.'
                            </dl>
                        </blockquote>
                        ';
                    }
                    echo $html;
                    ?>
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
$this->load->view("default-template/panel/content/project-status/ht-status-stakes-form");
$this->load->view("default-template/panel/content/project-status/ht-status-digitization-form");
$this->load->view("default-template/panel/content/project-status/ht-status-drawing-form");
$this->load->view("default-template/panel/content/project-status/ht-status-schedule-form");
?>