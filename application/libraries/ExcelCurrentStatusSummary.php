<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelCurrentStatusSummary
{
    private $_sessionUser;
    private $_system;
    private $_managementBy;
	public function __construct($sessionUser, $system = "", $managementBy = "")
	{
        $this->_sessionUser = $sessionUser;
        $this->_system = $system;
        $this->_managementBy = $managementBy;
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $currentStatusSummary = Model_project::projectCurrentStatusSummary($this->_system, $this->_managementBy);
        $spreadsheet = new Spreadsheet();
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Current status project summary report")
            ->setSubject("Project report")
            ->setDescription("This report allow see the total project by status and his budgets(approved and real). Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("current status project summary report")
            ->setCategory("Report");

        $this->_header($spreadsheet);
        $i = 1;
        $totalApprovedBudget = 0;
        $totalRealBudget = 0;
        $totalProjects = 0;
        foreach ($currentStatusSummary as $row)
        {
            $totalApprovedBudget += $row["keyword"] !="canceled"?$row["approved_budgets"]:"0";
            $totalRealBudget += $row["keyword"] !="canceled"?$row["real_budgets"]:"0";
            $totalProjects += $row["total_projects"];
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["status_name"])
                ->setCellValue('B'.($i+1), $row["total_projects"])
                ->setCellValue('C'.($i+1), $row["approved_budgets"])
                ->setCellValue('D'.($i+1), $row["real_budgets"]);
            $this->_highlightRow($spreadsheet,$i+1, $row["keyword"]);
            $i++;
        }
        $this->_footer($spreadsheet, $i, $totalProjects, $totalApprovedBudget, $totalRealBudget);
        $this->_currencyFormatNumber($spreadsheet, $i+1);
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="current_status_summary_report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}

	private function _header($spreadsheet)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "ESTADO")
            ->setCellValue('B1', "TOTAL")
            ->setCellValue('C1', "IMPORTE APROBADO")
            ->setCellValue('D1', "IMPORTE REAL");
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    }

    private function _footer($spreadsheet, $totalRows, $totalProjects, $totalApprovedBudget, $totalRealBudget)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.($totalRows+1), "TOTAL")
            ->setCellValue('B'.($totalRows+1), $totalProjects)
            ->setCellValue('C'.($totalRows+1), $totalApprovedBudget)
            ->setCellValue('D'.($totalRows+1), $totalRealBudget);
        $spreadsheet->getActiveSheet()->getStyle('A'.($totalRows+1).':D'.($totalRows+1))->applyFromArray($titleStyleArray);
    }

    private function _currencyFormatNumber($spreadsheet, $totalRows)
    {
        $columnList = array("C","D");

        foreach($columnList as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getStyle($column.'2:'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        }
    }

    private function _highlightRow($spreadsheet, $currentRow, $keyword)
    {
        $colors = array(
            "79B9D3" => array("already_sent", "as_built", "conciliation_shipment"),
            "FFFF00" => array("approved", "assigned_to", "completed", "conciliation_reception", "cre_return_order"),
            "FF0000" => array("canceled", "returned")
        );

        foreach ($colors as $color => $statusList)
        {
            if(array_search($keyword, $statusList) !== FALSE)
            {
                $spreadsheet->getActiveSheet()->getStyle('A'.$currentRow.':D'.$currentRow)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A'.$currentRow.':D'.$currentRow)
                    ->getFill()->getStartColor()->setARGB($color);
            }
        }
    }
}