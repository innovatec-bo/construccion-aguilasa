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
            <input type="hidden" value='<?=$jsonTree?>' name="tree-data">
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
                        foreach ($roleList as $role)
                        {
                            $html .= '
                            <div class="radio">
                                <label>
                                    <input type="radio" name="roles" value="'.$role->id_rol.'">'.$role->rolename_rol.'
                                </label>
                            </div>
                        ';
                        }
                        echo $html;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
