<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar proyecto</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Informacion del proyecto
                </div>

                <div class="panel-body">
                    <form role="form" method="post" name="proyect-edit-form" data-parsley-validate>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="project-id" value="">
                                <div class="form-group">
                                    <label>Nombre del proyecto</label>
                                    <input class="form-control" value="<?=set_value('project-name', $project["project_name_pro"])?>" required name="project-name" placeholder="Nombre del proyecto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    <!-- /.row (nested) -->
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
