<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 13/09/2018
 * Time: 9:27 AM
 */
//$statusName = $statusName = $statusList[$warehouse["status_id_war"]]->getName();;
//$projectSystem = $projectSystems[$project["system_pro"]];
//$entryDate = DateTime::createFromFormat('Y-m-d H:i:s', $project["entry_date_pro"]);
//$entryDate = date_format($entryDate, 'd-m-Y');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><em class="subtext"></em></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <?php
        $projectListHtml = '';
        foreach ($projectList as $project)
        {
            $projectListHtml .= '
            <div class="col-md-2">
                <dl class="header-description well well-sm">
                    <dt>'.$project->getCode().'</dt>
                    <dd></dd>
                </dl>
            </div>
            ';
        }
        echo $projectListHtml;
        ?>
        <div class="col-md-10">
            <div class="tabbable">
                <ul class="nav nav-tabs wizard">
                    <?php
                    $navTab = '';
                    $i = 1;

                    $activeFound = FALSE;
                    $currentStatus = $paymentOrder["status_pao"];
                    foreach ($statusList as $status)
                    {
                        $status = $status->toArray();
                        $class = "completed";
                        $disabled = "";
                        if($status["id_pst"] == $currentStatus)
                        {
                            $class = 'active';
                            $activeFound = TRUE;
                        }
                        elseif($activeFound)
                        {
                            $class = '';
                        }
                        $navTab .= '
                                <li class="'.$class.' '.$disabled.'">
                                    <a href="#step_'.$status["keyword_pst"].'" data-toggle="tab" aria-expanded="false" data-status-id="'.$status["id_pst"].'" id="'.$status["keyword_pst"].'">'.$status["status_name_pst"].'</a>
                                </li>
                                ';
                        $i++;
                    }
                    $unsignedAsDefault = $class == '' && !$activeFound?'active':'completed';
                    $unsigned = '';
                    echo $unsigned.$navTab;
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <section>
                <div class="wizard">
                    <form role="form" name="status-management" data-parsley-validate>
                        <input type="hidden" value="<?=$paymentOrder["id_pao"]?>" name="payment-order-id">
                        <input type="hidden" value='<?=$responsibleList?>' name="responsible-list">
                        <input type="hidden" value="" name="status-set">
                        <?php
                        $html = '
                                <div class="tab-content" id="status-form-content">
                                </div>    
                            ';
                        echo $html;
                        ?>
                    </form>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Historial
                </div>
                <div class="panel-body" style="overflow: auto;height: 50vh;" id="status-project-log-content" data-allow-update-history="">

                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <div class="col-md-12" id="incident-content">
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view("default-template/panel/content/project-status/ht-status-no-created-view-form");

//payment management
$this->load->view("default-template/panel/content/project-status/ht-status-payment_order_registered-form");
$this->load->view("default-template/panel/content/project-status/ht-status-payment_order_invoice_sent-form");
$this->load->view("default-template/panel/content/project-status/ht-status-payment_order_has_been_settled-form");

$this->load->view("default-template/panel/content/project-status/ht-status-payment-management-log-quick-view");

$this->load->view("default-template/panel/content/project-status/ht-modal-incident-form");
$this->load->view("default-template/panel/content/project-status/ht-modal-incident-list");
?>