<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 18/10/2018
 * Time: 2:01 PM
 */


class AjaxDashboard extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        if(! $this->input->is_ajax_request())
        {
            redirect('404');
        }
    }

    public function getProjectTotalsTable()
    {
        $formData = $this->input->post();
        $year = $formData["year"];
        $dataType = isset($formData["dataType"])?$formData["dataType"]:"countId";
        $contractId = isset($formData["contractId"])?$formData["contractId"]:"";

        $response = Model_project::prepareProjectTotalsTableArray($year, $dataType, $contractId);

        echo json_encode($response);exit;
    }



    public function getProjectNetBuilding()
    {
        $formData = $this->input->post();
        $mainList = $formData["keyword"];
        $year = $formData["year"];

        $response = array();
        $reportSections = array(
            'project_has_been_created' => array(
                                                'entryPoints' => 'INGRESO - PUNTOS',
                                                'entryDistance' => 'INGRESO - DISTANCIA'
                                            ),
            'digitization' => array(
                                        'countDigitizationPoints' => 'PROYECTOS CON ESTACADO',
                                        'countWithoutDigitizationPoints' => 'PROYECTOS SIN ESTACADO',
                                        'digitizationPoints' => 'ESTACADO - PUNTOS',
                                        'digitizationDistance' => 'ESTACADO - DISTANCIA'
                                    ),
            'as_built' => array(
                                        'countAsBuiltPoints' => 'PROYECTOS CON AREA CONSTRUIDA',
                                        'countWithoutAsBuiltPoints' => 'PROYECTOS SIN AREA CONSTRUIDA',
                                        'asBuiltPoints' => 'CONSTRUIDO - PUNTOS',
                                        'asBuiltDistance' => 'CONSTRUIDO - DISTANCIA'
            ),
            'approved' => array(
                                    'countBudgets' => 'PROYECTOS CON IMPORTE',
                                    'countWithoutBudgets' => 'PROYECTOS SIN IMPORTE',
                                    'sumDesignBudget' => 'IMPORTE DISEÑO',
                                    'sumBuildingBudget' => 'IMPORTE CONSTRUCCION',
                                    'sumTransportationBudget' => 'IMPORTE TRANSPORTE',
                                    'sumLiveLineBudget' => 'IMPORTE LINEA VIVA',
                                    'sumRightOfWayBudget' => 'IMPORTE DERECHO DE VIA',
                                    'sumBudget' => 'TOTAL IMPORTE'
                                ),
            'conciliation_shipment' => array(
                                    'countRealBudgets' => 'PROYECTOS CON IMPORTE REAL',
                                    'countWithoutRealBudgets' => 'PROYECTOS SIN IMPORTE REAL',
                                    'sumDesignRealBudget' => 'IMPORTE REAL - DISEÑO',
                                    'sumBuildingRealBudget' => 'IMPORTE REAL - CONSTRUCCION',
                                    'sumTransportationRealBudget' => 'IMPORTE REAL - TRANSPORTE',
                                    'sumLiveLineRealBudget' => 'IMPORTE REAL - LINEA VIVA',
                                    'sumRightOfWayRealBudget' => 'IMPORTE REAL - DERECHO DE VIA',
                                    'sumRealBudget' => 'TOTAL IMPORTE REAL'
                                )
            );

        $projectTotalsList = array();
        $totalRow = array();
        //begin - Adding total column
        $data = Model_project::getStatusQuantityDetailByYear($mainList, $year,"countId", $mainList);
        if(count($data) >= 1)
        {
            $data = PublicController::array_unshift_assoc($data[0], 'criteria', "TOTALES");
            $data = PublicController::array_unshift_assoc($data, 'rowKey', "countId");
        }
        else
        {
            $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
            $data = PublicController::array_unshift_assoc($data[0], 'criteria', "TOTALES");
        }
        $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
        $projectTotalsList[] = $data;
        //end - adding total column
        $totalRow = $data;
        $subArray = array();
        foreach($reportSections as $keyword => $columnTypeList)
        {
            foreach ($columnTypeList as $rowKey => $criteria)
            {
                if($rowKey == "countWithoutBudgets" || $rowKey == "countWithoutRealBudgets" || $rowKey == "countWithoutDigitizationPoints" || $rowKey == "countWithoutAsBuiltPoints")
                {
                    $dataDiff = $this->_getDiff($totalRow, $subArray, $criteria, $rowKey);
                    $dataDiff = $this->_formatNumbers($dataDiff);
                    $projectTotalsList[] = $dataDiff;
                }
                else
                {
                    $data = Model_project::getStatusQuantityDetailByYear($keyword, $year, $rowKey, $mainList);
                    if(count($data) >= 1)
                    {
                        $data = PublicController::array_unshift_assoc($data[0], 'criteria', $criteria);
                        $data = PublicController::array_unshift_assoc($data, 'rowKey', $rowKey);
                    }
                    else
                    {
                        $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
                        $data = PublicController::array_unshift_assoc($data[0], 'criteria', $criteria);
                        $data = PublicController::array_unshift_assoc($data, 'rowKey', $rowKey);
                    }
                    $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
                    $subArray = $data;
                    $data = $this->_formatNumbers($data);
                    $projectTotalsList[] = $data;
                }
            }
        }

        $response["success"] = 1;
        $response["data"] = $projectTotalsList;
        echo json_encode($response);exit;
    }



    private function _formatNumbers($data)
    {
        $monthList = array("january","february","march","april","may","june","july","august","september","october","november","december","total");
        foreach ($data as $month => &$value)
        {
            if(in_array($month, $monthList))
            {
                $value = number_format($value,2);
            }
        }
        return $data;
    }

    private function _getDiff($rowTotal, $subArray, $criteria, $rowKey)
    {
        $monthList = array("january","february","march","april","may","june","july","august","september","october","november","december","total");
        $diffArray = array();
        foreach ($monthList as $month)
        {
            $diffArray[$month] = $rowTotal[$month] - $subArray[$month];
        }
        $diffArray = PublicController::array_unshift_assoc($diffArray, 'criteria', $criteria);
        $diffArray = PublicController::array_unshift_assoc($diffArray, 'rowKey', $rowKey);
        return $diffArray;
    }

    public function getCurrentStatusSummary($ajaxRequest = TRUE, $system = "", $management = "", $contract = "")
    {
        set_time_limit(240);
		ini_set('memory_limit','512M');
        if($ajaxRequest)
        {
            $formData = $this->input->post();
            $system = $formData["system"];
            $management = $formData["management"];
            $contract = $formData["contract"];
        }
//        $response = Model_project::prepareCurrentStatusSummaryArray($system, $management, $contract);
        $response = Model_project::prepareCurrentStatusSummaryArray2($system, $management, $contract);

        if($ajaxRequest)
        {
            echo json_encode($response);exit;
        }
        else
        {
            return $response;
        }

    }

    public function getSystemReport()
    {
        $formData = $this->input->post();
        $arrayData = array();
        $management = $formData["management"];
        $contract = $formData["contract"];
        $response = array();
        foreach ($this->_projectSystems as $id => $system)
        {
            $currentStatusSummary = Model_project::projectCurrentStatusSummary($id, $management, $contract);
            $totalProjects = 0;
            $totalBudget = 0;
            foreach ($currentStatusSummary as $summary)
            {
                if($summary["keyword"] != "returned" && $summary["keyword"] != "canceled")
                {
                    $totalProjects += $summary["total_projects"];
                    $totalBudget += $summary["approved_budgets"];
//                    $arrayData[] = array(
//                        "id" => $id,
//                        "system" => $system,
//                        "total_projects" => $totalProjects,
//                        "approved_budgets" => $totalBudget
//                    );
                }

            }
            $arrayData[] = array(
                "id" => $id,
                "system" => $system,
                "total_projects" => $totalProjects,
                "approved_budgets" => $totalBudget
            );
        }
        $response["success"] = 1;
        $response["message"] = "";
        $response["data"] = $arrayData;
        echo json_encode($response);exit;
    }

    public function getExecutiveSummary($ajaxRequest = TRUE, $system = "", $management = "", $contract = "")
    {
        if($ajaxRequest)
        {
            $formData = $this->input->post();
            $system = $formData["system"];
            $management = $formData["management"];
            $contract = $formData["contract"];
        }

        $response = Model_project::prepareExecutiveSummaryArray($system, $management, $contract);

        if($ajaxRequest)
        {
            echo json_encode($response);exit;
        }
        else
        {
            return $response;
        }
    }

    public function getProjectProgressBySection()
    {
        $formData = $this->input->post();
        $system = $formData["system"];
        $management = $formData["management"];
        $contractId = $formData["contract"];
        $section = $formData["section"];
        $executiveSummaryReport = $this->getExecutiveSummary(FALSE, $system, $management, $contractId);
        $contractList = Model_contract::getAll(100, 0);
        $sectionList = $executiveSummaryReport["list"];
        $amountProgress = str_replace(",","",$executiveSummaryReport["totalApprovedBudget"]);
        $contractAmount = 0;
        foreach ($sectionList as $sectionData)
        {
            if($section == $sectionData["section"])
            {
//                echo"<pre>";var_dump($executiveSummaryReport);exit;
                $amountProgress = str_replace(",","",$sectionData["totalApprovedBudgetBySection"]);
                break;
            }
        }
        foreach ($contractList as $contract)
        {
            if($contract->id_con == $contractId)
            {
                $contractAmount = $contract->amount_con;
                break;
            }
            else
            {
                $contractAmount += $contract->amount_con;
            }
        }
//        echo"<pre>";var_dump($contractAmount, $amountProgress);exit;
        $percentage = ($amountProgress* 100) / $contractAmount;
        $response["success"]  = 1;
        $response["message"]  = "";
        $response["percentage"] = number_format($percentage,2);
        $response["amountProgress"] = $amountProgress;
        $response["contractAmount"] = $contractAmount;

        echo json_encode($response);exit;
    }

    public function getContractTimeProgress()
    {
        $formData = $this->input->post();
        $contractId = $formData["contract"];
        $contracts = Model_contract::getNotExpiredContracts();
        foreach ($contracts as $data) 
        {
            $contractList[] = $data->toArray();
        }
        $i = 0;
        foreach ($contractList as $contract)
        {
            $contract = (object)$contract;
            if(date('Y-m-d H:i:s') > $contract->expiration_date_con)
            {
                continue;
            }
            
            if($contract->id_con == $contractId)
            {
                $startDate = $contract->start_date_con;
                $endDate = $contract->expiration_date_con;
                break;
            }
            else
            {
                $contractList = json_decode(json_encode($contractList), True);
                $startDateArray = array_column($contractList, "start_date_con");
                $endDateArray = array_column($contractList, "expiration_date_con");
                sort($startDateArray);
                rsort($endDateArray);
                $startDate = $startDateArray[0];
                $endDate = $endDateArray[0];
            }
            $i++;
        }
        $totalDays = round(abs(strtotime($startDate) - strtotime($endDate))/86400);
        $daysProgress = round(abs(strtotime($startDate) - strtotime(date("Y-m-d")))/86400);
        $percentage =  ($daysProgress * 100) / $totalDays;
        $response["success"]  = 1;
        $response["message"]  = "";
        $response["percentage"] = number_format($percentage,2);
        $response["daysProgress"] = $daysProgress;
        $response["totalDays"] = $totalDays;
        $response["startDate"] = $startDate;
        $response["endDate"] = $endDate;
        echo json_encode($response);exit;
    }

    public function getExecutiveSummaryAndCurrentStatusSummary()
    {
        $formData = $this->input->post();
        $system = $formData["system"];
        $management = $formData["management"];
        $contract = $formData["contract"];
        $executiveSummary = $this->getExecutiveSummary(FALSE, $system, $management, $contract);
        $currentStatusSummary = $this->getCurrentStatusSummary(FALSE, $system, $management, $contract);
        $response["success"] = 1;
        $response["message"] = "";
        $response["data"]["executiveSummary"] = $executiveSummary;
        $response["data"]["currentStatusSummary"] = $currentStatusSummary;
        echo json_encode($response);exit;
    }

    public function getExecutiveSummaryLog($date = NULL)
    {
        $logs = Model_executive_summary_log::getExecutiveSummaryLog($date);
        $arrayLog = array();
        $labelList = array(1 => "Diseño", 2 => "Aprobacion", 3 => "Construccion", 4 => "Cierre", 5 => "Cerrado");
        foreach ($logs as $log)
        {
            $log = $log->toArray();
            $arrayLog[] = array(
                "stage" => $log["stage_esl"],
                "stageLabel" => $labelList[$log["stage_esl"]],
                "projectsQuantity" => $log["projects_quantity_esl"],
                "projectPercentage" => $log["project_percentage_esl"],
                "approvedBudget" => number_format($log["approved_budget_esl"], 2),
                "approvedBudgetPercentage" => $log["approved_budget_percentage_esl"],
                "contractPercentage" => $log["contract_percentage_esl"]
            );
        }
        $response["success"] = 1;
        $response["message"] = "";
        $response["log"] = $arrayLog;
        echo json_encode($response);exit;
    }

    public function getExecutiveSummaryDifferential($initialDate, $finalDate)
    {
        $logs = Model_executive_summary_log::getExecutiveSummaryDifferential($initialDate, $finalDate);
        $arrayLog = array();
        $labelList = array(1 => "Diseño", 2 => "Aprobacion", 3 => "Construccion", 4 => "Cierre", 5 => "Cerrado");
        foreach ($logs as $log)
        {
//            $log = $log->toArray();
            $arrayLog[] = array(
                "stage" => $log["stage_esl"],
                "stageLabel" => $labelList[$log["stage_esl"]],
                "projectsQuantity" => $log["projects_quantity_esl"],
                "projectPercentage" => $log["project_percentage_esl"],
                "approvedBudget" => number_format($log["approved_budget_esl"], 2),
                "approvedBudgetPercentage" => $log["approved_budget_percentage_esl"],
                "contractPercentage" => $log["contract_percentage_esl"],
                "projectsQuantityDiff" => $log["diff_projects_quantity_esl"],
                "projectPercentageDiff" => $log["diff_project_percentage_esl"],
                "approvedBudgetDiff" => $log["diff_approved_budget_esl"],
                "approvedBudgetPercentageDiff" => $log["diff_approved_budget_percentage_esl"],
                "contractPercentageDiff" => $log["diff_contract_percentage_esl"]

            );
        }
        $response["success"] = 1;
        $response["message"] = "";
        $response["log"] = $arrayLog;
        echo json_encode($response);exit;
    }

    public function getAmountWorked()
    {
        $date = new DateTime(); 
        $startDate = $date->format('Y-m-1');
        $endDate = $date->format('Y-m-t');
        $projectProductivity = Model_project::getBuilderIndividualReport($startDate, $endDate);
        $totalWorkedUp = 0;
        $list = array();
        foreach ($projectProductivity as $value) 
        {
            $list[] = $value['totalWorkedUpAmount'];
            $totalWorkedUp += $value['totalWorkedUpAmount'];
        }
        $result['totalWorkedUp'] = number_format($totalWorkedUp, 2, '.', ',');
        $result['projectProductivity'] = $projectProductivity;
        $result['list'] = $list;
        $result['totalProjects'] = count($list);
        echo json_encode($result);exit;
        // echo"<pre>";var_dump($startDate, $endDate);exit;
    }
}
