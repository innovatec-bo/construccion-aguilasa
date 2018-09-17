<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 05/09/2018
 * Time: 11:57 AM
 */

class Model_payment_order_project extends Model_payment_order_project_base
{
    public function __construct($orderId = NULL, $projectId = NULL)
    {
        parent::__construct($orderId, $projectId);
    }

	public static function getDetailByPaymentOrderId($paymentOrderId)
	{
		$ci = &get_instance();
		$ci->load->database();
		$sql = "
		SELECT 
			wfl_payment_orders_projects.*,
			id_pro,
			code_pro
		FROM
		wfl_payment_orders_projects
		left join wfl_projects on id_pro = project_id_pop
		where 
		order_id_pop = ".$ci->db->escape($paymentOrderId)."
		and deleted_pop != 1
		";
		$query = $ci->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
}
