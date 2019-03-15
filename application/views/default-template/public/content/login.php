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
        <div class="col-md-12">
            <div class="title-system-panel panel panel-default">
                <div class="panel-heading">
                    <h1 class="system-title">Sistema De Gestion De Procesos</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Iniciar sesion</h3>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <fieldset>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <div class="checkbox hide">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
                            <button class="btn btn-lg btn-default btn-block">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
