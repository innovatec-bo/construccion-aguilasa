<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 21:25
 */

class Home extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature("home");
        $this->_loadPanelView('home/index');
    }

    public function createWarehouse()
    {
        $projectList = Model_project::getApprovedProjectWithoutWarehouse();
        foreach ($projectList as $arrayItem)
        {
            $project = Model_project::getById($arrayItem["id_pro"]);
            $project->startWarehouseProcess("Y-m-d H:i:s");
        }
    }
}