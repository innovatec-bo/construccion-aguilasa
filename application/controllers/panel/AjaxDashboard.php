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

        $response = array();
        $statusList = array(
            'project_has_been_created' => 'INGRESADOS',
            'already_sent' => 'DISEÑADOS',
            'approved' => 'APROBADOS',
            'as_built' => 'CONSTRUIDOS',
            'conciliation_shipment' => 'CONCILIADOS',
            'project_real_budget_confirmation' => 'CON # ORDEN');
        $projectTotalsList = array();
        foreach ($statusList as $keyword => $criteria)
        {
            $keywordFilter = $dataType == "countId"?$keyword:"approved";
            $data = Model_project::getStatusQuantityDetailByYear($keywordFilter, $year, $dataType, $keyword, $contractId);
            //this method eval if the response has more than 1 result, if so then the result are stored in an unique array
            $data = static::sumData($data);
//            echo"<pre>";var_dump($keywordFilter, $year, $dataType, $keyword, $contractId, $data, $data1);exit;
            if(count($data) >= 1)
            {
                $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                $data = $this->_array_unshift_assoc($data, 'criteriaKeyword', $keyword);
            }
            else
            {
                $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
                $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                $data = $this->_array_unshift_assoc($data, 'criteriaKeyword', $keyword);
            }
            $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
                $projectTotalsList[] = $data;
        }
        $response["success"] = 1;
        $response["data"] = $projectTotalsList;
        echo json_encode($response);exit;
    }

    public static function sumData($data = array())
    {

        if(count($data) > 1)
        {
            $result = array();
            $result["year"] = "";
            $result['january'] = 0;
            $result['february'] = 0;
            $result['march'] = 0;
            $result['april'] = 0;
            $result['may'] = 0;
            $result['june'] = 0;
            $result['july'] = 0;
            $result['august'] = 0;
            $result['september'] = 0;
            $result['october'] = 0;
            $result['november'] = 0;
            $result['december'] = 0;

            foreach ($data as $key => $value)
            {
                $result['january'] += $value['january'];
                $result['february'] += $value['february'];
                $result['march'] += $value['march'];
                $result['april']  += $value['april'];
                $result['may'] += $value['may'];
                $result['june'] += $value['june'];
                $result['july'] += $value['july'];
                $result['august'] += $value['august'];
                $result['september'] += $value['september'];
                $result['october'] += $value['october'];
                $result['november'] += $value['november'];
                $result['december'] += $value['december'];
            }
            $data = array($result);
        }

        return $data    ;
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
            $data = $this->_array_unshift_assoc($data[0], 'criteria', "TOTALES");
            $data = $this->_array_unshift_assoc($data, 'rowKey', "countId");
        }
        else
        {
            $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
            $data = $this->_array_unshift_assoc($data[0], 'criteria', "TOTALES");
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
                        $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                        $data = $this->_array_unshift_assoc($data, 'rowKey', $rowKey);
                    }
                    else
                    {
                        $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
                        $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
                        $data = $this->_array_unshift_assoc($data, 'rowKey', $rowKey);
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

    private function _array_unshift_assoc(&$arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        $arr = array_reverse($arr, true);
        return $arr;
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
        $diffArray = $this->_array_unshift_assoc($diffArray, 'criteria', $criteria);
        $diffArray = $this->_array_unshift_assoc($diffArray, 'rowKey', $rowKey);
        return $diffArray;
    }

    public function getCurrentStatusSummary($ajaxRequest = TRUE, $system = "", $management = "", $contract = "")
    {
        if($ajaxRequest)
        {
            $formData = $this->input->post();
            $system = $formData["system"];
            $management = $formData["management"];
            $contract = $formData["contract"];
        }
        $currentStatusSummary = Model_project::projectCurrentStatusSummary($system, $management, $contract);
        $arrayData = array();
        $totalApprovedBudget = 0;
        $totalRealBudget = 0;
        $totalProjects = 0;
        foreach ($currentStatusSummary as $summary)
        {
            $totalApprovedBudget += $summary["keyword"] !="canceled"?$summary["approved_budgets"]:"0";
            $totalRealBudget += $summary["keyword"] !="canceled"?$summary["real_budgets"]:"0";
            $totalProjects += $summary["total_projects"];
            $arrayData[] = array(
                "keyword" => $summary["keyword"],
                "statusName" => $summary["status_name"],
                "totalProjects" => $summary["total_projects"],
                "approvedBudgets" => number_format($summary["approved_budgets"],2),
                "realBudgets" => number_format($summary["real_budgets"],2)
            );
        }
        $response["success"] = 1;
        $response["data"]["list"] = $arrayData;
        $response["data"]["totalApprovedBudgets"] = number_format($totalApprovedBudget,2);
        $response["data"]["totalRealBudgets"] = number_format($totalRealBudget,2);
        $response["data"]["totalProjects"] = $totalProjects;

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
        $contractAmount = 0;
        $contractList = Model_contract::getAll(100, 0);
        foreach ($contractList as $stdClass)
        {
            $contractAmount += $stdClass->amount_con;
            if($stdClass->id_con == $contract)
            {
                $contractAmount = $stdClass->amount_con;
                break;
            }
        }
        $currentStatusSummary = Model_project::projectCurrentStatusSummary($system, $management, $contract);
        $reportSections = array(
//            "recentlyCreated" => array("title" => "Solo registro", "section" => "recentlyCreated", "keywords" => array("project_has_been_created")),
            "readyToDesign" => array("title" => "Listo para diseño", "section" => "readyToDesign", "keywords" => array("design"), "keywordStringList" => "design"),
            "design" => array("title" => "Diseño", "section" => "design", "keywords" => array("stakes", "digitization", "drawing"), "keywordStringList" => "stakes,digitization,drawing"),
            "alreadySent" => array("title" => "Aprobacion", "section" => "alreadySent",  "keywords" => array("schedule", "ready_to_send", "already_sent"), "keywordStringList" => "schedule,ready_to_send,already_sent"),
            "inProgress" => array("title" => "Construccion", "section" => "inProgress", "keywords" => array("assign_to", "approved", "in_progress", "paused","stopped"), "keywordStringList" => "assign_to,approved,in_progress,paused,stopped"),
            "closure" => array("title" =>"Cierre", "section" => "closure", "keywords" => array("completed", "as_built","conciliation_reception", "conciliation_shipment","cre_return_order"), "keywordStringList" => "completed,as_built,conciliation_reception,conciliation_shipment, cre_return_order"),
            "closed" => array("title" => "Cerrado", "section" => "closed", "keywords" => array("project_return_materials","project_real_budget_confirmation", "project_closed", "payment_order_has_been_settled"), "keywordStringList" => "project_return_materials,project_real_budget_confirmation,project_closed,payment_order_has_been_settled")
        );
        $groupList = array();
        $totalProjects = 0;
        $totalApprovedBudget = 0;
        $totalApprovedBudgetBySection = 0;
        $totalRealBudget = 0;
        $totalProjectsBySection = 0;
        foreach ($reportSections as $groupKey => $data)
        {
            $groupKeywords =  $data["keywords"];
            for($i = 0; $i < count($groupKeywords); $i++)
            {
                for($j = 0; $j < count($currentStatusSummary); $j++)
                {
                    if($groupKeywords[$i] == $currentStatusSummary[$j]["keyword"])
                    {
                        $groupList[] = $currentStatusSummary[$j];
                        $totalProjectsBySection += $currentStatusSummary[$j]["total_projects"];
                        $totalProjects += $currentStatusSummary[$j]["total_projects"];
                        $totalApprovedBudgetBySection += $currentStatusSummary[$j]["keyword"] !="canceled"?$currentStatusSummary[$j]["approved_budgets"]:"0";
                        $totalApprovedBudget += $currentStatusSummary[$j]["keyword"] !="canceled"?$currentStatusSummary[$j]["approved_budgets"]:"0";
                        $totalRealBudget += $currentStatusSummary[$j]["keyword"] !="canceled"?$currentStatusSummary[$j]["real_budgets"]:"0";
                    }
                }
            }

            $reportSections[$groupKey]["list"] = $groupList;
            $reportSections[$groupKey]["totalProjectsBySection"] = $totalProjectsBySection;
            $reportSections[$groupKey]["totalApprovedBudgetBySection"] = $totalApprovedBudgetBySection;
            $reportSections[$groupKey]["totalRealBudget"] = $totalRealBudget;

            $groupList = array();
            $totalProjectsBySection = 0;
            $totalApprovedBudgetBySection = 0;
            $totalRealBudget = 0;
        }

        $totalPercentageProjects = 0;
        $totalPercentageApprovedBudget = 0;
        $totalContractAmountPercentage = 0;
        foreach ($reportSections as $groupKey => $data)
        {
            $totalProjectsBySection = $reportSections[$groupKey]["totalProjectsBySection"];
            $totalPercentageProjectsBySection = $totalProjectsBySection <= 0?0:($totalProjectsBySection*100) / $totalProjects;
            $reportSections[$groupKey]["totalPercentageProjectsBySection"] = number_format($totalPercentageProjectsBySection,2);
            $totalPercentageProjects += $totalPercentageProjectsBySection;

            $totalApprovedBudgetBySection = $reportSections[$groupKey]["totalApprovedBudgetBySection"];
            $totalPercentageApprovedBudgetBySection = $totalApprovedBudgetBySection <= 0?0:($totalApprovedBudgetBySection*100) / $totalApprovedBudget;
            $reportSections[$groupKey]["totalPercentageApprovedBudgetBySection"] = number_format($totalPercentageApprovedBudgetBySection,2);
            $totalPercentageApprovedBudget += $totalPercentageApprovedBudgetBySection;

            $contractAmountPercentageBySection = $totalApprovedBudgetBySection <= 0?0:($totalApprovedBudgetBySection*100) / $contractAmount;
            $totalContractAmountPercentage += $contractAmountPercentageBySection;
            $reportSections[$groupKey]["contractAmountPercentageBySection"] = number_format($contractAmountPercentageBySection, 2);
        }
        $response["success"] = 1;
        $response["totalProjects"] = $totalProjects;
        $response["totalPercentageProjects"] = $totalPercentageProjects;
        $response["totalApprovedBudget"] = number_format($totalApprovedBudget, 2);
        $response["totalPercentageApprovedBudget"] = $totalPercentageApprovedBudget;
        $response["totalContractAmountPercentage"] = number_format($totalContractAmountPercentage, 2);
        $response["totalContractAmount"] = $contractAmount;
        $response["list"] = array_values($reportSections);

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
        $contractList = Model_contract::getAll(100,0);

        foreach ($contractList as $contract)
        {
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
}