<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_feature extends Model_feature_base
{
    public function __construct($featureName, $securityString, $featureIcon, $link, $description, $parentFeatureId)
    {
        parent::__construct($featureName, $securityString, $featureIcon, $link, $description, $parentFeatureId);
    }

    public static function getFeatures()
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            f.id_fes feature_id,
            f.featurename_fes feature_name,
            pf.id_fes parent_id,
            pf.featurename_fes parent_name
        FROM
            sec_features f
        LEFT JOIN sec_features pf on f.parent_feature_id_fes = pf.id_fes
        ORDER BY f.id_fes
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getByRoleId($roleId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
        SELECT
            sec_features.*
        FROM
            sec_features
        LEFT JOIN sec_permissions on featureid_per = id_fes
        WHERE
        roleid_per = ".$ci->db->escape($roleId)."
        and deleted_fes != 1
        and deleted_per != 1
        ";

        $query = $ci->db->query($sql);
        $result = static::recastArray(get_called_class(), $query->result());
        return $result;
    }

    public static function getBySecurityString($securityString)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            SELECT
                sec_features.*
            FROM
                sec_features
            WHERE
            securitystring_fes = ".$ci->db->escape($securityString)."
            and deleted_fes != 1
        ";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }

    public static function getBySecurityStringAndNotFeatureId($securityString, $featureId)
    {
        $ci = &get_instance();
        $ci->load->database();

        $sql = "
            SELECT
                sec_features.*
            FROM
                sec_features
            WHERE
            securitystring_fes = ".$ci->db->escape($securityString)."
            and id_fes != ".$ci->db->escape($featureId)."
            and deleted_fes != 1
        ";

        $query = $ci->db->query($sql);
        $result = static::recast(get_called_class(), $query->row());
        return $result;
    }

    public static function securityStringDuplicated($securityString, $featureId = NULL)
    {
        $alreadyExist = FALSE;
        //add feature
        if(is_null($featureId))
        {
            $feature = static::getBySecurityString($securityString);
        }
        //edit feature
        else
        {
            $feature = static::getBySecurityStringAndNotFeatureId($securityString, $featureId);
        }

        if($feature instanceof Model_feature)
        {
            $alreadyExist = TRUE;
        }

        return $alreadyExist;
    }
}