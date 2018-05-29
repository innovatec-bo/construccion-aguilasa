<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 29/11/2017
 * Time: 2:35 PM
 */

class Model_feature extends Model_feature_base
{
    public function __construct($featureName, $securityString, $featureIcon, $link, $description, $parentFeatureId, $order, $isMenu)
    {
        parent::__construct($featureName, $securityString, $featureIcon, $link, $description, $parentFeatureId, $order, $isMenu);
    }

    public static function getFeaturesTreeSeed()
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
        WHERE
        f.deleted_fes != 1
        ORDER BY f.order_fes
        ";

        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public static function getFeaturesTreeSeedByRoleArray(array $arrayRoles = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $ids = array_keys($arrayRoles);

        $stringList = "";
        foreach ($ids as $id)
        {
            $stringList .= $ci->db->escape($id).",";
        }
        $stringList = substr($stringList,0,-1);
        $sql = "
        SELECT
            DISTINCT 
            f.*,
            f.id_fes feature_id,
            f.featurename_fes feature_name,
            pf.id_fes parent_id,
            pf.featurename_fes parent_name
        FROM
                sec_features f
        LEFT JOIN sec_features pf on f.parent_feature_id_fes = pf.id_fes
        LEFT JOIN sec_permissions on featureid_per = f.id_fes
        where
            f.deleted_fes != 1
            and deleted_per != 1
            and roleid_per in (".$stringList.")
            ORDER BY f.order_fes
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

    public static function getByRoleArrayIds(array $arrayRoles = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $ids = array_keys($arrayRoles);

        $stringList = "";
        foreach ($ids as $id)
        {
            $stringList .= $ci->db->escape($id).",";
        }
        $stringList = substr($stringList,0,-1);
        $sql = "
        SELECT
            DISTINCT sec_features.*
        FROM
            sec_features
        LEFT JOIN sec_permissions on featureid_per = id_fes
        WHERE
        roleid_per in(".$stringList.")
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

    public static function drawTree($currentFeatureId, array $list, array $tree)
    {
        $results = array_filter($list, function($item) use($currentFeatureId){
            if($item["parent_id"] == $currentFeatureId)
                return $item;
        });

        foreach($results as $feature)
        {
            $currentFeatureId = $feature["feature_id"];
            $isGroup = array_filter($list, function($item) use($currentFeatureId){
                if($item["parent_id"] == $currentFeatureId)
                    return $item;
            });
            $isGroup = count($isGroup) > 0?TRUE:FALSE;

            $children = array();
            if($isGroup)
            {
                $children = static::drawTree($feature["feature_id"], $list, $children);
            }

            if(count($children) > 0)
            {
                $tree[] = array(
                    "id" => $feature["feature_id"],
                    "text" => $feature["feature_name"],
                    "state" => array("opened" => true),
                    "children" => $children
                );
            }
            else
            {
                $tree[] = array(
                    "id" => $feature["feature_id"],
                    "text" => $feature["feature_name"],
                    "state" => array("opened" => true),
                    "children" => array()
                );
            }
        }
        return $tree;
    }

    public static function drawTreeHtml($currentFeatureId, array $list, array $tree, $level = 1, $treeHtml = "")
    {
        $treeLevelCss = array(1 => "", 2 => " nav-second-level ", 3 => " nav-third-level ");
        $results = array_filter($list, function($item) use($currentFeatureId){
            if($item["parent_id"] == $currentFeatureId)
                return $item;
        });

        foreach($results as $feature)
        {
            $currentFeatureId = $feature["feature_id"];
            $isGroup = array_filter($list, function($item) use($currentFeatureId){
                if($item["parent_id"] == $currentFeatureId)
                    return $item;
            });
            $isGroup = count($isGroup) > 0?TRUE:FALSE;

            $children = array();
            $childrenTreeHtml = "";
            if($isGroup)
            {
                $childrenTreeHtml = static::drawTreeHtml($feature["feature_id"], $list, $children, $level+1);
            }

            if($feature["is_menu_fes"] == 1)
            {
                if($childrenTreeHtml != "")
                {
                    $childrenTreeHtml = '
                    <ul class="nav '.$treeLevelCss[$level+1].' collapse">
                        '.$childrenTreeHtml.'
                    </ul>
                ';
                    $treeHtml .= '
                    <li>
                        <a href="'.base_url($feature["link_fes"]).'"><i class="'.$feature["featureicon_fes"].' fa-fw"></i> '.$feature["feature_name"].'<span class="fa arrow"></span></a>
                        '.$childrenTreeHtml.'
                    </li>
                ';
                }
                else
                {
                    $treeHtml .= '
                    <li>
                        <a href="'.base_url($feature["link_fes"]).'"><i class="'.$feature["featureicon_fes"].' fa-fw"></i> '.$feature["feature_name"].'</a>
                    </li>
                ';
                }
            }
        }
        return $treeHtml;
    }

    public static function sortAllFeatureByArray(array $featureList)
    {
        $ci = &get_instance();
        $ci->load->database();

        $featureToUpdate = array();
        $i = 1;
        foreach ($featureList as $feature)
        {
            $featureToUpdate[] = array(
                "id_fes" => $feature["id"],
                "order_fes" => $i
            );
            $i++;
        }
        if(count($featureToUpdate) > 0)
        {
            $ci->db->update_batch(static::TABLE_NAME, $featureToUpdate, static::TABLE_ID);
        }
    }
}