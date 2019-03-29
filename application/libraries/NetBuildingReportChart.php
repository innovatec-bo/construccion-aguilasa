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
//        echo"<pre>";var_dump($executiveSummary, array_column($executiveSummary["list"],"totalProjectsBySection"));exit;
        // Some data
        $data = $this->_executiveSummaryDataSource($executiveSummary, $dataType);
        $legend = array_column($executiveSummary["list"],"title");
        // Create the Pie Graph.
        $graph = new PieGraph(400,280);
        $theme_class= new VividTheme;
        $graph->SetTheme($theme_class);
        // Set A title for the plot
        $graph->title->Set("Reporte de estados actuales (unidades)");
        // Create
        $p1 = new PiePlot3D($data);
        $graph->Add($p1);
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
        return $data;
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