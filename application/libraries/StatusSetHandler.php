<?php
class StatusSetHandler
{
    private $_statusSet;
	public function __construct($statusSet)
	{
        $this->_statusSet = $statusSet;
	}

    public static function projectStages($statusSet)
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

        $building = array(
            array("assign_to"),
            array("in_progress"),
            array("paused","completed"),
            array("stopped","completed"),
            array("project_energized", "as_built"),
            array("project_energized", "as_built"),
            array("conciliation_reception"),
            array("conciliation_shipment"),
            array("cre_return_order"),
            array("project_return_materials"),
            array("project_real_budget_confirmation")
        );

        $stageList["design"] = $design;
        $stageList["approvement"] = $approvement;
        $stageList["building"] = $building;
        return $stageList[$statusSet];
    }
}