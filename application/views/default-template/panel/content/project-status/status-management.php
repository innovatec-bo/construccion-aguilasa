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
                                $class = $i === 1?"active":"";
                                $status = (array)$status;
                                $navTab .= '
                                <li role="presentation" class="'.$class.'">
                                    <a href="#step'.$i.'" data-toggle="tab" aria-controls="step'.$i.'" role="tab" title="'.$status["status_name_pst"].'">
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

                    <form role="form">
                        <div class="tab-content">
                            <?php
                            $tapPane = '';
                            $i = 1;
                            foreach ($statusList as $status)
                            {
                                $class = $i === 1?"active":"";
                                $status = (array)$status;
                                $tapPane .= '
                                <div class="tab-pane '.$class.'" role="tabpanel" id="step'.$i.'">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Step '.$i.'</h3>
                                            <p>This is step '.$i.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 status-content">
                                            sdasdfasd
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary next-step">Save</button>
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