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
            $data = Model_project::getStatusQuantityDetailByYear($keyword, $year);
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
            'already_sent' => array(
                                                'digitizationPoints' => 'DISEÑO - PUNTOS',
                                                'digitizationDistance' => 'DISEÑO - DISTANCIA'
                                            ),
            'approved' => array(
//                                    'countId' => 'TOTALES',
                                    'sumDesignBudget' => 'IMPORTE DISEÑO',
                                    'sumBuildingBudget' => 'IMPORTE CONSTRUCCION',
                                    'sumTransportationBudget' => 'IMPORTE TRANSPORTE',
                                    'sumLiveLineBudget' => 'IMPORTE LINEA VIVA',
                                    'sumRightOfWayBudget' => 'IMPORTE DERECHO DE VIA',
                                    'sumBudget' => 'TOTAL IMPORTE'
                                ),
            'conciliation_shipment' => array(
                                    'sumDesignRealBudget' => 'IMPORTE REAL - DISEÑO',
                                    'sumBuildingRealBudget' => 'IMPORTE REAL - CONSTRUCCION',
                                    'sumTransportationRealBudget' => 'IMPORTE REAL - TRANSPORTE',
                                    'sumLiveLineRealBudget' => 'IMPORTE REAL - LINEA VIVA',
                                    'sumRightOfWayRealBudget' => 'IMPORTE REAL - DERECHO DE VIA',
                                    'sumRealBudget' => 'TOTAL IMPORTE REAL'
                                )
            );
        $projectTotalsList = array();
        //begin - Adding total column
        $data = Model_project::getStatusQuantityDetailByYear($mainList, $year);
        if(count($data) >= 1)
        {
            $data = $this->_array_unshift_assoc($data[0], 'criteria', "TOTALES");
        }
        else
        {
            $data[0] = array('january' => 0, 'february' => 0, 'march' => 0, 'april' => 0, 'may' => 0, 'june' => 0, 'july' => 0, 'august' => 0, 'september' => 0, 'october' => 0, 'november' => 0, 'december' => 0);
            $data = $this->_array_unshift_assoc($data[0], 'criteria', "TOTALES");
        }
        $data['total'] = $data['january'] + $data['february'] + $data['march'] + $data['april'] + $data['may'] + $data['june'] + $data['july'] + $data['august'] + $data['september'] + $data['october'] + $data['november'] + $data['december'];
        $projectTotalsList[] = $data;
        //end - adding total column
        foreach($reportSections as $keyword => $columnTypeList)
        {
            foreach ($columnTypeList as $rowKey => $criteria)
            {
                $data = Model_project::getStatusQuantityDetailByYear($keyword, $year, $rowKey, $mainList);
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
}