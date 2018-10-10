<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelProjectWorkflow
{
    private $_sessionUser;
	public function __construct($sessionUser)
	{
        $this->_sessionUser = $sessionUser;
	}

	function getReport()
	{
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';

        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $headerStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $projectWorkflow = Model_project::getWorkflowDetail();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Workflow report")
            ->setSubject("Project report")
            ->setDescription("This report allow see all workflow form all projects on system. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("report workflow projects")
            ->setCategory("Report");

        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('B1', "INGRESO DE PROYECTOS");
        $spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('B1:M1');

        $spreadsheet->setActiveSheetIndex(0)

            ->setCellValue('A2', "ESTADO")
            ->setCellValue('B2', "CODIGO")
            ->setCellValue('C2', "FECHA INGRESO")
            ->setCellValue('D2', "FECHA CARPETA")
            ->setCellValue('E2', "FISCAL DE CRE")
            ->setCellValue('F2', "SISTEMA")
            ->setCellValue('G2', "ADMINISTRADO POR")
            ->setCellValue('H2', "DIRECCION")
            ->setCellValue('I2', "PUNTOS")
            ->setCellValue('J2', "DISTANCIA")
            ->setCellValue('K2', "NIVEL DE CALIDAD")
            ->setCellValue('L2', "POSICION PRESUPUESTARIA")
            ->setCellValue('M2', "FECHA COMPLETADO DE DISEÑO")
            ->setCellValue('N2', "FECHA COMPLETADO DE CONSTRUCCION");
        $spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($headerStyleArray);

        $i = 2;
        foreach ($projectWorkflow as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["status_pro"])
                ->setCellValue('B'.($i+1), $row["code_pro"])
                ->setCellValue('C'.($i+1), $row["entry_date_pro"])
                ->setCellValue('D'.($i+1), $row["folder_date_pro"])
                ->setCellValue('E'.($i+1), $row["cre_fiscal_pro"])
                ->setCellValue('F'.($i+1), $row["system_pro"])
                ->setCellValue('G'.($i+1), $row["management_by_pro"])
                ->setCellValue('H'.($i+1), $row["address_pro"])
                ->setCellValue('I'.($i+1), $row["points_pro"])
                ->setCellValue('J'.($i+1), $row["distance_pro"])
                ->setCellValue('K'.($i+1), $row["quality_level_pro"])
                ->setCellValue('L'.($i+1), $row["budgetary_position_pro"])
                ->setCellValue('M'.($i+1), $row["cre_design_completion_date_pro"])
                ->setCellValue('N'.($i+1), $row["cre_building_completion_date_pro"]);
            $i++;
        }
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="projects_workflow.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}
}