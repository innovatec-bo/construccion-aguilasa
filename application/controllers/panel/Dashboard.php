<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/05/2018
 * Time: 11:34 AM
 */

class Dashboard extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature("dashboard_index");
        $this->complementHandler->addProjectCss('dashboard.index');
        $this->complementHandler->addProjectJs('dashboard.index');


        $this->_loadPanelView('dashboard/index');
    }
}