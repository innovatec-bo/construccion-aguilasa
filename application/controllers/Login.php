<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends PublicController {

	public function index()
	{
        $this->complementHandler->addViewComplement("metisMenu");
        $this->complementHandler->addViewComplement("sb-admin-2");
        $this->_loadPublicView('login');
	}
}
