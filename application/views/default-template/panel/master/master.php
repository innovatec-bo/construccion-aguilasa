<?php $this->load->view('default-template/panel/header/header', $contentData); ?>
<body>
<div id="wrapper">
    <!-- Navigation -->
    <?php $this->load->view('default-template/panel/navigation/navigation', $contentData); ?>
    <!-- Page Content -->

    <div id="page-wrapper">
        <?php $this->load->view('default-template/panel/content/'.$contentData["contentView"], $contentData); ?>

    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php 
$this->load->view('default-template/panel/footer/footer', $contentData); 
$this->load->view('default-template/panel/content/project/ht-datatable-dropdown-menu');
$this->load->view("default-template/panel/content/payment-management/ht-select2-project-response");
$this->load->view("default-template/ht-select2-material-response");
$this->load->view("default-template/ht-select2-material-summary-response");
$this->load->view("default-template/ht-show-materials-summary");
?>
