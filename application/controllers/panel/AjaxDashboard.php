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
            $data = Model_project::getStatusQuantityDetailByYear($keyword, $year, "countId", $keyword);
            if(count($data) >= 1)
            {
                $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
            }
            else
            {
                $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
                $data = $this->_array_unshift_assoc($data[0], 'criteria', $criteria);
            }
            $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
                $projectTotalsList[] = $data;
        }
        $response["success"] = 1;
        $response["data"] = $projectTotalsList;
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

    public function getCurrentStatusSummary()
    {
        $formData = $this->input->post();
        $system = $formData["system"];
        $management = $formData["management"];
        $currentStatusSummary = Model_project::projectCurrentStatusSummary($system, $management);
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
        echo json_encode($response);exit;
    }

    public function getExecutiveSummary()
    {
        $formData = $this->input->post();
        $system = $formData["system"];
        $management = $formData["management"];
        $currentStatusSummary = Model_project::projectCurrentStatusSummary($system, $management);
        $reportSections = array(
            "recentlyCreated" => array("title" => "Solo registro", "keywords" => array("project_has_been_created")),
            "readyToDesign" => array("title" => "Listo para diseño", "keywords" => array("design")),
            "design" => array("title" => "Diseño", "keywords" => array("stakes", "digitization", "drawing")),
            "alreadySent" => array("title" => "Camino", "keywords" => array("schedule", "ready_to_send", "already_sent")),
            "inProgress" => array("title" => "Construccion", "keywords" => array("assign_to", "approved", "in_progress", "paused","stopped")),
            "closure" => array("title" =>"Cierre", "keywords" => array("completed", "as_built","conciliation_reception", "conciliation_shipment","cre_return_order")),
            "closed" => array("title" => "Cerrado", "keywords" => array("project_return_materials"))
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

        foreach ($reportSections as $groupKey => $data)
        {
            $totalPercentageProjectsBySection = ($reportSections[$groupKey]["totalProjectsBySection"]*100) / $totalProjects;
            $reportSections[$groupKey]["totalPercentageProjectsBySection"] = number_format($totalPercentageProjectsBySection,2);

            $totalApprovedBudgetBySection = $reportSections[$groupKey]["totalApprovedBudgetBySection"];
            $totalPercentageApprovedBudgetBySection = $totalApprovedBudgetBySection <= 0?0:($totalApprovedBudgetBySection*100) / $totalApprovedBudget;
            $reportSections[$groupKey]["totalPercentageApprovedBudgetBySection"] = number_format($totalPercentageApprovedBudgetBySection,2);
        }

        echo json_encode(array_values($reportSections));exit;
        $arrayData = array();
        $totalApprovedBudget = 0;
        $totalRealBudget = 0;
        $totalProjects = 0;
        $arrayResponse = array();
        $singleList = array();
        foreach ($currentStatusSummary as $summary)
        {
            $singleList =

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

            if($summary["keyword"] = "design")
            {

            }
        }
        $response["success"] = 1;
        $response["data"]["list"] = $arrayData;
        $response["data"]["totalApprovedBudgets"] = number_format($totalApprovedBudget,2);
        $response["data"]["totalRealBudgets"] = number_format($totalRealBudget,2);
        $response["data"]["totalProjects"] = $totalProjects;
        echo json_encode($response);exit;
    }
}