<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 27/04/2018
 * Time: 2:35 PM
 */

class Model_building_point_base extends MY_Model
{
    const TABLE_NAME = "bui_building_points";
    const TABLE_ID = "id_bpo";
    const ATTRIB_SUFIX = "_bpo";

    protected $_projectId;
    protected $_label;
    protected $_latitude;
    protected $_longitude;
    protected $_previousPoint;
    protected $_distance;
    protected $_angle;

    public function __construct($projectId = NULL, $label = "", $latitude = "", $longitude = "", $previousPoint = "", $distance = "", $angle = "")
    {
        parent::__construct();
        $this->_projectId = $projectId;
        $this->_label = $label;
        $this->_latitude = $latitude;
        $this->_longitude = $longitude;
        $this->_previousPoint = $previousPoint;
        $this->_distance = $distance;
        $this->_angle = $angle;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_bpo" => $this->_id,
            "project_id_bpo" => $this->_projectId,
            "label_bpo" => $this->_label,
            "latitude_bpo" => $this->_latitude,
            "longitude_bpo" => $this->_longitude,
            "previous_point_bpo" => $this->_previousPoint,
            "distance_bpo" => $this->_distance,
            "angle_bpo" => $this->_angle,
            "deleted_bpo" => $this->_deleted,
            "createdon_bpo" => $this->_createdOn,
            "createdby_bpo" => $this->_createdBy,
            "editedon_bpo" => $this->_editedOn,
            "editedby_bpo" => $this->_editedBy
        );
        return $tableAttributes;
    }

    /**
     * @param $className
     * @param $object
     * @return object
     */
    protected static function recast($className, $object)
    {
        $response =  null;
        if ($object instanceof stdClass)
        {
            if (!class_exists($className))
                throw new InvalidArgumentException(sprintf('Inexistant class %s.', $className));

            //Let's set the values to payment object using the data from stdObject
            $instance = new $className(
                $object->project_id_bpo,
                $object->label_bpo,
                $object->latitude_bpo,
                $object->longitude_bpo,
                $object->previous_point_bpo,
                $object->distance_bpo,
                $object->angle_bpo
            );
            $instance->_id = $object->id_bpo;

            $instance->_deleted = $object->deleted_bpo;
            $instance->_createdOn = $object->createdon_bpo;
            $instance->_createdBy = $object->createdby_bpo;
            $instance->_editedOn = $object->editedon_bpo;
            $instance->_editedBy = $object->editedby_bpo;
            $response = $instance;
        }
        return $response;
    }

	################################################################################################# BEGIN - DATATABLE AJAX METHODS
	/**
	 * @return mixed
	 */
	public static function countAll($additionalParameters = array())
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = '
                select count(' . static::TABLE_ID. ') as total
                from ' . static::TABLE_NAME .' where '.static::notDeleted().' '.static::_additionalParameters($additionalParameters).' ';

		$query = $ci->db->query($sql);
		$totalCount = $query->row()->total;
		return $totalCount;
	}

	/**
	 * @param $limit
	 * @param $offset
	 * @param null $orderBy
	 * @param string $orderType
	 * @return mixed
	 */
	public static function getAll($limit, $offset, $orderBy = null, $orderType = 'asc', $additionalParameters = array())
	{
		if ($orderBy === null)
		{
			$orderBy = static::TABLE_ID;
		}
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME . ' where '.static::notDeleted().'             
                '.static::_additionalParameters($additionalParameters).' group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;
		$query = $ci->db->query($sql);
		$result = $query->result();
		return $result;
	}

	public static function search($text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null, $additionalParameters = array())
	{
		if ($orderBy === null)
		{
			$orderBy = static::TABLE_ID;
		}
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select '.static::_dataTableColumns().' from ' . static::TABLE_NAME;
		$sql .= ' where '.static::notDeleted().' and (';
		foreach ($colsArray as $var)
		{
			$sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
		}

		$sql = substr($sql, 0, -3);
		$sql .= ') '.static::_additionalParameters($additionalParameters).' group by '.static::TABLE_ID.' order by ' . $orderBy . ' ' . $orderType . ' limit ' . $limit . ' offset ' . $offset;

		$query = $ci->db->query($sql);
		return $query->result();
	}

	public static function searchTotalCount($text, $colsArray = null, $additionalParameters = array())
	{
		$ci = &get_instance();
		$ci->load->database();

		$sql = 'select count(' . static::TABLE_ID . ') as total from ' . static::TABLE_NAME;
		$sql .= ' where '.static::notDeleted().' and (';

		foreach ($colsArray as $var)
		{
			$sql .= ' ' . $var . ' like \'%' . $text . '%\' or ';
		}

		$sql = substr($sql, 0, -3);
		$sql .= ') '.static::_additionalParameters($additionalParameters).' ';

		$query = $ci->db->query($sql);
		$totalCount = $query->row()->total;
		return $totalCount;
	}

	private static function _dataTableColumns()
	{
		$columns = static::TABLE_NAME.".*";
		return $columns;
	}

	private static function _additionalParameters($list = array())
	{
		$ci=&get_instance();
		$ci->load->database();
		$sql = "";
		if(is_array($list) && count($list) >= 1)
		{
			foreach($list as $parameter => $value)
			{
				switch ($parameter)
				{
					case "project-id":
						$sql .= " and project_id_bpo = ".$ci->db->escape($value)." ";
						break;
				}
			}
		}
		return $sql;
	}
	################################################################################################# END - DATATABLE AJAX METHODS
}
