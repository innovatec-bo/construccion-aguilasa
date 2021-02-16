<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_project_budget_base extends MY_Model
{
    const TABLE_NAME = "wfl_project_budgets";
    const TABLE_ID = "id_prb";
    const ATTRIB_SUFIX = "_prb";

    protected ?int $_statusLogId;
    protected float $_design;
    protected float $_building;
    protected string $_graphNumber;
    protected string $_reservationNumber;
    protected float $_transportation;
    protected float $_liveLine;
    protected float $_rightOfWay;
    protected float $_tentativeTotalBudget;
    protected ?int $_manpowerFileId;
    protected ?int $_buildingStructureFileId;
	protected ?int $_materialsFileId;

    public function __construct($statusLogId = NULL, $design = 0.0, $building = 0, $graphNumber = 0, $reservationNumber = 0, $transportation = 0, $liveLine = 0, $rightOfWay = 0, $tentativeTotalBudget = 0, $manpowerFileId = NULL, $buildingStructureFileId = NULL, $materialsFileId = NULL)
    {
        parent::__construct();
        $this->_statusLogId = $statusLogId;
        $this->_design = $design;
        $this->_building = $building;
        $this->_graphNumber = $graphNumber;
        $this->_reservationNumber = $reservationNumber;
        $this->_transportation = $transportation;
        $this->_liveLine = $liveLine;
        $this->_rightOfWay = $rightOfWay;
        $this->_tentativeTotalBudget = $tentativeTotalBudget;
        $this->_manpowerFileId = $manpowerFileId;
        $this->_buildingStructureFileId = $buildingStructureFileId;
        $this->_materialsFileId = $materialsFileId;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_prb" => $this->_id,
            "status_log_id_prb" => $this->_statusLogId,
            "design_prb" => $this->_design,
            "building_prb" => $this->_building,
            "graph_number_prb" => $this->_graphNumber,
            "reservation_number_prb" => $this->_reservationNumber,
            "transportation_prb" => $this->_transportation,
            "live_line_prb" => $this->_liveLine,
            "right_of_way_prb" => $this->_rightOfWay,
            "tentative_total_budget_prb" => $this->_tentativeTotalBudget,
            "manpower_file_id_prb" => $this->_manpowerFileId,
            "building_structure_file_id_prb" => $this->_buildingStructureFileId,
            "materials_file_id_prb" => $this->_materialsFileId,
            "deleted_prb" => $this->_deleted,
            "createdon_prb" => $this->_createdOn,
            "createdby_prb" => $this->_createdBy,
            "editedon_prb" => $this->_editedOn,
            "editedby_prb" => $this->_editedBy
        );
        return $tableAttributes;
    }

    /**
     * @param $className
     * @param $object
     * @return object
     */
    protected static function recast($className, $object)
    {
        $response =  null;
        if ($object instanceof stdClass)
        {
            if (!class_exists($className))
                throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

            //Let's set the values to payment object using the data from stdObject
            $instance = new $className(
                $object->status_log_id_prb,
                $object->design_prb,
                $object->building_prb,
                $object->graph_number_prb,
                $object->reservation_number_prb,
                $object->transportation_prb,
                $object->live_line_prb,
                $object->right_of_way_prb,
                $object->tentative_total_budget_prb,
                $object->manpower_file_id_prb,
                $object->building_structure_file_id_prb,
				$object->materials_file_id_prb
            );
            $instance->_id = $object->id_prb;

            $instance->_deleted = $object->deleted_prb;
            $instance->_createdOn = $object->createdon_prb;
            $instance->_createdBy = $object->createdby_prb;
            $instance->_editedOn = $object->editedon_prb;
            $instance->_editedBy = $object->editedby_prb;
            $response = $instance;
        }
        return $response;
    }

    public function setManpowerFileId($fileId)
    {
        $this->_manpowerFileId = $fileId;
    }

    public function setPointToPointFileId($buildingStructureFileId)
    {
        $this->_buildingStructureFileId = $buildingStructureFileId;
    }

    public function setMaterialFileId($materialFileId)
	{
		$this->_materialsFileId = $materialFileId;
	}
}
