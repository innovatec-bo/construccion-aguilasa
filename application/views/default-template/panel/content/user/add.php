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
            <h1 class="page-header">Add user</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    User information
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" method="post" name="user-add-form" data-parsley-validate>
                                <input type="hidden" name="user-id" value="">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input class="form-control" required name="first-name" placeholder="Enter first name">
                                </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Last name</label>
                                    <input class="form-control" required name="last-name" placeholder="Enter last name">
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" required name="email" placeholder="Enter email">
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" required name="password" placeholder="Enter password" id="user-password">
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Confirm password</label>
                                    <input class="form-control" required name="confirm-password" placeholder="Confirm password" data-parsley-equalto="#user-password" data-parsley-equalto-message="Password and confirm password are different">
                                </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Roles</label>
                                    <?php
                                    $html = "";
                                    $i = 0;
                                    foreach ($roleList as $role)
                                    {
                                        $role = (array)$role;
                                        $parsleyValidation = $i == 0?' required data-parsley-errors-container="#role-error-container" data-parsley-error-message="Choose at least one role" ':'';
                                        $html .= '
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="roles[]" value="'.$role["id_rol"].'" '.$parsleyValidation.'>'.$role["rolename_rol"].'
                                            </label>
                                        </div>
                                        ';
                                    }
                                    echo $html;
                                    ?>
                                    <div id="role-error-container"></div>
                                </div>
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
