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
        <div class="col-md-12 col-lg-12">
            <h1 class="page-header">Permissions</h1>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Tree feature
                </div>
                <div class="panel-body">
                    <div id="container"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Roles
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <?php
                        $html = '';
                        $i = 0;
                        foreach ($roleList as $role)
                        {
                            $checked = $i == 0?'checked':'';
                            $html .= '
                            <div class="radio">
                                <label>
                                    <input type="radio" name="roles" value="'.$role->id_rol.'" '.$checked.'>'.$role->rolename_rol.'
                                </label>
                            </div>
                        ';
                            $i++;
                        }
                        echo $html;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button type="button" class="btn btn-default save-permissions">Save</button>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view('default-template/panel/content/feature/ht-modal-edit-form');
?>
