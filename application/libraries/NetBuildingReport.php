<?php
//require_once('tcpdf/examples/tcpdf_include.php');
require_once('tcpdf/tcpdf.php');
//class NetBuildingReport extends TCPDF
//{
//    public function printReport()
//    {
//        require_once('tcpdf/tcpdf.php');
//
//        // create new PDF document
//        $pdf = new TCPDF('L', PDF_UNIT, 'letter', true, 'UTF-8', false);
//
//        // set document information
//        $pdf->SetCreator('PANEL SEREBO');
//        $pdf->SetAuthor('Nicola Asuni');
//        $pdf->SetTitle('REPORTE MENSUAL');
//        $pdf->SetSubject('Resumen de totales y ejecutivo');
//        $pdf->SetKeywords('PDF, resumen, totales, ejecutivo');
//
//        // set default header data
////        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);
//
//        // set header and footer fonts
//        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//        // set default monospaced font
//        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//        // set margins
//        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//
//        // set auto page breaks
//        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//
//        // set image scale factor
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//
//        // -------------------------------------------------------------------
//
//        // add a page
//        $pdf->AddPage();
//
//        // set JPEG quality
//        $pdf->setJPEGQuality(100);
//        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//
//        // Example of Image from data stream ('PHP rules')
//        $imgdata = base64_decode('iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABlBMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDrEX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==');
//        ####################################################
//        $jpGraphHandler = new JPGraphHandler();
//        $jpGraphHandler->setShowInSource();
//        $graphData = $jpGraphHandler->printPieChart3D();
//        ####################################################
//        // The '@' character is used to indicate that follows an image data stream and not an image file name
//        $pdf->Image('@'.$graphData,30,50,0,0,'jpeg','','',false);
//
//        //Close and output PDF document
//        $pdf->Output('example_009.pdf', 'I');
//    }
//}
class NetBuildingReport extends TCPDF
{
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
//        var_dump(FCPATH."/assets/images");exit;
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
    }

    // Load table data from file
    public function LoadData()
    {
        $data = array();
        for($i=0;$i<10;$i++)
        {
            $data[$i] = array(rand(1,99), rand(1,99), rand(1,99), rand(1,99), rand(1,99), rand(1,99));
        }
        return $data;
    }

    public function cover()
    {
        $this->SetFont('', 'B',40);
        $this->SetY(90);
        $this->Cell("",6,"Construccion De Redes",0,1,"C");
        $this->SetFont('', 'B',15);
        $this->Cell("",6,date("d/m/Y"),0,1,"C");
        $this->Ln();
    }

    public function executiveSummary()
    {
        $this->SetFont('', 'B',20);
        $this->Cell("",6,"Resumen Ejecutivo",0,1,"C");
        $this->Ln();

        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('helvetica', 'B', 12);
        //Current Status summary
        $response = Model_project::prepareCurrentStatusSummaryArray();
        $i = 0;
        $data = $response["data"]["list"];
        $this->MultiCell(40,8,"STATUS",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"B");
        $this->MultiCell(17,8,"TOTAL",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell(30,8,"APROBADO",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell(30,8,"CONCILIADO",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->Ln();
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 12);
        foreach($data as $row)
        {
            //write text first
            $startX = $this->GetX();
            $startY = $this->GetY();
            $this->SetXY($startX, $startY);
            $marginBottom = ($i+1) == count($data);
            //now do borders and fill
            $this->MultiCell(40,6,$row["statusName"],'LTR'.$marginBottom,'L',0,0);
            $this->MultiCell(17,6,$row["totalProjects"],'LTR'.$marginBottom,'C',0,0);
            $this->MultiCell(30,6,$row["approvedBudgets"],'LTR'.$marginBottom,'R',0,0);
            $this->MultiCell(30,6,$row["realBudgets"],'LTR'.$marginBottom,'R',0,0);
            $this->Ln();
            $i++;
        }

        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('helvetica', 'B', 12);
        $response = Model_project::prepareExecutiveSummaryArray();
        $j = 0;
        $data = $response["list"];
        $this->SetXY(140, 45);
        $this->MultiCell(40,8,"ETAPA",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"B");
        $this->MultiCell(17,8,"TOTAL",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell(15,8,"%",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell(30,8,"APROBADO",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell(17,8,"%",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->MultiCell(25,8,"% CONTR.",'LTR','C',1,0,"","",TRUE,0,FALSE,TRUE,0,"M");
        $this->Ln();
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 12);
        foreach($data as $row)
        {
//            echo"<pre>";var_dump($row);exit;
            //write text first
            $startX = 140;
            $startY = $j == 0?53:$this->GetY();
            $this->SetXY($startX, $startY);
            $marginBottom = ($j+1) == count($data);
            //now do borders and fill
            //cell height is 6 times the max number of cells
            $this->MultiCell(40,6, $row["title"],'LTR'.$marginBottom,'L',0,0);
            $this->MultiCell(17,6,$row["totalProjectsBySection"],'LTR'.$marginBottom,'C',0,0);
            $this->MultiCell(15,6,$row["totalPercentageProjectsBySection"],'LTR'.$marginBottom,'R',0,0);
            $this->MultiCell(30,6,$row["totalApprovedBudgetBySection"],'LTR'.$marginBottom,'R',0,0);
            $this->MultiCell(17,6,$row["totalPercentageApprovedBudgetBySection"],'LTR'.$marginBottom,'R',0,0);
            $this->MultiCell(25,6,$row["contractAmountPercentageBySection"],'LTR'.$marginBottom,'R',0,0);
            $this->Ln();
            $j++;
        }
    }

    public function monthlyProjectsUnits($header,$data)
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
        $this->SetX(30);
        // Header
        $w = array(19, 22, 19, 18, 18, 18, 18, 19, 19, 19, 19, 19);
        $h = 5;
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
            $this->SetX(30);
            $this->Cell($w[0], $h, $row[0], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], $h, $row[1], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], $h, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[5], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], $h, $row[0], 'LR', 0, 'C', $fill);
            $this->Cell($w[7], $h, $row[1], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], $h, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[9], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[10], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[11], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->SetX(30);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
    }

    public function monthlyProjectsAmounts($header,$data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B',12);
        $this->SetX(30);
        // Header
        $w = array(19, 22, 19, 18, 18, 18, 18, 19, 19, 19, 19, 19);
        $h = 5;
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
        $this->SetX(30);
        foreach($data as $row)
        {
            $this->SetX(30);
            $this->Cell($w[0], $h, $row[0], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], $h, $row[1], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], $h, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[5], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], $h, $row[0], 'LR', 0, 'C', $fill);
            $this->Cell($w[7], $h, $row[1], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], $h, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[9], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[10], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Cell($w[11], $h, $row[3], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->SetX(30);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
    }

    public function charts()
    {
        // Example of Image from data stream ('PHP rules')
        $jpGraphHandler = new JPGraphHandler();
        $jpGraphHandler->setShowInSource();
        $graphData = $jpGraphHandler->printPieChart3D();
        // The '@' character is used to indicate that follows an image data stream and not an image file name
        $this->Image('@'.$graphData,30,40,0,0,'jpeg','','',false);
        $this->Image('@'.$graphData,150,40,0,0,'jpeg','','',false);
        $this->Image('@'.$graphData,95,105,0,0,'jpeg','','',false);
    }

    public function printReport()
    {
        $data = $this->LoadData();
        $header = array('ENERO', 'FEBRERO', 'MARZO','ABRIL','MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPT','OCT','NOV', 'DIC');
        // add a page
        $this->AddPage();
        $this->cover();
        $this->AddPage();
        $this->executiveSummary();
        $this->AddPage();
        $this->monthlyProjectsUnits($header, $data);
        $this->monthlyProjectsAmounts($header, $data);
        $this->AddPage();
        $this->charts();

        // ---------------------------------------------------------

        // close and output PDF document
        $this->Output('example_011.pdf', 'I');
    }
}

// create new PDF document
//$pdf = new NetBuildingReport();


