<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelCurrentStatusSummary
{
    private $_sessionUser;
	public function __construct($sessionUser)
	{
        $this->_sessionUser = $sessionUser;
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $currentStatusSummary = Model_project::projectCurrentStatusSummary();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Current status project summary report")
            ->setSubject("Project report")
            ->setDescription("This report allow see the total project by status and his budgets(approved and real). Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("current status project summary report")
            ->setCategory("Report");
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "ESTADO")
            ->setCellValue('B1', "TOTAL")
            ->setCellValue('C1', "IMPORTE APROBADO")
            ->setCellValue('D1', "IMPORTE REAL");

        $i = 1;
        foreach ($currentStatusSummary as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["status_name"])
                ->setCellValue('B'.($i+1), $row["total_projects"])
                ->setCellValue('C'.($i+1), $row["approved_budgets"])
                ->setCellValue('D'.($i+1), $row["real_budgets"]);
            $i++;
        }
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="current_status_summary_report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}
}