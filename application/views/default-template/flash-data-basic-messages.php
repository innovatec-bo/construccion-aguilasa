<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/01/2018
 * Time: 4:24 PM
 */
    if($this->session->flashdata("errorMessage")) { ?>
    <div class="alert alert-danger mb-2" role="alert">
        <i class="fa fa-times-circle sign"></i><strong>Error!</strong> <?php echo $this->session->flashdata('errorMessage'); ?>
    </div>
<?php } if($this->session->flashdata('successMessage')) { ?>
    <div class="alert alert-success mb-2" role="alert">
        <i class="fa fa-check sign"></i><strong>Success!</strong> <?php echo $this->session->flashdata('successMessage'); ?>
    </div>
<?php } if ($this->session->flashdata('alertMessage')) { ?>
    <div class="alert alert-primary mb-2" role="alert">
        <i class="fa fa-warning sign"></i><strong>Alert!</strong> <?php echo $this->session->flashdata('alertMessage'); ?>
    </div>
<?php } if ($this->session->flashdata('infoMessage')) { ?>
    <div class="alert alert-info mb-2" role="alert">
        <strong>Info!</strong> <?php echo $this->session->flashdata('infoMessage'); ?>
    </div>
<?php } if(isset($errorMessage)) { ?>
    <div class="alert alert-danger mb-2" role="alert">
        <i class="fa fa-times-circle sign"></i><strong>Error!</strong> <?php echo $errorMessage;?>
    </div>
<?php } if(validation_errors()) { ?>
    <div class="alert alert-danger mb-2" role="alert">
        <i class="fa fa-times-circle sign"></i><strong>Error!</strong> <?php echo validation_errors();?>
    </div>
<?php } ?>