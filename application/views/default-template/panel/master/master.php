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
?>
