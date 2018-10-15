<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelConciliatedProjectsByYearAndMonth
{
    private $_sessionUser;
	public function __construct($sessionUser)
	{
        $this->_sessionUser = $sessionUser;
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $conciliatedProjectsByYearAndMonth = Model_project::getConciliatedProjectsByYearAndMonth();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("conciliated projects by year and month")
            ->setSubject("Project report")
            ->setDescription("This report allow see the conciliated projects detailed by year and month. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("report new projects month year")
            ->setCategory("Report");
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "AÑO")
            ->setCellValue('B1', "ENERO")
            ->setCellValue('C1', "FEBRERO")
            ->setCellValue('D1', "MARZO")
            ->setCellValue('E1', "ABRIL")
            ->setCellValue('F1', "MAYO")
            ->setCellValue('G1', "JUNIO")
            ->setCellValue('H1', "JULIO")
            ->setCellValue('I1', "AGOSTO")
            ->setCellValue('J1', "SEPTIEMBRE")
            ->setCellValue('K1', "OCTUBRE")
            ->setCellValue('L1', "NOVIEMBRE")
            ->setCellValue('M1', "DICIEMBRE");

        $i = 1;
        foreach ($conciliatedProjectsByYearAndMonth as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["year"])
                ->setCellValue('B'.($i+1), $row["january"])
                ->setCellValue('C'.($i+1), $row["february"])
                ->setCellValue('D'.($i+1), $row["march"])
                ->setCellValue('E'.($i+1), $row["april"])
                ->setCellValue('F'.($i+1), $row["may"])
                ->setCellValue('G'.($i+1), $row["june"])
                ->setCellValue('H'.($i+1), $row["july"])
                ->setCellValue('I'.($i+1), $row["august"])
                ->setCellValue('J'.($i+1), $row["september"])
                ->setCellValue('K'.($i+1), $row["october"])
                ->setCellValue('L'.($i+1), $row["november"])
                ->setCellValue('M'.($i+1), $row["december"]);
            $i++;
        }
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="conciliated_projects_by_year_and_month.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}
}