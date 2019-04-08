<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 08/04/2019
 * Time: 10:10 A.M.
 */

class Model_executive_summary_log_base extends MY_Model
{
    const TABLE_NAME = "sec_executive_summary_log";
    const TABLE_ID = "id_esl";
    const ATTRIB_SUFIX = "_esl";

    protected $_stage;
    protected $_projectsQuantity;
    protected $_projectsPercentage;
    protected $_approvedBudget;
    protected $_approvedBudgetPercentage;
    protected $_contractPercentage;

    protected $_date;

    public function __construct($stage = "", $projectsQuantity = 0, $projectsPercentage = 0, $approvedBudget = 0, $approvedBudgetPercentage = 0, $contractPercentage = 0, $date = NULL)
    {
        parent::__construct();
        $this->_stage = $stage;
        $this->_projectsQuantity = $projectsQuantity;
        $this->_projectsPercentage = $projectsPercentage;
        $this->_approvedBudget = $approvedBudget;
        $this->_approvedBudgetPercentage = $approvedBudgetPercentage;
        $this->_contractPercentage = $contractPercentage;
        $this->_date = $date;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_esl" => $this->_id,
            "stage_esl" => $this->_stage,
            "projects_quantity_esl" => $this->_projectsQuantity,
            "project_percentage_esl" => $this->_projectsPercentage,
            "approved_budget_esl" => $this->_approvedBudget,
            "approved_budget_percentage_esl" => $this->_approvedBudgetPercentage,
            "contract_percentage_esl" => $this->_contractPercentage,
            "date_esl" => $this->_date,
            "deleted_esl" => $this->_deleted,
            "createdon_esl" => $this->_createdOn,
            "createdby_esl" => $this->_createdBy,
            "editedon_esl" => $this->_editedOn,
            "editedby_esl" => $this->_editedBy
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
                $object->stage_esl,
                $object->projects_quantity_esl,
                $object->project_percentage_esl,
                $object->approved_budget_esl,
                $object->approved_budget_percentage_esl,
                $object->contract_percentage_esl,
                $object->date_esl
            );
            $instance->_id = $object->id_esl;

            $instance->_deleted = $object->deleted_esl;
            $instance->_createdOn = $object->createdon_esl;
            $instance->_createdBy = $object->createdby_esl;
            $instance->_editedOn = $object->editedon_esl;
            $instance->_editedBy = $object->editedby_esl;
            $response = $instance;
        }
        return $response;
    }
}