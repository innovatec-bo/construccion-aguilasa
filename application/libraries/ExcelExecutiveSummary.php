<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExcelExecutiveSummary
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

        $executiveSummary = $this->_getData();
        $spreadsheet = new Spreadsheet();
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("executive summary report")
            ->setSubject("Project report")
            ->setDescription("This report allow see the total over workflow sections and his budgets. Report generated on ".date("Y-m-d H:i:s"))
            ->setKeywords("executive summary report")
            ->setCategory("Report");

        $this->_header($spreadsheet);
        $i = 1;
        foreach ($executiveSummary["list"] as $row)
        {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+1), $row["title"])
                ->setCellValue('B'.($i+1), $row["totalProjectsBySection"])
                ->setCellValue('C'.($i+1), $row["totalPercentageProjectsBySection"])
                ->setCellValue('D'.($i+1), $row["totalApprovedBudgetBySection"])
                ->setCellValue('E'.($i+1), $row["totalPercentageApprovedBudgetBySection"]);
            $this->_highlightRow($spreadsheet,$i+1, $row["section"]);
            $i++;
        }
        $this->_footer($spreadsheet, $i, $executiveSummary);
        $this->_currencyFormatNumber($spreadsheet, $i+1);
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="executive_summary_report.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}

	private function _header($spreadsheet)
    {
        $titleStyleArray = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'ffffff']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '0F263A']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "ETAPA")
            ->setCellValue('B1', "TOTAL")
            ->setCellValue('C1', ' % ')
            ->setCellValue('D1', "MONTO APROBADO")
            ->setCellValue('E1', ' % ');
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    }

    private function _footer($spreadsheet, $totalRows, $data)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0000']
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
            ]
        ];
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.($totalRows+1), "TOTAL")
            ->setCellValue('B'.($totalRows+1), $data["totalProjects"])
            ->setCellValue('C'.($totalRows+1), 100)
            ->setCellValue('D'.($totalRows+1), $data["totalApprovedBudget"])
            ->setCellValue('E'.($totalRows+1), 100);
        $spreadsheet->getActiveSheet()->getStyle('A'.($totalRows+1).':E'.($totalRows+1))->applyFromArray($titleStyleArray);
    }

    private function _currencyFormatNumber($spreadsheet, $totalRows)
    {
        $columnList = array("D");

        foreach($columnList as $key => $column)
        {
            $spreadsheet->getActiveSheet()->getStyle($column.'2:'.$column.$totalRows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        }
    }

    private function _highlightRow($spreadsheet, $currentRow, $keyword)
    {
        $colors = array(
            "8EA9DB" => array("design"),
            "FFFF00" => array("alreadySent", "closure"),
            "92D050" => array("inProgress"),
            "00B0F0" => array("closed")
        );

        foreach ($colors as $color => $statusList)
        {
            if(array_search($keyword, $statusList) !== FALSE)
            {
                $spreadsheet->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $spreadsheet->getActiveSheet()->getStyle('A'.$currentRow.':E'.$currentRow)
                    ->getFill()->getStartColor()->setARGB($color);
            }
        }
    }

    private function _getData()
    {
        $currentStatusSummary = Model_project::projectCurrentStatusSummary($this->_system, $this->_managementBy);
        $reportSections = array(
            "recentlyCreated" => array("title" => "Solo registro", "section" => "recentlyCreated", "keywords" => array("project_has_been_created")),
            "readyToDesign" => array("title" => "Listo para diseño", "section" => "readyToDesign", "keywords" => array("design")),
            "design" => array("title" => "Diseño", "section" => "design", "keywords" => array("stakes", "digitization", "drawing")),
            "alreadySent" => array("title" => "Aprobacion", "section" => "alreadySent",  "keywords" => array("schedule", "ready_to_send", "already_sent")),
            "inProgress" => array("title" => "Construccion", "section" => "inProgress", "keywords" => array("assign_to", "approved", "in_progress", "paused","stopped")),
            "closure" => array("title" =>"Cierre", "section" => "closure", "keywords" => array("completed", "as_built","conciliation_reception", "conciliation_shipment","cre_return_order")),
            "closed" => array("title" => "Cerrado", "section" => "closed", "keywords" => array("project_return_materials"))
        );
        $groupList = array();
        $totalProjects = 0;
        $totalApprovedBudget = 0;
        $totalApprovedBudgetBySection = 0;
        $totalRealBudget = 0;
        $totalProjectsBySection = 0;
        foreach ($reportSections as $groupKey => $data)
        {
            $groupKeywords =  $data["keywords"];
            for($i = 0; $i < count($groupKeywords); $i++)
            {
                for($j = 0; $j < count($currentStatusSummary); $j++)
                {
                    if($groupKeywords[$i] == $currentStatusSummary[$j]["keyword"])
                    {
                        $groupList[] = $currentStatusSummary[$j];
                        $totalProjectsBySection += $currentStatusSummary[$j]["total_projects"];
                        $totalProjects += $currentStatusSummary[$j]["total_projects"];
                        $totalApprovedBudgetBySection += $currentStatusSummary[$j]["keyword"] !="canceled"?$currentStatusSummary[$j]["approved_budgets"]:"0";
                        $totalApprovedBudget += $currentStatusSummary[$j]["keyword"] !="canceled"?$currentStatusSummary[$j]["approved_budgets"]:"0";
                        $totalRealBudget += $currentStatusSummary[$j]["keyword"] !="canceled"?$currentStatusSummary[$j]["real_budgets"]:"0";
                    }
                }
            }

            $reportSections[$groupKey]["list"] = $groupList;
            $reportSections[$groupKey]["totalProjectsBySection"] = $totalProjectsBySection;
            $reportSections[$groupKey]["totalApprovedBudgetBySection"] = $totalApprovedBudgetBySection;
            $reportSections[$groupKey]["totalRealBudget"] = $totalRealBudget;
            $groupList = array();
            $totalProjectsBySection = 0;
            $totalApprovedBudgetBySection = 0;
            $totalRealBudget = 0;
        }

        foreach ($reportSections as $groupKey => $data)
        {
            $totalPercentageProjectsBySection = ($reportSections[$groupKey]["totalProjectsBySection"]*100) / $totalProjects;
            $reportSections[$groupKey]["totalPercentageProjectsBySection"] = number_format($totalPercentageProjectsBySection,2);

            $totalApprovedBudgetBySection = $reportSections[$groupKey]["totalApprovedBudgetBySection"];
            $totalPercentageApprovedBudgetBySection = $totalApprovedBudgetBySection <= 0?0:($totalApprovedBudgetBySection*100) / $totalApprovedBudget;
            $reportSections[$groupKey]["totalPercentageApprovedBudgetBySection"] = number_format($totalPercentageApprovedBudgetBySection,2);
        }
        $response["totalProjects"] = $totalProjects;
        $response["totalApprovedBudget"] = number_format($totalApprovedBudget, 2);
        $response["list"] = array_values($reportSections);

        return $response;
    }
}