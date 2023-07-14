<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 15/11/2018
 * Time: 10:25 AM
 */

class Model_contract extends Model_contract_base
{
    public function __construct($contractNumber = "", $amount = 0, $startDate = NULL, $expirationDate = NULL, $umbo = 0)
    {
        parent::__construct($contractNumber, $amount, $startDate, $expirationDate, $umbo);
    }

    public static function getNotExpiredContracts()
    {
    	$ci = &get_instance();
    	$ci->load->database();

    	$sql = "
    		select * from wfl_contracts where deleted_con != 1 and expiration_date_con > ".$ci->db->escape(date("Y-m-d H:i:s"))."
    	";
    	$query = $ci->db->query($sql);
    	$result = static::recastArray(get_called_class(), $query->result());
    	return $result;
    }

	public static function getActiveContract()
	{
		$ci = &get_instance();
    	$ci->load->database();

    	$sql = "
    		select * from wfl_contracts where active = 1 and deleted_con != 1
    	";
    	$query = $ci->db->query($sql);
    	$result = static::recast(get_called_class(), $query->row());
    	return $result;
	}
}