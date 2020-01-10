<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_tracking_list extends Model_tracking_list_base
{
    public function __construct($listName = "", $codeList = "")
    {
        parent::__construct($listName, $codeList);
    }

    public static function getByName($name)
    {
    	$ci = &get_instance();
    	$ci->load->database();

    	$sql = "
    		select 
    			".static::TABLE_NAME.".* 
    		from ".static::TABLE_NAME."
    		where 
    			list_name_trl = ".$ci->db->escape($name)."
    	";

    	$query = $ci->db->query($sql);
    	$result = static::recast(get_called_class(), $query->row());
    	return $result;
    }
}