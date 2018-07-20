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
            <h1 class="page-header">Diseño<em class="subtext"><?=$project["code_pro"]?></h1></em>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-2">
            <dl class="header-description well well-sm">
                <dt>SISTEMA</dt>
                <dd><?=$projectSystems[$project["system_pro"]]?></dd>
            </dl>
        </div>
        <div class="col-md-2">
            <dl class="header-description well well-sm">
                <dt>FECHA DE INGRESO</dt>
                <?php
                $entryDate = DateTime::createFromFormat('Y-m-d H:i:s', $project["entry_date_pro"]);
                $entryDate = date_format($entryDate, 'd-m-Y');
                ?>
                <dd><?=$entryDate?></dd>
            </dl>
        </div>
        <div class="col-md-2">
            <dl class="header-description well well-sm">
                <dt>FISCAL DE CRE</dt>
                <dd><?=$project["cre_fiscal_pro"]?></dd>
            </dl>
        </div>
        <div class="col-md-2">
            <dl class="header-description well well-sm">
                <dt>DIRECCION</dt>
                <dd><dd><?=$project["address_pro"]?></dd></dd>
            </dl>
        </div>
        <div class="col-md-2">
            <dl class="header-description well well-sm">
                <dt>AREA</dt>
                <dd><span id="points"><?=$project["points_pro"]?></span>p/<span id="distance"><?=$project["distance_pro"]?></span>Km</dd>
            </dl>
        </div>
        <div class="col-md-10">
            <div class="tabbable">
                <ul class="nav nav-tabs wizard">
                    <?php
                    $navTab = '';
                    $i = 1;

                    $activeFound = FALSE;
                    foreach ($statusList as $status)
                    {
                        $status = $status->toArray();
                        $class = $project["status_pro"] != 1 && $project["status_pro"] !=7?'completed':"";
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
                    $unsignedAsDefault = $class == '' && !$activeFound?'active':'completed';
                    $unsigned = '
                                <li class="'.$unsignedAsDefault.'">
                                    <a href="#step_unsigned" data-toggle="tab" aria-expanded="false" id="unsigned">Sin asignar</a>
                                </li>
                                ';
                    echo $unsigned.$navTab;
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-2">
            <div class="tabbable">
                <a href="#next-step" id="next-step">Siguiente paso</a>
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Historial
                </div>
                <div class="panel-body" style="overflow: auto;height: 50vh;" id="status-project-log-content">

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
$this->load->view("default-template/panel/content/project-status/ht-status-unsigned-form");
$this->load->view("default-template/panel/content/project-status/ht-status-stakes-form");
$this->load->view("default-template/panel/content/project-status/ht-status-digitization-form");
$this->load->view("default-template/panel/content/project-status/ht-status-drawing-form");
$this->load->view("default-template/panel/content/project-status/ht-status-schedule-form");
$this->load->view("default-template/panel/content/project-status/ht-status-saved-view");
$this->load->view("default-template/panel/content/project-status/ht-status-already-has-data");
$this->load->view("default-template/panel/content/project-status/ht-status-project-log-quick-view");
?>