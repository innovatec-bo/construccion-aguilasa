<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 21:25
 */
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
class Home extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_validateFeature("home");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-with-locales");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("core");
        $this->complementHandler->addViewComplement("charts");
        $this->complementHandler->addViewComplement("themes.animated");
        $this->complementHandler->addProjectJs('home.index', TRUE);

        $this->_loadPanelView('home/index');
    }

    public function jpgraphTest()
    {
//        $jpGraphHandler = new JPGraphHandler();
//        $jpGraphHandler->printPieChart3D();

        $TCPDFHandler = new NetBuildingReportPDF();
        $TCPDFHandler->PrintReport("I");
    }

    public function notifyReport()
    {
//        Model_user::netBuildingEmail();
    }

    public function updateAmounts()
    {
        $arrayRounds = array("","A","B", "C");
        $arrayAlphabet = range("A","Z");
        $result = [];
        foreach($arrayRounds as $round)
        {
            foreach ($arrayAlphabet as $alphabet)
            {
                $result[] = $round.$alphabet;
            }
        }
        echo"<pre>";var_dump($result);exit;
    }

    public function updateAmounts2()
    {
        set_time_limit(300);
        ini_set('memory_limit','256M');
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
        $reader = new Xlsx();
        $spreadsheet = $reader->load(FCPATH."assets/PLANILLA(9326).xlsx");
        $sheetList = $spreadsheet->getAllSheets();
        $i = 0;
        $toUpdate = array();
        $toInsert = array();
        foreach ($sheetList as $sheetData)
        {
            $arrayData = $sheetData->toArray();
            foreach ($arrayData as $data)
            {
                if($i >= 2 && $i <=45)
                {
                    $statusLogId = intval($data[2]);
                    $budgetId = $data[3] == "null"?NULL:intval($data[3]);
                    $designBudget = floatval(str_replace(",","",$data[37]));
                    $buildingBudget = floatval(str_replace(",","",$data[38]));
                    if(!is_null($budgetId))
                    {
                        $toUpdate[] = array(
                            "id_prb" => $budgetId,
                            "design_prb" => $designBudget,
                            "building_prb" => $buildingBudget
                        );
                    }
                    else
                    {
                        $toInsert[] = array(
                            "status_log_id_prb" => $statusLogId,
                            "design_prb" => $designBudget,
                            "building_prb" => $buildingBudget,
                            "graph_number_prb" => "",
                            "reservation_number_prb" => "",
                            "transportation_prb" => 0,
                            "live_line_prb" => 0,
                            "right_of_way_prb" => 0,
                        );
                    }
                }
                $i++;
            }

        }
//        echo"<pre>";var_dump($toInsert);
//        Model_project_budget::updateBatch($toUpdate);
//        Model_project_budget::insertBatch($toInsert);
        echo"finished";exit;
    }

    public function stakeReport()
    {
        $workflow = Model_project::getWorkflowDetail();
//        echo '<pre>';var_dump($workflow);exit;
        foreach ($workflow as $row)
        {
            //Dandy Coca, Rider Cortez, Miguel Flores
            if($row['stake_responsible'] == 'Miguel Flores' && $row['stake_date'] >= "2019-04-01 00:00:00" && $row['stake_date'] <= "2019-04-30 23:59:59")
            {
                echo '<pre>';var_dump($row);
            }
        }
        exit;
    }
}