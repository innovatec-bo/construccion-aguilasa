<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Editar usuario</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Modifique la informacion del usuario
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="post" name="user-add-form" data-parsley-validate>
                                <input type="hidden" name="user-id" value="">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input class="form-control" value="<?=set_value('first-name', $user["firstname_usr"])?>" required name="first-name" placeholder="Enter first name">
                                </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input class="form-control" value="<?=set_value('last-name', $user["lastname_usr"])?>" required name="last-name" placeholder="Enter last name">
                                </div>
                        </div>
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Correo</label>
                                    <p class="form-control-static"><?=$user["email_usr"]?></p>
                                </div>
                        </div>
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input class="form-control" name="password" placeholder="Enter password" id="user-password">
                                </div>
                        </div>
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Confirme contraseña</label>
                                    <input class="form-control" name="confirm-password" placeholder="Confirm password" data-parsley-equalto="#user-password" data-parsley-equalto-message="Password and confirm password are different">
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Update password</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="update-password">Yes
                                    </label>
                                </div>
                            </div>
                        </div>
                            <div class="col-lg-6">

                                <?php
                                if($isSuperAdmin == 1)
                                {
                                ?>
                                <div class="form-group">
                                    <label>Roles</label>
                                    <?php
                                    $html = "";
                                    $i = 0;
                                    foreach ($roleList as $role) {
                                        $role = (array)$role;
                                        $checked = array_key_exists($role["id_rol"], $userRoleList);
                                        $parsleyValidation = $i == 0 ? ' required data-parsley-errors-container="#role-error-container" data-parsley-error-message="Choose at least one role" ' : '';
                                        $html .= '
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="roles[]" value="' . $role["id_rol"] . '" ' . $parsleyValidation . ' ' . set_checkbox('roles[]', $role["id_rol"], $checked) . ' >' . $role["rolename_rol"] . '
                                            </label>
                                        </div>
                                        ';
                                    }
                                    echo $html;
                                    ?>
                                    <div id="role-error-container"></div>
                                </div>
                                    <?php
                                }
                                ?>
                                <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
