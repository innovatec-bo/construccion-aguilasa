<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/08/2018
 * Time: 10:35 AM
 */

class Model_payment_order_status_log extends Model_payment_order_status_log_base
{
    public function __construct($paymentOrderId = NULL, $statusId = NULL, $logDetail = "", $manualEntryDate = "")
	{
		parent::__construct($paymentOrderId, $statusId, $logDetail, $manualEntryDate);
	}

    public static function getLogByPaymentOrderId($paymentOrderId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            wfl_payment_orders_status_log.*,
            status_name_pst,
            keyword_pst
        FROM
                wfl_payment_orders_status_log
        LEFT JOIN wfl_project_status ON status_id_pos = id_pst
        LEFT JOIN wfl_payment_orders on id_pao = payment_order_id_pos
        WHERE
                payment_order_id_pos = ".$ci->db->escape($paymentOrderId)."
                and deleted_pos != 1
        GROUP BY id_pos
        ORDER BY manual_entry_date_pos DESC
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getLogByPaymentOrderIdAndStatusKeyWord($warehouseId, $statusKeyword)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            wfl_payment_orders_status_log.*,
            status_name_pst,
            keyword_pst
        FROM
            wfl_payment_orders_status_log
        LEFT JOIN wfl_project_status ON status_id_pos = id_pst
        WHERE
            payment_order_id_pos = " . $ci->db->escape($warehouseId) . "
            and keyword_pst = ".$ci->db->escape($statusKeyword)."
        GROUP BY id_pos
        ORDER BY manual_entry_date_pos DESC
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}
