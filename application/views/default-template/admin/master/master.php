<?php $this->load->view('panel/t1/header/header', $contentData); ?>
<?php $this->load->view('panel/t1/menu/menu', $contentData); ?>
<?php $this->load->view('panel/t1/menu/side_menu', $contentData); ?>
<?php $this->load->view('panel/content/'.$contentData["contentView"], $contentData); ?>
<?php $this->load->view('panel/t1/footer/footer', $contentData); ?>