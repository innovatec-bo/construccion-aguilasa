<?php
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_pie.php');
require_once ('jpgraph/src/jpgraph_pie3d.php');
class NetBuildingReportChart
{
    private $_showInSource;
	public function __construct()
	{
	    $this->_showInSource = FALSE;
	}

	public function setShowInSource()
    {
        $this->_showInSource = TRUE;
    }

	public function printExecutiveSummary($executiveSummary, $dataType = "totalProjectsBySection")
    {
        $title["totalProjectsBySection"] = "Unidades";
        $title["totalApprovedBudgetBySection"] = "Montos Aprobados";
        $title["contractAmountPercentageBySection"] = "Porcentage de contrato";

        // Some data
        $dataSource = $this->_executiveSummaryDataSource($executiveSummary, $dataType);
        $data = $dataSource["data"];
        $labels = $dataSource["labels"];
        $legend = $dataSource["legend"];
        // Create the Pie Graph.
        $graph = new PieGraph(450,290);
        $theme_class= new VividTheme;
        $graph->SetTheme($theme_class);
        // Set A title for the plot
        $graph->title->Set($title[$dataType]);
        // Create
        $p1 = new PiePlot3D($data);
        $graph->Add($p1);
        $p1->SetLabels($labels,0.3);
        $p1->SetLabelMargin(60);
        $p1->ShowBorder();
        $p1->SetAngle(35);
        $p1->SetHeight(8);
        $p1->SetLegends($legend);
        if($this->_showInSource)
        {
            return $this->_graphInSrc($graph);
        }
        $graph->Stroke();
    }

    private function _executiveSummaryDataSource($executiveSummary, $dataType)
    {
        $data = array();
        $labels = array();
        $legend = array_column($executiveSummary["list"],"title");
        switch ($dataType)
        {
            case "totalProjectsBySection":
                $data = array_column($executiveSummary["list"],"totalProjectsBySection");
                break;
            case "totalApprovedBudgetBySection":
                $data = array_column($executiveSummary["list"],"totalApprovedBudgetBySection");
                break;
            case "contractAmountPercentageBySection":
                $data = array_column($executiveSummary["list"],"contractAmountPercentageBySection");
                break;
        }
        //Check data before return
        $aux= $data;
        for($i = 0; $i<count($aux); $i++)
        {
            $amount = $data[$i];
            if($dataType == "totalApprovedBudgetBySection")
            {
                $amount = number_format($data[$i], 2);
            }
            $labels[$i] = "%.1f%%(".$amount.")";
            //Let's check if any data is less than or equal to '0'
            if($data[$i] <= 0)
            {
                unset($data[$i]);
                unset($labels[$i]);
                unset($legend[$i]);
            }
        }
        $response["data"] = array_values($data);
        $response["labels"] = array_values($labels);
        $response["legend"] = array_values($legend);
        return $response;
    }

    private function _graphInSrc($graph)
    {
        $graph->Stroke(_IMG_HANDLER);
        ob_start();
        $graph->img->SetImgFormat('jpeg',100);
//        $graph->img->SetQuality(100);
        $graph->img->Stream();
        $img_data = ob_get_contents();
        ob_end_clean();
        return $img_data;
    }
}