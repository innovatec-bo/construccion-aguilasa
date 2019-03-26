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
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('Nicola Asuni');
        $this->SetTitle('TCPDF Example 011');
        $this->SetSubject('TCPDF Tutorial');
        $this->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

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
        for($i=0;$i<15;$i++)
        {
            $data[$i] = array("Pais ".$i, "Capital ".$i, "Area ".$i, $i, $i, $i);
        }
        return $data;
    }

    // Colored table
    public function executiveSummary($header,$data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B',8);
        // Header
        $w = array(35, 20, 30, 20);
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
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
    }

    public function monthlyProjects($header,$data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(15, 38, 58);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(35, 20, 10, 30, 10, 20);
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
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    public function charts()
    {
        // Example of Image from data stream ('PHP rules')
        $jpGraphHandler = new JPGraphHandler();
        $jpGraphHandler->setShowInSource();
        $graphData = $jpGraphHandler->printPieChart3D();
        // The '@' character is used to indicate that follows an image data stream and not an image file name
        $this->Image('@'.$graphData,30,50,0,0,'jpeg','','',false);
    }

    public function printReport()
    {
        // add a page
        $this->AddPage();

        // column titles
        $header1 = array('Status', 'Total', 'Monto Aprobado', 'Monto Concili.');
        $header2 = array('ETAPA', 'TOTAL', '%','MONTO APROBADO','%', '% CONTRATO');

        // data loading
        $data = $this->LoadData();

        // print colored table
        $this->executiveSummary($header1, $data);
        $this->monthlyProjects($header2, $data);
        $this->charts();

        // ---------------------------------------------------------

        // close and output PDF document
        $this->Output('example_011.pdf', 'I');
    }
}

// create new PDF document
//$pdf = new NetBuildingReport();


