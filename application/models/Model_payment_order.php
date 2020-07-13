<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 11:52 AM
 */

class Model_payment_order extends Model_payment_order_base
{
    const PAYMENT_ORDER_CREATED = 1;
    const PAYMENT_ORDER_INVOICED_AND_SEND = 2;
    const PAYMENT_ORDER_HAS_BEEN_SETTLED = 3;

    public function __construct($orderNumber = "", $status = 1, $invoiceNumber = NULL, $entryDate = "", $detail = "", $invoiceDate = NULL, $endContractId = NULL)
	{
		parent::__construct($orderNumber, $status, $invoiceNumber, $entryDate, $detail, $invoiceDate, $endContractId);
	}

	public function saveProjects($projectList = array())
    {
    	static::deleteProjectsFromPaymentOrder($this->_id);
        $arrayToInsert = array();
        $currentUser = PrivateController::getSessionUser();
        $currentUserId = isset($currentUser) ? $currentUser->id:NULL;

        $projectIds = array_column($projectList, "projectId");
        $projectObjectList = Model_project::getAllInArrayIds($projectIds, 200, 0);

        //Adding projects to payment order
        foreach ($projectList as $project)
        {
            if($project["paymentOrderId"] == "")
            {
                $projectId = $project["projectId"];
                $designBudget = str_replace(",", "", $project["designBudget"]);
                $transportationBudget = str_replace(",","",$project["transportationBudget"]);
                $buildingBudget = str_replace(",","",$project["buildingBudget"]);
                $liveLineBudget = str_replace(",", "",$project["liveLineBudget"]);
                $rightOfWayBudget = str_replace(",","",$project["rightOfWayBudget"]);

                $arrayToInsert[] = array(
                    "order_id_pop" => $this->_id,
                    "project_id_pop" => $projectId,
                    "design_budget_pop" => $designBudget,
                    "transportation_budget_pop" => $transportationBudget,
                    "building_budget_pop" => $buildingBudget,
                    "live_line_budget_pop" => $liveLineBudget,
                    "right_of_way_budget_pop" => $rightOfWayBudget,
                    "deleted_pop" => 0,
                    "createdon_pop" => date("Y-m-d H:i:s"),
                    "createdby_pop" => $currentUserId
                );
                //Getting the object form list using the projectId
				/** @var Model_project $projectObject */
                $projectObject = $projectObjectList[$projectId];
                //Save the real budget and status
                $status = 45;//defined real budget confirmation
                $projectObject->setStatus($status);
                $projectObject->setEndContract($this->_endContractId);
                $projectObject->save();
                //Getting responsible list
                $responsibleList =  Model_project_status_log::getLogByProjectIdAndStatusKeyWord($projectId, "assign_to");
                $responsibleList = json_decode("[".$responsibleList[0]["jsonResponsible"]."]",TRUE);
                $responsibleList = array_column($responsibleList, "id");
                //Saving real budget
                $projectObject->saveRealBudget($designBudget, $buildingBudget, $transportationBudget, $liveLineBudget, $rightOfWayBudget, $status, "Proyecto asignado a un numero de orden", $this->_entryDate, $responsibleList);
            }
        }
        if(count($arrayToInsert) > 0)
		{
			Model_payment_order_project::insertBatch($arrayToInsert);
		}

    }

    public static function deleteProjectsFromPaymentOrder($paymentOrderId)
	{
		$ci = &get_instance();
		$ci->load->database();
		$sql = "
		UPDATE 
			wfl_projects,
			wfl_payment_orders_projects,
            wfl_project_status_log 
		SET 
			status_pro = 39, -- Go to previous status
			deleted_pop = 1, -- deleted reference on payment orders project
            deleted_psl = 1 -- deleted reference with status 45
		WHERE
			order_id_pop = ".$ci->db->escape($paymentOrderId)."
			and project_id_pop = id_pro
            and id_pro = project_id_psl
            and status_id_psl = 45
		";
		$ci->db->query($sql);
	}

    public function addStatusToLog($statusId, $detail = "", $manualEntryDate = "")
    {
        //Lets create a new log
        $paymentOrder = new Model_payment_order_status_log($this->_id, $statusId, $detail, $manualEntryDate);
        $paymentOrder->save();
        $this->_status = $statusId;
        $this->save();
    }

	public static function getByOrderNumberAndNotOrderId($invoiceNumber, $paymentOrderId)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            SELECT
                ".static::TABLE_NAME.".*
            FROM
                ".static::TABLE_NAME."
            WHERE
            order_number_pao = ".$ci->db->escape($invoiceNumber)."
            and id_pao != ".$ci->db->escape($paymentOrderId)."
            and deleted_pao != 1
        ";

		$query = $ci->db->query($sql);
		$result = static::recast(get_called_class(), $query->row());
		return $result;
	}

	public static function orderNumberDuplicated($orderNumber, $paymentOrderId = NULL)
	{
		$alreadyExist = FALSE;
		//add
		if(is_null($paymentOrderId) || $paymentOrderId == "")
		{
			$paymentOrder = static::getByOrderNumber($orderNumber);
		}
		//edit
		else
		{
			$paymentOrder = static::getByOrderNumberAndNotOrderId($orderNumber, $paymentOrderId);
		}

		if($paymentOrder instanceof Model_payment_order)
		{
			$alreadyExist = TRUE;
		}

		return $alreadyExist;
	}

	public static function getByOrderNumber($orderNumber)
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = "
            SELECT
                ".static::TABLE_NAME.".*
            FROM
                ".static::TABLE_NAME."
            WHERE
            order_number_pao = ".$ci->db->escape($orderNumber)."
            and deleted_pao != 1
        ";

		$query = $ci->db->query($sql);
		$result = static::recast(get_called_class(), $query->row());
		return $result;
	}

    ################################################################################################# BEGIN - DATATABLE AJAX METHODS

    /**
     * @param $statusId
     * @return mixed
     */
    public static function countAllPaymentOrders($statusId = "42,43,44")
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = '
                select count(' . static::TABLE_ID. ') as total
                from ' . static::TABLE_NAME .' where '.static::notDeleted().' and status_pao in ('.$statusId.')';

        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        return $totalCount;
    }

    /**
     * @param string $statusId
     * @param $limit
     * @param $offset
     * @param null $orderBy
     * @param string $orderType
     * @return mixed
     *
     */
    public static function getAllPaymentOrders($statusId = "42,43,44", $limit, $offset, $orderBy = null, $orderType = 'asc')
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME . ' where '.static::notDeleted().' and status_pao in ('.$statusId.')            
                group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;
        $query = $ci->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public static function searchPaymentOrders($statusId = "42,43,44", $text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null)
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME;
        $sql .= ' where '.static::notDeleted().' and status_pao in ('.$statusId.') and (';
        foreach ($colsArray as $var)
        {
            $sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
        }

        $sql = substr($sql, 0, -3);
        $sql .= ') group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;

        $query = $ci->db->query($sql);
        return $query->result();
    }

    public static function searchTotalCountPaymentOrders($statusId = "42,43,44", $text, $colsArray = null)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = 'select count(' . static::TABLE_ID . ') as total from ' . static::TABLE_NAME;
        $sql .= ' where '.static::notDeleted().' and status_pao in ('.$statusId.')  and (';

        foreach ($colsArray as $var)
        {
            $sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
        }

        $sql = substr($sql, 0, -3);
        $sql .= ')';

        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        return $totalCount;
    }

    private static function _dataTableColumns()
    {
        $columns = static::TABLE_NAME.".*";
        return $columns;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS
}
