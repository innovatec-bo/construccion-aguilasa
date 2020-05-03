<?php
//require_once('tcpdf/examples/tcpdf_include.php');
require_once('tcpdf/tcpdf.php');
class NetBuildingReportPDF extends TCPDF
{
    private $_netBuildingReportChart;

    public function __construct($orientation='L', $unit='mm', $format='Letter', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        // set document information
        $this->SetCreator('PANEL SEREBO');
        $this->SetAuthor('Nicola Asuni');
        $this->SetTitle('REPORTE MENSUAL');
        $this->SetSubject('Resumen de totales y ejecutivo');
        $this->SetKeywords('PDF, resumen, totales, ejecutivo');

        // set default header data
        $this->SetHeaderData("logo.png", 46, 'SEREBO', 'REPORTE DE CONSTRUCCION DE REDES');

        // set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------
        // set font
        $this->SetFont('helvetica', '', 12);
        $this->_netBuildingReportChart = new NetBuildingReportChart();
        $this->_netBuildingReportChart->setShowInSource();
    }

    private function _cover()
    {
        $this->SetFont('', 'B',40);
        $this->SetY(90);
        $this->Cell("",6,"Construccion De Redes",0,1,"C");
        $this->SetFont('', 'B',15);
        $this->Cell("",6,date("d/m/Y"),0,1,"C");
        $this->Ln();
    }

    private function _currentStatusSummary($data, $title = "Resumen Ejecutivo")
    {
        $this->SetTextColor(0);
        $this->SetFont('', 'B',20);
        $this->Cell("",6, $title,0,1,"C");
        $this->Ln();
		$this->SetFont('', 'B',11);
		$this->Cell("",6, html_entity_decode("Los montos con signo de admiraci&oacute;n(!) no son incluidos en la suma."),0,1,"L");
		$this->Ln();
        $w = array(40, 17, 30, 30);
        $h = 7;
        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('helvetica', 'B', 11);
        //Current Status summary
        $i = 0;
        $this->MultiCell($w[0],$h,"STATUS",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"B");
        $this->MultiCell($w[1],$h,"TOTAL",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell($w[2],$h,"APROBADO",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell($w[3],$h,"CONCILIADO",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->Ln();
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 9);
        $fill = 0;

        $statusToNotSum = array('ready_to_send','already_sent','canceled');
        foreach($data["list"] as $row)
        {
        	$notSum = array_search($row['keyword'], $statusToNotSum) !== FALSE?" (!) ":"";
            //write text first
            $startX = $this->GetX();
            $startY = $this->GetY();
            $this->SetXY($startX, $startY);
            $marginBottom = ($i+1) == count($data);
            //now do borders and fill
            $this->MultiCell($w[0],$h-2, $row["statusName"],'LR'.$marginBottom,'L',$fill,0);
            $this->MultiCell($w[1],$h-2, $row["totalProjects"],'LR'.$marginBottom,'C',$fill,0);
            $this->MultiCell($w[2],$h-2, $notSum.$row["approvedBudgets"],'LR'.$marginBottom,'R',$fill,0);
            $this->MultiCell($w[3],$h-2, $row["realBudgets"],'LR'.$marginBottom,'R',$fill,0);
            $this->Ln();
            $fill=!$fill;
            $i++;
        }
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('helvetica', '', 11);
        $startX = $this->GetX();
        $startY = $this->GetY();
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->SetXY($startX, $startY);
        $this->MultiCell($w[0],$h-1, "TOTAL",'LRB','C',1,0);
        $this->MultiCell($w[1],$h-1, $data["totalProjects"],'LRB','C',1,0);
        $this->MultiCell($w[2],$h-1, $data["totalApprovedBudgets"],'LRB','C',1,0);
        $this->MultiCell($w[3],$h-1, $data["totalRealBudgets"],'LRB','R',1,0);
        $this->Ln();

    }

    private function _executiveSummary($data)
    {
        $w = array(40, 17, 15, 30, 17, 25);
        $h = 8;
        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('helvetica', 'B', 12);

        $j = 0;
        $this->Ln();
        $this->SetXY(140, 56.6);
        $this->MultiCell($w[0],$h,"ETAPA",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"B");
        $this->MultiCell($w[1],$h,"TOTAL",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell($w[2],$h,"%",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell($w[3],$h,"APROBADO",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell($w[4],$h,"%",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell($w[5],$h,"% CONTR.",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->Ln();
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 12);
        $fill = 0;
        $startX = 140;
		$statusToNotSum = array('alreadySent');
        foreach($data["list"] as $row)
        {
			$notSum = array_search($row['section'], $statusToNotSum) !== FALSE?" (!) ":"";
            //write text first
            $startY = $j == 0?65:$this->GetY();
            $this->SetXY($startX, $startY);
            $marginBottom = ($j+1) == count($data);
            //now do borders and fill
            //cell height is 6 times the max number of cells
            $this->MultiCell($w[0], $h, $row["title"],'LR'.$marginBottom,'L', $fill,0);
            $this->MultiCell($w[1], $h,$row["totalProjectsBySection"],'LR'.$marginBottom,'C', $fill,0);
            $this->MultiCell($w[2], $h,$row["totalPercentageProjectsBySection"],'LR'.$marginBottom,'R', $fill,0);
            $this->MultiCell($w[3], $h,$notSum.$row["totalApprovedBudgetBySection"],'LR'.$marginBottom,'R', $fill,0);
            $this->MultiCell($w[4], $h,$row["totalPercentageApprovedBudgetBySection"],'LR'.$marginBottom,'R', $fill,0);
            $this->MultiCell($w[5], $h,$row["contractAmountPercentageBySection"],'LR'.$marginBottom,'R', $fill,0);
            $this->Ln();
            $fill=!$fill;
            $j++;
        }
        $this->SetX($startX);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('helvetica', '', 11);
        $this->SetX($startX);
        $this->MultiCell($w[0],$h-1, "TOTAL",'LRB','C',1,0);
        $this->MultiCell($w[1],$h-1, $data["totalProjects"],'LRB','C',1,0);
        $this->MultiCell($w[2],$h-1, $data["totalPercentageProjects"],'LRB','C',1,0);
        $this->MultiCell($w[3],$h-1, $data["totalApprovedBudget"],'LRB','R',1,0);
        $this->MultiCell($w[4],$h-1, $data["totalPercentageApprovedBudget"],'LRB','R',1,0);
        $this->MultiCell($w[5],$h-1, $data["totalContractAmountPercentage"],'LRB','R',1,0);
        $this->Ln();
    }

    private function _monthlyProjectsUnits($data, $header)
    {
        $this->SetFont('', 'B',20);
        $this->Cell("",6,"Proyectos Mensuales",0,1,"C");
        $this->Ln();
        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B',12);
        $this->SetX(22);
        // Header
        $w = array(35, 19, 22, 19, 18, 18, 18, 18, 19, 13, 13, 13, 13, 13);
        $h = 7;
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row)
        {
            $this->SetX(22);
            $this->Cell($w[0], $h, $row["criteria"], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], $h, $row["january"], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], $h, $row["february"], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], $h, $row["march"], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], $h, $row["april"], 'LR', 0, 'C', $fill);
            $this->Cell($w[5], $h, $row["may"], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], $h, $row["june"], 'LR', 0, 'C', $fill);
            $this->Cell($w[7], $h, $row["july"], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], $h, $row["august"], 'LR', 0, 'C', $fill);
            $this->Cell($w[9], $h, $row["september"], 'LR', 0, 'C', $fill);
            $this->Cell($w[10], $h, $row["october"], 'LR', 0, 'C', $fill);
            $this->Cell($w[11], $h, $row["november"], 'LR', 0, 'C', $fill);
            $this->Cell($w[12], $h, $row["december"], 'LR', 0, 'C', $fill);
            $this->Cell($w[13], $h, $row["total"], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->SetX(22);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
        $this->Ln();
        $this->Ln();
    }

    private function _monthlyProjectsAmounts($data, $header)
    {
        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B',8);
        $this->SetX(18);
        // Header
        $w = array(24, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18, 20);
        $h = 7;
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('','',8);
        // Data
        $fill = 0;
        foreach($data as $row)
        {
            $this->SetX(18);
            $this->Cell($w[0], $h, $row["criteria"], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], $h, $row["january"], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], $h, $row["february"], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], $h, $row["march"], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], $h, $row["april"], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], $h, $row["may"], 'LR', 0, 'R', $fill);
            $this->Cell($w[6], $h, $row["june"], 'LR', 0, 'R', $fill);
            $this->Cell($w[7], $h, $row["july"], 'LR', 0, 'R', $fill);
            $this->Cell($w[8], $h, $row["august"], 'LR', 0, 'R', $fill);
            $this->Cell($w[9], $h, $row["september"], 'LR', 0, 'R', $fill);
            $this->Cell($w[10], $h, $row["october"], 'LR', 0, 'R', $fill);
            $this->Cell($w[11], $h, $row["november"], 'LR', 0, 'R', $fill);
            $this->Cell($w[12], $h, $row["december"], 'LR', 0, 'R', $fill);
            $this->Cell($w[13], $h, $row["total"], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->SetX(18);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
    }

    private function _charts($executiveSummary)
    {
        $units = $this->_netBuildingReportChart->printExecutiveSummary($executiveSummary);
        $approvedBudgets = $this->_netBuildingReportChart->printExecutiveSummary($executiveSummary, "totalApprovedBudgetBySection");
        $contractPercentage = $this->_netBuildingReportChart->printExecutiveSummary($executiveSummary, "contractAmountPercentageBySection");
        // The '@' character is used to indicate that follows an image data stream and not an image file name
        $this->Image('@'.$units,30,25,120,0,'jpeg','','',false);
        $this->Image('@'.$approvedBudgets,160,25,120,0,'jpeg','','',false);
        $this->Image('@'.$contractPercentage,95,105,120,0,'jpeg','','',false);
    }

    public function printReport($dest = "I")
    {
        $header = array('CRITERIO', 'ENERO', 'FEBRERO', 'MARZO','ABRIL','MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPT','OCT','NOV', 'DIC', 'TOTAL');
        // add a page
        $this->AddPage();
        $this->_cover();
        $this->AddPage();
        
        $currentStatusSummaryData = Model_project::prepareCurrentStatusSummaryArray();
        $data = $currentStatusSummaryData["data"];
        $this->_currentStatusSummary($data);
        $executiveSummary = Model_project::prepareExecutiveSummaryArray();
        $this->_executiveSummary($executiveSummary);
        $this->AddPage();
        
        $contractList = Model_contract::getAll(100,0);

        foreach($contractList as $contract)
        {
            $currentStatusSummaryData = Model_project::prepareCurrentStatusSummaryArray("","",$contract->id_con);
            $data = $currentStatusSummaryData["data"];
            $this->_currentStatusSummary($data, "Resumen Ejecutivo - Contrato ".$contract->contract_number_con);
            $executiveSummary = Model_project::prepareExecutiveSummaryArray("","",$contract->id_con);
            $this->_executiveSummary($executiveSummary);
            $this->AddPage();    
        }
        
        $response = Model_project::prepareProjectTotalsTableArray(date("Y"), "countId", "");
        $data = $response["data"];
        $this->_monthlyProjectsUnits($data, $header);
        $response = Model_project::prepareProjectTotalsTableArray(date("Y"), "sumBudget", "");
        $data = $response["data"];
        $this->_monthlyProjectsAmounts($data, $header);
        $this->AddPage();
        
        $this->_charts($executiveSummary);
        // ---------------------------------------------------------
        // close and output PDF document
        $this->Output(FCPATH.'assets/documents/ReporteDeConstruccionDeRedes_'.date("Y-m-d").'.pdf', $dest);
    }
}
