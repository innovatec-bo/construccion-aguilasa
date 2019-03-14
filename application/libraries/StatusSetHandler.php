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
        $design = '[{"name":"project_has_been_created","children":[{"name":"stakes","children":[{"name":"digitization","children":[{"name":"drawing","children":[{"name":"schedule","children":[]}]}]},{"name":"drawing","children":[{"name":"digitization","children":[{"name":"schedule","children":[]}]}]},{"name":"returned","children":[]}]}]}]';
        $rectifyDesign = '[{"name":"rectify_design","children":[{"name":"rd_stakes","children":[{"name":"rd_digitization","children":[{"name":"rd_drawing","children":[]}]},{"name":"rd_drawing","children":[{"name":"rd_digitization","children":[]}]}]}]}]';
        $rectifyIllustration = '[{"name":"rectify_illustration","children":[{"name":"ri_digitization","children":[{"name":"ri_drawing","children":[]}]},{"name":"ri_drawing","children":[{"name":"ri_digitization","children":[]}]}]}]';
        $approvement = '[{"name":"ready_to_send","children":[{"name":"already_sent","children":[{"name":"approved","children":[]},{"name":"canceled","children":[]},{"name":"rectify_design","children":[]},{"name":"rectify_illustration","children":[]}]}]}]';
        $building = '[{"name":"assign_to","children":[{"name":"in_progress","children":[{"name":"paused","children":[{"name":"completed","children":[{"name":"project_energized","children":[{"name":"as_built","children":[{"name":"conciliation_reception","children":[{"name":"conciliation_shipment","children":[{"name":"cre_return_order","children":[{"name":"project_return_materials","children":[]}]}]}]}]}]},{"name":"as_built","children":[{"name":"project_energized","children":[{"name":"conciliation_reception","children":[{"name":"conciliation_shipment","children":[{"name":"cre_return_order","children":[{"name":"project_return_materials","children":[]}]}]}]}]}]}]},{"name":"stopped","children":[{"name":"as_built","children":[{"name":"conciliation_reception","children":[{"name":"conciliation_shipment","children":[{"name":"cre_return_order","children":[{"name":"project_return_materials","children":[]}]}]}]}]}]}]},{"name":"completed","children":[{"name":"project_energized","children":[{"name":"as_built","children":[{"name":"conciliation_reception","children":[{"name":"conciliation_shipment","children":[{"name":"cre_return_order","children":[{"name":"project_return_materials","children":[]}]}]}]}]}]},{"name":"as_built","children":[{"name":"project_energized","children":[{"name":"conciliation_reception","children":[{"name":"conciliation_shipment","children":[{"name":"cre_return_order","children":[{"name":"project_return_materials","children":[]}]}]}]}]}]}]}]}]}]';

        $stageList["design"] = json_decode($design, TRUE);
        $stageList["rectify_design"] = json_decode($rectifyDesign, TRUE);
        $stageList["rectify_illustration"] = json_decode($rectifyIllustration, TRUE);
        $stageList["approvement"] = json_decode($approvement, TRUE);
        $stageList["building"] = json_decode($building, TRUE);
        return $stageList[$this->_statusSet];
    }
}