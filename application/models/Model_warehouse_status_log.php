<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 30/08/2018
 * Time: 10:35 AM
 */

class Model_warehouse_status_log extends Model_warehouse_status_log_base
{
    public function __construct($warehouseId = NULL, $statusId = NULL, $logDetail = "", $manualEntryDate = "")
    {
        parent::__construct($warehouseId, $statusId, $logDetail, $manualEntryDate);
    }

    public static function getLastProjectStatusLogByProjectId($projectId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
            select ".static::TABLE_NAME.".* 
            from ".static::TABLE_NAME."
            where
                ".static::notDeleted()."
                and project_id_wsl = ".$ci->db->escape($projectId)."
                order by createdon_wsl desc limit 1 
        ";
        $query = $ci->db->query($sql);//echo"<pre>";var_dump($sql);exit;
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }

    public static function getLogByWarehouseId($warehouseId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            wfl_warehouse_status_log.*,
            status_name_pst,
            keyword_pst
        FROM
                wfl_warehouse_status_log
        LEFT JOIN wfl_project_status ON status_id_wsl = id_pst
        LEFT JOIN wfl_warehouses on id_war = warehouse_id_wsl
        WHERE
                warehouse_id_wsl = ".$ci->db->escape($warehouseId)."
                and deleted_wsl != 1
        GROUP BY id_wsl
        ORDER BY manual_entry_date_wsl DESC
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getLogByWarehouseIdAndStatusKeyWord($warehouseId, $statusKeyword)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        SELECT
            wfl_warehouse_status_log.*,
            status_name_pst,
            keyword_pst
        FROM
            wfl_warehouse_status_log
        LEFT JOIN wfl_project_status ON status_id_wsl = id_pst
        WHERE
            warehouse_id_wsl = " . $ci->db->escape($warehouseId) . "
            and keyword_pst = ".$ci->db->escape($statusKeyword)."
        GROUP BY id_wsl
        ORDER BY manual_entry_date_wsl DESC
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}