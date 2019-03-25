<?php
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_pie.php');
require_once ('jpgraph/src/jpgraph_pie3d.php');
class JPGraphHandler
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

	public function printPieChart3D()
    {
        // Some data
        $data = array(40,60,21,33);
        // Create the Pie Graph.
        $graph = new PieGraph(400,250);
        $theme_class= new VividTheme;
        $graph->SetTheme($theme_class);
        // Set A title for the plot
        $graph->title->Set("Serebo");
        // Create
        $p1 = new PiePlot3D($data);
        $graph->Add($p1);
        $p1->ShowBorder();
        $p1->SetAngle(35);
        $p1->SetHeight(8);
        if($this->_showInSource)
        {
            return $this->_graphInSrc($graph);
        }
        $graph->Stroke();
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