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
}