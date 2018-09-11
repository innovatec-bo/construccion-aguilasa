<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_status_log_responsible extends Model_status_log_responsible_base
{
    public function __construct($statusLogId = NULL, $responsibleId = NULL)
    {
        parent::__construct($statusLogId, $responsibleId);
    }

    /**
     * @param $statusLogId
     * @param $responsibleList array ids referenced to status responsible
     */
    public static function addResponsible($statusLogId, $responsibleList)
    {
        $ci = &get_instance();
        $ci->load->database();

        $arrayToSave = array();
        foreach ($responsibleList as $responsibleId)
        {
            $arrayToSave[] = array(
                "status_log_id_slr" => $statusLogId,
                "responsible_id_slr" =>  $responsibleId,
                "deleted_slr" => 0,
                "createdon_slr" => date("Y-m-d -H:i:s"),
                "createdby_slr" => NULL,
                "editedon_slr" => "",
                "editedby_slr" => NULL
            );
        }

        if(count($arrayToSave) > 0)
        {
            $ci->db->insert_batch(Model_status_log_responsible::TABLE_NAME, $arrayToSave);
        }
    }

    public static function getByStatusLogId($statusLogId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            select * from ".static::TABLE_NAME." where status_log_id_slr = ".$ci->db->escape($statusLogId)."
        ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}