<?php $this->load->view('default-template/public/header/header', $contentData); ?>
<?php $this->load->view('default-template/public/content/'.$contentData["contentView"], $contentData); ?>
<?php $this->load->view('default-template/public/footer/footer', $contentData); ?>