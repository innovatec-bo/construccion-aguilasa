<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/01/2018
 * Time: 4:24 PM
 * Modified: June 2026 (Fix Flashdata PHP 8.x/Ajax session persistence bug)
 */

// 1. Extraemos y destruimos manualmente los mensajes de sesión para asegurar que mueran en este request
$flashError = $this->session->userdata('errorMessage');
if ($flashError) { $this->session->unset_userdata('errorMessage'); }

$flashSuccess = $this->session->userdata('successMessage');
if ($flashSuccess) { $this->session->unset_userdata('successMessage'); }

$flashAlert = $this->session->userdata('alertMessage');
if ($flashAlert) { $this->session->unset_userdata('alertMessage'); }

$flashInfo = $this->session->userdata('infoMessage');
if ($flashInfo) { $this->session->unset_userdata('infoMessage'); }


// 2. Renderizado de las alertas basadas en las variables manuales optimizadas
if ($flashError): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-times-circle sign"></i><strong>Error!</strong> <?php echo $flashError; ?>
    </div>
<?php endif; ?>

<?php if ($flashSuccess): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-check sign"></i><strong>Success!</strong> <?php echo $flashSuccess; ?>
    </div>
<?php endif; ?>

<?php if ($flashAlert): ?>
    <div class="alert alert-primary alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-warning sign"></i><strong>Alert!</strong> <?php echo $flashAlert; ?>
    </div>
<?php endif; ?>

<?php if ($flashInfo): ?>
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Info!</strong> <?php echo $flashInfo; ?>
    </div>
<?php endif; ?>

<?php // Variables nativas de controlador o librería de validación (no viajan en sesión, se mantienen igual)
if (isset($errorMessage)): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-times-circle sign"></i><strong>Error!</strong> <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="fa fa-times-circle sign"></i><strong>Error!</strong> <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>