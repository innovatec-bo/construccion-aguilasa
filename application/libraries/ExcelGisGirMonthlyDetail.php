<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelGisGirMonthlyDetail
{
    private $_sessionUser;
    private $_months;

    public function __construct($sessionUser)
    {
        $this->_sessionUser = $sessionUser;
        $this->_months = array(
                            "january" => "Enero",
                            "february" => "Febrero",
                            "march" => "Marzo",
                            "april" => "Abril",
                            "may" => "Mayo",
                            "june" => "Junio",
                            "july" => "Julio",
                            "august" => "Agosto",
                            "september" => "Septiembre",
                            "october" => "Octubre",
                            "november" => "Noviembre",
                            "december" => "Diciembre"
                        );
    }

    function getReport()
    {
        require FCPATH . 'application/libraries/PhpSpreadsheet/vendor/autoload.php';
        // $list = Model_project::productionGeneralSummary();
        // $list = Model_project::getProductivityBaseReport(['from' => '2025-01-01 00:00:00', 'to' => '2025-01-31 23:59:59']);
        $list = Model_project::getProductivityBaseReport();
        // dd($list);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($this->_sessionUser->fullName)
            ->setTitle("Reporte mensual GIS y GIR")
            ->setSubject("GIS y GIR mensualizado")
            ->setDescription("Contiene una lista de proyectos con su detalle de produccion y presupuesto destinado")
            ->setDescription("Contiene una lista mensualizada de la produccion de proyectos GIS y GIR")
            ->setKeywords("reporte gis gir mensualizado")
            ->setCategory("Reporte");
        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
        
        $spreadsheet = $this->_projects($spreadsheet, $list);

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Reporte mensual GIS y GIR - '.date('Y.m.d.H.i.s').'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    private function _projects($spreadsheet, $list)
    {
        $titleStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'BFBFBF']
            ]
        ];

        $headerStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'BFBFBF']
            ]
        ];

        $manPowerWorkSheet = $spreadsheet->createSheet(0);
        $manPowerWorkSheet->setTitle('PROYECTOS');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C1', 'GIS');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E1', 'GIR');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G1', 'TOTAL');
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($titleStyleArray);
        $spreadsheet->getActiveSheet()->mergeCells('C1:D1');
        $spreadsheet->getActiveSheet()->mergeCells('E1:F1');
        $spreadsheet->getActiveSheet()->mergeCells('G1:H1');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A2', "Año")
            ->setCellValue('B2', "MES")
            ->setCellValue('C2', "PROYECTOS")
            ->setCellValue('D2', "IMPORTE")
            ->setCellValue('E2', "PROYECTOS")
            ->setCellValue('F2', "IMPORTE")
            ->setCellValue('G2', "PROYECTOS")
            ->setCellValue('H2', "IMPORTE");

        $spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($headerStyleArray);
        $counter = 1;
        $i = 2;
        $dataFormatted = $this->_formatData($list);
        // $dataFormatted = $this->_formatDataByBuilder($list);
        foreach ($dataFormatted as $year => $months)
        {
            foreach ($months as $month => $workArea) 
            {
                $gisProjects = 0;
                $gisBudget = 0;
                if (isset($workArea['gis'])) 
                {
                    $gisProjects = count($workArea['gis']['projects']);
                    $gisBudget = $workArea['gis']['budget'];
                }
                $girProjects = 0;
                $girBudget = 0;
                if (isset($workArea['gir'])) 
                {
                    $girProjects = count($workArea['gir']['projects']);
                    $girBudget = $workArea['gir']['budget'];
                }
                $totalProjects = $gisProjects + $girProjects;
                $totalBudget = $gisBudget + $girBudget;
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A'.($i+1), $year)
                    ->setCellValue('B'.($i+1), $month)
                    ->setCellValue('C'.($i+1), $gisProjects)
                    ->setCellValue('D'.($i+1), $gisBudget)
                    ->setCellValue('E'.($i+1), $girProjects)
                    ->setCellValue('F'.($i+1), $girBudget)
                    ->setCellValue('G'.($i+1), $totalProjects)
                    ->setCellValue('H'.($i+1), $totalBudget);
                    //Currency format
                $spreadsheet->getActiveSheet()->getStyle('D'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $spreadsheet->getActiveSheet()->getStyle('F'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $spreadsheet->getActiveSheet()->getStyle('H'.($i+1))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                $i++;
                $counter++;
            }
        }
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getStyle('A1:H'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        return $spreadsheet;
    }

    private function _formatData(array $list): array
    {
        $formatted = [];

        foreach ($list as $row) 
        {
            if (!isset($row['manual_entry_date_lal']) || !isset($row['work_area_pro'])) {
                continue; // let's skip if there aren't date or work_area
            }

            $date = new \DateTime($row['manual_entry_date_lal']);
            $year = $date->format('Y');
            $month = strtolower($date->format('F')); // return month in English (January, February...)
            $month = $this->_months[$month];
            $workArea = strtolower($row['work_area_pro']); // gis or gir
            $day = (int) $date->format('j'); // Día del mes sin ceros a la izquierda

            if (!in_array($workArea, ['gis', 'gir'])) {
                continue; // let's skip unknown
            }

            // Start structure if it doesn't exist
            if (!isset($formatted[$year][$month][$workArea])) {
                $formatted[$year][$month][$workArea] = [
                    'projects' => [],
                    'budget' => 0.0,
                ];
            }

            // Register project
            $projectId = $row['project_id_lad'];
            $formatted[$year][$month][$workArea]['projects'][$projectId] = true;

            // Sum budget
            $budget = floatval($row['total_amount_worked_to_split']);
            $formatted[$year][$month][$workArea]['budget'] += $budget;

            // Ahora también registramos la producción diaria
            if (!isset($formatted[$year][$month]['days'][$day])) {
                $formatted[$year][$month]['days'][$day] = [
                    'projects' => [],
                    'budget' => 0.0
                ];
            }

            $formatted[$year][$month]['days'][$day]['projects'][$projectId] = true;
            $formatted[$year][$month]['days'][$day]['budget'] += $budget;
        }

        // Ahora vamos a contar los proyectos y redondear budgets
        foreach ($formatted as $year => &$months) 
        {
            foreach ($months as $month => &$areas) 
            {
                foreach (['gis', 'gir'] as $area) 
                {
                    if (isset($areas[$area])) {
                        $areas[$area]['budget'] = round($areas[$area]['budget'], 2);
                        $areas[$area]['budget'] = $areas[$area]['budget'];
                    }
                }

                // También para los días
                if (isset($areas['days'])) {
                    foreach ($areas['days'] as $day => &$dayData) {
                        $dayData['projects'] = count($dayData['projects']);
                        $dayData['budget'] = round($dayData['budget'], 2);
                    }
                    ksort($areas['days']); // Ordenar los días por número
                }
            }
        }

        $monthsOrder = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];
        // Sort months
        foreach ($formatted as &$yearData) {
            uksort($yearData, function ($a, $b) use ($monthsOrder) {
                return array_search(strtolower($a), $monthsOrder) <=> array_search(strtolower($b), $monthsOrder);
            });
        }

        ksort($formatted);
        return $formatted;
    }

    private function _formatDataByBuilder(array $list): array
    {
        $formatted = [];

        foreach ($list as $row) 
        {
            if (!isset($row['manual_entry_date_lal']) || !isset($row['work_area_pro'])) {
                continue; // saltar si falta fecha o área
            }
            
            $date = new \DateTime($row['manual_entry_date_lal']);
            $year = $date->format('Y');
            $month = strtolower($date->format('F')); // mes en inglés
            $month = $this->_months[$month];
            $workArea = strtolower($row['work_area_pro']); // puede ser 'gis' o 'gir'

            if (!in_array($workArea, ['gis', 'gir'])) {
                continue; // saltar áreas desconocidas
            }

            // Inicializar estructura si no existe
            if (!isset($formatted[$year][$month][$workArea])) {
                $formatted[$year][$month][$workArea] = [
                    'projects' => [],
                    'budget' => 0.0,
                ];
            }

            // Registrar proyecto
            $projectId = $row['project_id_lad'];
            $formatted[$year][$month][$workArea]['projects'][$projectId] = true;

            // Calcular monto basado en builders
            $builders = isset($row['builders']) ? explode(',', $row['builders']) : [];
            $builderCount = count($builders);

            if ($builderCount > 0) {
                $amountPerBuilder = floatval($row['total_amount_worked_by_builder']);
                $totalAmount = $amountPerBuilder * $builderCount;
            } else {
                // No hay builders, considerar el total directamente
                $totalAmount = floatval($row['total_amount_worked_by_builder']);
            }

            // Sumar al presupuesto del área
            $formatted[$year][$month][$workArea]['budget'] += $totalAmount;
        }

        // Ahora contar proyectos y redondear presupuestos
        foreach ($formatted as $year => &$months) {
            foreach ($months as $month => &$areas) {
                foreach ($areas as $area => &$data) {
                    $data['projects'] = count($data['projects']);
                    $data['budget'] = round($data['budget'], 2);
                }
            }
        }

        // Ordenar meses
        $monthsOrder = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];
        foreach ($formatted as &$yearData) {
            uksort($yearData, function ($a, $b) use ($monthsOrder) {
                return array_search(strtolower($a), $monthsOrder) <=> array_search(strtolower($b), $monthsOrder);
            });
        }

        ksort($formatted);
        return $formatted;
    }
}
