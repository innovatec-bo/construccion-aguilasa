<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/09/2018
 * Time: 21:25
 */

class AboutSerebo extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->complementHandler->addProjectJs("about-serebo.index");
        $this->_loadPanelView('about/index');
    }

//    public function createWarehouse()
//    {
//        $projectList = Model_project::getApprovedProjectWithoutWarehouse();
//        foreach ($projectList as $arrayItem)
//        {
//            $project = Model_project::getById($arrayItem["id_pro"]);
//            $project->startWarehouseProcess("Y-m-d H:i:s");
//        }
//    }
}