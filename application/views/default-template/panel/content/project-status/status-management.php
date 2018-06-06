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
            <h1 class="page-header">Administracion de estados</h1>
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
                            $statusHtml = '';
                            $i = 1;
                            foreach ($statusList as $status)
                            {
                                $class = $i === 1?"active":"";
                                $status = (array)$status;
                                $statusHtml .= '
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
                            echo $statusHtml;
                            ?>
<!--                            <li role="presentation" class="active">-->
<!--                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Diseño">-->
<!--                            <span class="round-tab">-->
<!--                                <i class="glyphicon glyphicon-pencil"></i>-->
<!--                            </span>-->
<!--                                </a>-->
<!--                            </li>-->
<!---->
<!--                            <li role="presentation" class="disabled">-->
<!--                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">-->
<!--                            <span class="round-tab">-->
<!--                                <i class="glyphicon glyphicon-pencil"></i>-->
<!--                            </span>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li role="presentation" class="disabled">-->
<!--                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">-->
<!--                            <span class="round-tab">-->
<!--                                <i class="glyphicon glyphicon-picture"></i>-->
<!--                            </span>-->
<!--                                </a>-->
<!--                            </li>-->
<!---->
<!--                            <li role="presentation" class="disabled">-->
<!--                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">-->
<!--                            <span class="round-tab">-->
<!--                                <i class="glyphicon glyphicon-ok"></i>-->
<!--                            </span>-->
<!--                                </a>-->
<!--                            </li>-->
                        </ul>
                    </div>

                    <form role="form">
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h3>Step 1</h3>
                                <p>This is step 1</p>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h3>Step 2</h3>
                                <p>This is step 2</p>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                    <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h3>Step 3</h3>
                                <p>This is step 3</p>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                    <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                                    <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="complete">
                                <h3>Complete</h3>
                                <p>You have successfully completed all steps.</p>
                            </div>
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
