<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2022-02-13
 * Time: 20:59:51
 */

class Model_production_limit extends Model_production_limit_base
{
    public function __construct(int $projectId, float $limit, string $startDate, string $endDate = NULL)
    {
        parent::__construct($projectId, $limit, $startDate, $endDate);
    }

    public static function getByProjectId($projectId)
    {
        $ci = &get_instance();
		$ci->load->database();

		$sql = "
            select * from ".static::TABLE_NAME." where project_id_prl = ".$ci->db->escape($projectId)." and ".static::notDeleted()."
        ";

		$query = $ci->db->query($sql);
		return static::recast(get_called_class(), $query->row());
    }

    public static function newProductionLimit(int $projectId, float $productionLimit)
    {
        /** @var $productionLimit Model_production_limit */
        $oldProductionLimit = Model_production_limit::getByProjectId($projectId);
        $oldProductionLimit->setEndDate(date('Y-m-d H:i:s'));
        $oldProductionLimit->save();
        $oldProductionLimit->delete();

        $productionLimit = new Model_production_limit($projectId, $productionLimit, date('Y-m-d H:i:s'), null);
        $productionLimit->save();
    }
}