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
        $currentStatusSummary = Model_project::projectCurrentStatusSummary();
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
}