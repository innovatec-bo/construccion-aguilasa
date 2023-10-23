<?php
class StatusSetHandler
{
    private $_statusSet;
	public function __construct($statusSet)
	{
        $this->_statusSet = $statusSet;
	}

    public function getStepTree()
    {
        $stageList = array();
        /**
         * Process TREE definition
         */
        $design = '[{"name":"project_has_been_created","next":[{"name":"stakes","next":[{"name":"digitization","next":[{"name":"drawing","next":[{"name":"schedule","next":[]}]}]},{"name":"drawing","next":[{"name":"digitization","next":[{"name":"schedule","next":[]}]}]},{"name":"returned","next":[{"name":"canceled","next":[]}]}]}]}]';
        $rectifyDesign = '[{"name":"rectify_design","next":[{"name":"rd_stakes","next":[{"name":"rd_digitization","next":[{"name":"rd_drawing","next":[]}]},{"name":"rd_drawing","next":[{"name":"rd_digitization","next":[]}]},{"name":"returned","next":[]}]}]}]';
        $rectifyIllustration = '[{"name":"rectify_illustration","next":[{"name":"ri_digitization","next":[{"name":"ri_drawing","next":[]}]},{"name":"ri_drawing","next":[{"name":"ri_digitization","next":[]}]}]}]';
        $approvement = '[{"name":"ready_to_send","next":[{"name":"already_sent","next":[{"name":"approved","next":[{"name":"canceled","next":[{"name":"returned","next":[]}]}]},{"name":"canceled","next":[{"name":"returned","next":[]}]},{"name":"rectify_design","next":[]},{"name":"rectify_illustration","next":[]}]}]}]';
        $building = '[{"name":"assign_to","next":[{"name":"in_progress","next":[{"name":"paused","next":[{"name":"completed","next":[{"name":"project_energized","next":[{"name":"as_built","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]},{"name":"as_built","next":[{"name":"project_energized","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]}]},{"name":"stopped","next":[{"name":"as_built","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]}]},{"name":"completed","next":[{"name":"project_energized","next":[{"name":"as_built","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]},{"name":"as_built","next":[{"name":"project_energized","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]}]}]}]}]';

        $stageList["design"] = json_decode($design, TRUE);
        $stageList["rectify_design"] = json_decode($rectifyDesign, TRUE);
        $stageList["rectify_illustration"] = json_decode($rectifyIllustration, TRUE);
        $stageList["approvement"] = json_decode($approvement, TRUE);
        $stageList["building"] = json_decode($building, TRUE);
        return $stageList[$this->_statusSet];
    }
}