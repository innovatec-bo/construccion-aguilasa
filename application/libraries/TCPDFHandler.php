<?php
class TCPDFHandler
{
	public function __construct()
	{
	}

	public function test()
    {
        require_once('tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, 'letter', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator('PANEL SEREBO');
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('REPORTE MENSUAL');
        $pdf->SetSubject('Resumen de totales y ejecutivo');
        $pdf->SetKeywords('PDF, resumen, totales, ejecutivo');

        // set default header data
//        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // -------------------------------------------------------------------

        // add a page
        $pdf->AddPage();

        // set JPEG quality
        $pdf->setJPEGQuality(100);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // Example of Image from data stream ('PHP rules')
        $imgdata = base64_decode('iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABlBMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDrEX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==');
        ####################################################
        $jpGraphHandler = new JPGraphHandler();
        $jpGraphHandler->setShowInSource();
        $graphData = $jpGraphHandler->printPieChart3D();
        ####################################################
        // The '@' character is used to indicate that follows an image data stream and not an image file name
        $pdf->Image('@'.$graphData,30,50,0,0,'jpeg','','',false);

        //Close and output PDF document
        $pdf->Output('example_009.pdf', 'I');
    }
}