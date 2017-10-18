<?php

$this->load->view('panel/t1/header/header', $contentData); ?>
<?php

if($contentData["contentData"]!="index")
		{
		$this->load->view('panel/t1/menu/menu', $contentData);
		}
		else
		{
		$this->load->view('panel/t1/menu/menu_introduction',  $contentData);
		}

 ?>
<?php $this->load->view('panel/t1/menu/side_menu_introduction',  $contentData); ?>

<?php $this->load->view('panel/content/'.$contentData["contentView"], $contentData); ?>
<?php $this->load->view('panel/t1/footer/footer', $contentData); ?>