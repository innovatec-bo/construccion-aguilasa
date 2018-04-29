<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/4/2018
 * Time: 11:15
 */

class Permission extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_loadPanelView('permission/index');
    }
}