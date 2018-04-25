<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->driver('session');
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
