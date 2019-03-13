<?php
class StatusSetHandler
{
    private $_statusSet;
	public function __construct($statusSet)
	{
        $this->_statusSet = $statusSet;
	}

    public static function projectStages($statusSet = "building")
    {
        $stageList = array();

        $design = array(
            array("project_has_been_created"),
            array("stakes"),
            array("digitization","drawing", "returned"),
            array("digitization","drawing", "returned"),
            array("schedule")
        );

        $approvement = array(
            array("ready_to_send"),
            array("already_sent"),
            array("approved", "canceled","rectify_design","rectify_illustration")
        );

        $building = '[{"step":"assign_to","children":[{"step":"in_progress","children":[{"step":"paused","children":[{"step":"completed","children":[{"step":"project_energized","children":[{"step":"as_built","children":[{"step":"conciliation_reception","children":[{"step":"conciliation_shipment","children":[{"step":"cre_return_order","children":[{"step":"project_return_materials","children":[]}]}]}]}]}]},{"step":"as_built","children":[{"step":"project_energized","children":[{"step":"as_built","children":[{"step":"conciliation_reception","children":[{"step":"conciliation_shipment","children":[{"step":"cre_return_order","children":[{"step":"project_return_materials","children":[]}]}]}]}]}]}]}]},{"step":"stopped","children":[{"step":"as_built","children":[{"step":"conciliation_reception","children":[{"step":"conciliation_shipment","children":[{"step":"cre_return_order","children":[{"step":"project_return_materials","children":[]}]}]}]}]}]}]},{"step":"completed","children":[{"step":"project_energized","children":[{"step":"as_built","children":[{"step":"conciliation_reception","children":[{"step":"conciliation_shipment","children":[{"step":"cre_return_order","children":[{"step":"project_return_materials","children":[]}]}]}]}]}]},{"step":"as_built","children":[{"step":"conciliation_reception","children":[{"step":"conciliation_shipment","children":[{"step":"cre_return_order","children":[{"step":"project_return_materials","children":[]}]}]}]}]}]}]}]}]';

        $stageList["design"] = $design;
        $stageList["approvement"] = $approvement;
        $stageList["building"] = json_decode($building, TRUE);
        return $stageList[$statusSet];
    }
}