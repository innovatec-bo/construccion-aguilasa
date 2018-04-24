<?php
/**
 * Created by PhpStorm.
 * User: Yossy
 * Date: 10/4/2018
 * Time: 22:40
 */
?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Signup</h3>
                </div>
                <div class="panel-body">
                    <div class="row" id="flash-data-basic-message">
                        <div class="col-xl-12 col-lg-12"></div>
                    </div>
                    <form method="post" name="signup-form" data-parsley-validate>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" required placeholder="First name" name="first-name" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" required placeholder="Last name" name="last-name" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="" id="password">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Confirm password" name="confirm-password" type="password" value="" data-parsley-equalto="#password" data-parsley-equalto-message="Password no coinciden">
                            </div>
                            <button type="submit" class="btn btn-lg btn-success btn-block">Register me</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view("default-template/handlebar-basic-messages");
?>
