<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelOrderNumberAndTotalsByYearAndMonth
{
    private $_sessionUser;
	public function __construct($sessionUser)
	{
        $this->_sessionUser = $sessionUser;
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $orderNumberAndTotalsByYearAndMonth = Model_project::getOrderNumberAndTotalsByYearAndMonth();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Order number and totals by year and month")
            ->setSubject("Project report")
            ->setDescription("This report allow see the order number and totals detailed by year and month. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("report as order number and totals month year")
            ->setCategory("Report");
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "FECHA")
            ->setCellValue('B1', "CODIGO")
            ->setCellValue('C1', "IMPORTE DISEÑO")
            ->setCellValue('D1', "IMPORTE CONSTRUCCION")
            ->setCellValue('E1', "IMPORTE TRANSPORTE")
            ->setCellValue('F1', "IMPORTE LINEA VIVA")
            ->setCellValue('G1', "IMPORTE DERECHO DE VIA")
            ->setCellValue('H1', "IMPORTE REAL DISEÑO")
            ->setCellValue('I1', "IMPORTE REAL CONSTRUCCION")
            ->setCellValue('J1', "IMPORTE REAL TRANSPORTE")
            ->setCellValue('K1', "IMPORTE REAL LINEA VIVA")
            ->setCellValue('L1', "IMPORTE REAL DERECHO DE VIA");

        $i = 1;
        foreach ($orderNumberAndTotalsByYearAndMonth as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["date"])
                ->setCellValue('B'.($i+1), $row["code_pro"])
                ->setCellValue('C'.($i+1), $row["design_budget"])
                ->setCellValue('D'.($i+1), $row["building_budget"])
                ->setCellValue('E'.($i+1), $row["transportation_budget"])
                ->setCellValue('F'.($i+1), $row["live_line_budget"])
                ->setCellValue('G'.($i+1), $row["right_of_way_budget"])
                ->setCellValue('H'.($i+1), $row["design_real_budget"])
                ->setCellValue('I'.($i+1), $row["building_real_budget"])
                ->setCellValue('J'.($i+1), $row["transportation_real_budget"])
                ->setCellValue('K'.($i+1), $row["live_line_real_budget"])
                ->setCellValue('L'.($i+1), $row["right_of_way_real_budget"]);
            $i++;
        }
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="order_number_and_totals_by_year_and_month.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}
}