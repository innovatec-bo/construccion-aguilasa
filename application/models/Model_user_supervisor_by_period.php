<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2020-08-05
 * Time: 16:39:59
 */

class Model_user_supervisor_by_period extends Model_user_supervisor_by_period_base
{
    public function __construct($userId = NULL, $supervisorId = NULL, $from = NULl, $to = NULL)
	{
		parent::__construct($userId, $supervisorId, $from, $to);
	}

	/**
	 * Return the fiscals and builders matching by a date range given
	 * @param array $dateRange
	 */
	public static function getAssignmentByDateRange($dateRange = array())
	{
		$ci = &get_instance();
		$ci->load->database();

		$from = $dateRange['from'];
		$to = $dateRange['to'];

		$sql = "
			SELECT	
				fiscals.id_usr fiscal_id,
				fiscals.firstname_usr fiscal_firstname,
				fiscals.lastname_usr fiscal_lastname,
				CONCAT(fiscals.firstname_usr,' ',fiscals.lastname_usr) fiscal_fullname,
				user_id_usp,
				builders.id_usr builder_id,
				builders.firstname_usr builder_firstname,
				builders.lastname_usr builder_lastname,
				CONCAT(builders.firstname_usr,' ',builders.lastname_usr) builder_fullname
			FROM
				sec_users fiscals
			LEFT JOIN sec_userroles on userid_uro = fiscals.id_usr and deleted_uro != 1
			LEFT JOIN sec_roles on roleid_uro = id_rol and deleted_rol != 1
			LEFT JOIN sec_user_supervisor_by_period on supervisor_id_usp = fiscals.id_usr and deleted_usp != 1 and from_usp >= ".$ci->db->escape($from)." and to_usp <= ".$ci->db->escape($to)."
			LEFT JOIN sec_users builders on builders.id_usr = user_id_usp
			where
			keyword_rol = 'fiscal'
			GROUP BY fiscals.id_usr, user_id_usp;
		";
		$query = $ci->db->query($sql);
		$result = $query->result_array();

		$list = array();
		foreach ($result as $row)
		{
			$fiscalId = $row['fiscal_id'];
			$builderId = $row['builder_id'];

			if(!isset($list[$fiscalId]['builders'][$builderId]))
			{
				$list[$fiscalId]['id'] = $row['fiscal_id'];
				$list[$fiscalId]['firstName'] = $row['fiscal_firstname'];
				$list[$fiscalId]['lastName'] = $row['fiscal_lastname'];
				$list[$fiscalId]['fullName'] = $row['fiscal_fullname'];
			}
			if(!is_null($builderId))
			{
				$list[$fiscalId]['builders'][$builderId]['id'] = $row['builder_id'];
				$list[$fiscalId]['builders'][$builderId]['firstName'] = $row['builder_firstname'];
				$list[$fiscalId]['builders'][$builderId]['lastName'] = $row['builder_lastname'];
				$list[$fiscalId]['builders'][$builderId]['fullName'] = $row['builder_fullname'];
			}
			else
			{
				$list[$fiscalId]['builders'] = array();
			}
		}
		foreach ($list as &$row)
		{
			$row['builders'] = array_values($row['builders']);
		}
		return $list;
	}

	public static function getAvailableBuildersByDateRange($dateRange)
	{
		$ci = &get_instance();
		$ci->load->database();

		$from = $dateRange['from'];
		$to = $dateRange['to'];

		$sql = "
			SELECT
				id_usr builder_id,
				firstname_usr builder_firstname,
				lastname_usr builder_lastname,
				concat(firstname_usr,' ',lastname_usr) builder_fullname
			FROM
				sec_users
			LEFT JOIN sec_userroles on userid_uro = id_usr and deleted_uro != 1
			LEFT JOIN sec_roles on roleid_uro = id_rol and deleted_rol != 1
			where
			keyword_rol = 'builder'
			and id_usr not in (
				select 
					user_id_usp 
				from 
					sec_user_supervisor_by_period 
				where 
				from_usp >= ".$ci->db->escape($from)." and to_usp <= ".$ci->db->escape($to)."
			)
			GROUP BY id_usr
			order by firstname_usr
		";

		$query = $ci->db->query($sql);
		return $query->result_array();
	}

	public static function saveDistributionList($dateRange, $distributionList)
	{
		date_default_timezone_set('America/La_Paz');
		$now = new DateTime();
		$currentDate = $now->format( "Y-m-d H:i:s" );
		$currentUser = PrivateController::getSessionUser();
		$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
		$startDate = $dateRange['from'];
		$endDate = $dateRange['to'];
		$dataToSave = array();

		foreach ($distributionList as $fiscal)
		{//echo"<pre>";var_dump($fiscal);exit;
			$fiscalId = $fiscal['fiscalId'];
			$builderList = array();
			if(isset($fiscal['builderList']))
				$builderList = $fiscal['builderList'];
			foreach ($builderList as $builder)
			{
				$builderId = $builder['builderId'];
				$dataToSave[] = array(
					'user_id_usp' => $builderId,
					'supervisor_id_usp' => $fiscalId,
					'from_usp' => $startDate,
					'to_usp' => $endDate,
					'createdon_usp' => $currentDate,
					'createdby_usp' => $currentUserId
				);
			}
		}
		Model_user_supervisor_by_period::deleteByDateRange($dateRange);
		if(count($dataToSave) > 0)
			Model_user_supervisor_by_period::insertBatch($dataToSave);
	}

	public static function deleteByDateRange($dateRange)
	{
		$ci = &get_instance();
		$ci->load->database();

		$from = $dateRange['from'];
		$to = $dateRange['to'];
		date_default_timezone_set('America/La_Paz');
		$now = new DateTime();
		$currentDate = $now->format( "Y-m-d H:i:s" );
		$currentUser = PrivateController::getSessionUser();
		$currentUserId = isset($currentUser) ? $currentUser->id:NULL;
		$sql = "
			update ".static::TABLE_NAME."
			set
				deleted_usp = 1,
				editedon_usp = ".$ci->db->escape($currentDate).",
				editedby_usp = ".$currentUserId."
			where
				from_usp >= ".$ci->db->escape($from)." and to_usp <= ".$ci->db->escape($to)."
		";

		$ci->db->query($sql);
	}
}
