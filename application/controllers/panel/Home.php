<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 21:25
 */
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

//include_once FCPATH."application/libraries/phpdotenv/src/Dotenv.php";
class Home extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // $builders = Model_user::getByRoleKeyword('builder');
        // $buildersEmail = [];
        // foreach ($builders as $key => $value) 
        // {
        //     $buildersEmail[] = $value->getEmail();
        // }
        
        // $fiscals = Model_user::getByRoleKeyword('fiscal');
        // $fiscalsEmail = [];
        // foreach ($fiscals as $key => $value) 
        // {
        //     $fiscalsEmail[] = $value->getEmail();
        // }
        // dd($buildersEmail, $fiscalsEmail);
        
		$this->_validateFeature("home");
        $this->_tabTitle = 'Home';
        $this->complementHandler->addViewComplement("swiper");
        $this->complementHandler->addViewComplement("parsley");
        $this->complementHandler->addViewComplement("parsley.spanish");
        $this->complementHandler->addViewComplement("moment-range");
        $this->complementHandler->addViewComplement("date-time-picker");
        $this->complementHandler->addViewComplement("core");
        $this->complementHandler->addViewComplement("charts");
        $this->complementHandler->addViewComplement("themes.animated");
        $this->complementHandler->addViewComplement("perfect-scrollbar");
        $this->complementHandler->addProjectJs('WorkPlanHandler', TRUE);
        $this->complementHandler->addProjectCss('WorkPlanHandler', TRUE);
        $this->complementHandler->addProjectCss('home.index', TRUE);
        $this->complementHandler->addProjectJs('home.index', TRUE);

        $externalObservations = Model_external_fiscal_observations::getMasterDetail();
        $data['externalObservations'] = $externalObservations;
        $data['isAdmin'] = $this->_is('super_admin');
        $data['showWorkPlan'] = $this->_validateFeature('work_plan', true);

        $this->_loadPanelView('home/index', $data);
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

	public function updateDetails()
	{
		set_time_limit(300);
		ini_set('memory_limit','256M');
		require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
		$reader = new Xlsx();
		$spreadsheet = $reader->load(FCPATH."assets/actualizacion_campo_detalle_del_proyecto.xlsx");
		$sheetList = $spreadsheet->getAllSheets();
		$i = 0;
		$toUpdate = array();
		foreach ($sheetList as $sheetData)
		{
			$arrayData = $sheetData->toArray();
			foreach ($arrayData as $data)
			{
				if($i >= 3 && $i <=144)
				{
					$projectCode = $data[0];
					$newDetail = $data[2];
					$toUpdate[] = array(
						"code_pro" => $projectCode,
						"detail_pro" => $newDetail
					);
				}
				$i++;
			}

		}
//        Model_project::updateBatch($toUpdate,'code_pro');
		echo"finished";exit;
	}

    public function test()
    {
        $logDateRange = array('from' => '2020-03-01 00:00:00', 'to' => '2020-03-30 23:59:59');
        $pdf = new ExcelDailyProductivityReport($this->sessionUser, $logDateRange);
        $pdf->getReport();
    }
}
