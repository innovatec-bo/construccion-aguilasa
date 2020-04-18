<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 04/06/2018
 * Time: 10:21 AM
 */

class Model_project_base extends MY_Model
{
    const TABLE_NAME = "wfl_projects";
    const TABLE_ID = "id_pro";
    const ATTRIB_SUFIX = "_pro";

    protected $_projectCode;
    protected $_projectName;
    protected $_system;
    protected $_address;
    protected $_entryDate;
    protected $_creFiscal;
    protected $_status;
    protected $_projectStart;
    protected $_projectEnd;
    protected $_points;
    protected $_distance;
    protected $_managementBy;
    protected $_qualityLevel;
    protected $_creDesignCompletionDate;
    protected $_creBuildingCompletionDate;
    protected $_budgetaryPosition;
    protected $_secondaryCode;
    protected $_folderDate;
    protected $_contractId;
    protected $_detail;
    protected $_energized;
    protected $_projectPercentage;
    protected $_latitude;
    protected $_longitude;
    protected $_workArea;
    protected $_projectYear;

    public function __construct($projectCode = "", $projectName = "", $system = NULL, $address = "", $entryDate = "", $creFiscal = "", $status = NULL, $projectStart = "", $projectEnd = "", $points = 0, $distance = 0,
                                $managementBy = NULL, $qualityLevel = 0, $creDesignCompletionDate = "", $creBuildingCompletionDate = "", $budgetaryPosition = 0, $secondaryCode = "", $folderDate = "", $contractId = NULL, $detail = "", $energized = 0, $projectPercentage = 0, $latitude = "",
                                $longitude = "", $workArea = "", $projectYear = "")
    {
        parent::__construct();
        $this->_projectCode = $projectCode;
        $this->_projectName = $projectName;
        $this->_system = $system;
        $this->_address = $address;
        $this->_entryDate = $entryDate;
        $this->_creFiscal = $creFiscal;
        $this->_status = $status;
        $this->_projectStart = $projectStart;
        $this->_projectEnd = $projectEnd;
        $this->_points = $points;
        $this->_distance = $distance;
        $this->_managementBy = $managementBy;
        $this->_qualityLevel = $qualityLevel;
        $this->_creDesignCompletionDate = $creDesignCompletionDate;
        $this->_creBuildingCompletionDate = $creBuildingCompletionDate;
        $this->_budgetaryPosition = $budgetaryPosition;
        $this->_secondaryCode = $secondaryCode;
        $this->_folderDate = $folderDate;
        $this->_contractId = $contractId;
        $this->_detail = $detail;
        $this->_energized = $energized;
        $this->_projectPercentage = $projectPercentage;
        $this->_latitude = $latitude;
        $this->_longitude = $longitude;
        $this->_workArea = $workArea;
        $this->_projectYear = $projectYear;
    }

    /**
     * Parse the current object to key => value array
     * @return array
     */
    public function toArray()
    {
        $tableAttributes = array(
            "id_pro" => $this->_id,
            "code_pro" => $this->_projectCode,
            "project_name_pro" => $this->_projectName,
            "system_pro" => $this->_system,
            "address_pro" => $this->_address,
            "entry_date_pro" => $this->_entryDate,
            "cre_fiscal_pro" => $this->_creFiscal,
            "status_pro" => $this->_status,
            "project_start_pro" => $this->_projectStart,
            "project_end_pro" => $this->_projectEnd,
            "points_pro" => $this->_points,
            "distance_pro" => $this->_distance,
            "management_by_pro" => $this->_managementBy,
            "quality_level_pro" => $this->_qualityLevel,
            "cre_design_completion_date_pro" => $this->_creDesignCompletionDate,
            "cre_building_completion_date_pro" => $this->_creBuildingCompletionDate,
            "budgetary_position_pro" => $this->_budgetaryPosition,
            "secondary_code_pro" => $this->_secondaryCode,
            "folder_date_pro" => $this->_folderDate,
            "contract_id_pro" => $this->_contractId,
            "project_percentage_pro" => $this->_projectPercentage,
            "detail_pro" => $this->_detail,
            "energized_pro" => $this->_energized,
            "latitude_pro" => $this->_latitude,
            "longitude_pro" => $this->_longitude,
            "work_area_pro" => $this->_workArea,
            "project_year_pro" => $this->_projectYear,
            "deleted_pro" => $this->_deleted,
            "createdon_pro" => $this->_createdOn,
            "createdby_pro" => $this->_createdBy,
            "editedon_pro" => $this->_editedOn,
            "editedby_pro" => $this->_editedBy
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
                $object->code_pro,
                $object->project_name_pro,
                $object->system_pro,
                $object->address_pro,
                $object->entry_date_pro,
                $object->cre_fiscal_pro,
                $object->status_pro,
                $object->project_start_pro,
                $object->project_end_pro,
                $object->points_pro,
                $object->distance_pro,
                $object->management_by_pro,
                $object->quality_level_pro,
                $object->cre_design_completion_date_pro,
                $object->cre_building_completion_date_pro,
                $object->budgetary_position_pro,
                $object->secondary_code_pro,
                $object->folder_date_pro,
                $object->contract_id_pro,
                $object->detail_pro,
                $object->energized_pro,
                $object->project_percentage_pro,
                $object->latitude_pro,
                $object->longitude_pro,
                $object->work_area_pro,
                $object->project_year_pro
            );
            $instance->_id = $object->id_pro;

            $instance->_deleted = $object->deleted_pro;
            $instance->_createdOn = $object->createdon_pro;
            $instance->_createdBy = $object->createdby_pro;
            $instance->_editedOn = $object->editedon_pro;
            $instance->_editedBy = $object->editedby_pro;
            $response = $instance;
        }
        return $response;
    }

    public function setProjectName($projectName)
    {
        $this->_projectName = $projectName;
    }

    public function setCode($code)
    {
        $this->_projectCode = $code;
    }

    public function setStatus($statusId)
    {
        $this->_status = $statusId;
    }

    public function setSystem($system)
    {
        $this->_system = $system;
    }

    public function setAddress($address)
    {
        $this->_address = $address;
    }

    public function setCREFiscal($creFiscal)
    {
        $this->_creFiscal = $creFiscal;
    }

    public function setStart($start)
    {
        $this->_projectStart = $start;
    }

    public function setEnd($end)
    {
        $this->_projectEnd = $end;
    }

    public function setManagementBy($managementBy)
    {
        $this->_managementBy = $managementBy;
    }

    public function setQualityLevel($qualityLevel)
    {
        $this->_qualityLevel = $qualityLevel;
    }

    public function setCreDesignCompletionDate($creDesignCompletionDate)
    {
        $this->_creDesignCompletionDate = $creDesignCompletionDate;
    }

    public function setCreBuildingCompletionDate($creBuildingCompletionDate)
    {
        $this->_creBuildingCompletionDate = $creBuildingCompletionDate;
    }

    public function setBudgetaryPosition($budgetaryPosition)
    {
        $this->_budgetaryPosition = $budgetaryPosition;
    }

    public function setSecondaryCode($secondaryCode)
    {
        $this->_secondaryCode = $secondaryCode;
    }

    public function setFolderDate($folderDate)
    {
        $this->_folderDate = $folderDate;
    }

    public function setContractId($contractId)
    {
        $this->_contractId = $contractId;
    }

    public function setDetail($detail)
    {
        $this->_detail = $detail;
    }

    public function setEnergized($energized)
    {
        $this->_energized = $energized;
    }

    public function setProjectPercentage($projectPercentage)
    {
        $this->_projectPercentage = $projectPercentage;
    }

    public function setLatitude($latitude)
    {
        $this->_latitude = $latitude;
    }

    public function setLongitude($longitude)
    {
        $this->_longitude = $longitude;
    }

    public function setWorkArea($workArea)
    {
        $this->_workArea = $workArea;
    }

    public function setProjectYear($projectYear)
    {
        $this->_projectYear = $projectYear;
    }

    public function getCode()
    {
        return $this->_projectCode;
    }

    public function getSecondaryCode()
    {
        return $this->_secondaryCode;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function getEntryDate()
    {
        return $this->_entryDate;
    }

    public function getEnergized()
    {
        return $this->_energized;
    }

    public function getProjectPercentage()
    {
        return $this->_projectPercentage;
    }

    public function getLatitude()
    {
        return $this->_latitude;
    }

    public function getLongitude()
    {
        return $this->_longitude;
    }

    public function getWorkArea()
    {
        return $this->_workArea;
    }

    public function getProjectYear()
    {
        return $this->_projectYear;
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
            select count(id_pro) as total from
            (
                SELECT
                    '.static::_dataTableColumns().'
                FROM
                    wfl_projects
                LEFT JOIN (
                    select * from (
                        select
                            project_id_psl project_id, max(manual_entry_date_psl) max_date
                            from (
                                SELECT
                                    project_id_psl,
                                    manual_entry_date_psl
                                FROM
                                    wfl_project_status_log
                                LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                                where deleted_psl != 1 and deleted_slr != 1
                                GROUP BY id_psl
                            ) statusLogAndResponsible group by project_id_psl
                    ) as max_entry
                LEFT JOIN (
                    SELECT
                        id_psl,
                        project_id_psl,
                        log_detail_psl,
                        manual_entry_date_psl,
                        GROUP_CONCAT(CONCAT(firstname_usr," ",lastname_usr)) responsible,
                        GROUP_CONCAT(id_usr) responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1
                    GROUP BY id_psl
                    ) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl fiscal_id_psl,
                        project_id_psl fiscal_project_id_psl,
                        log_detail_psl fiscal_log_detail_psl,
                        manual_entry_date_psl fiscal_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr," ",lastname_usr)) fiscal_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) fiscal_responsible_id
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 8
                    GROUP BY id_psl
                ) log_fiscal on log_fiscal.fiscal_project_id_psl = max_entry.project_id and log_fiscal.fiscal_manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl builder_id_psl,
                        project_id_psl builder_project_id_psl,
                        log_detail_psl builder_log_detail_psl,
                        manual_entry_date_psl builder_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr," ",lastname_usr)) builder_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) builder_responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 9
                    GROUP BY id_psl
                ) log_builder on log_builder.builder_project_id_psl = max_entry.project_id and log_builder.builder_manual_entry_date_psl = max_entry.max_date
            ) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
                LEFT JOIN wfl_project_status on status_pro = id_pst
                LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
                LEFT JOIN (
                    select inc.*
                    from (
                       select
                            project_id_inc,
                            max(manual_entry_date_inc) manual_entry_date_inc
                            from wfl_incidents
                            where status_id_inc in (29) -- in_progress
                            GROUP BY project_id_inc
                    ) as filtered inner join wfl_incidents as inc on inc.project_id_inc = filtered.project_id_inc and inc.manual_entry_date_inc = filtered.manual_entry_date_inc
                ) wfl_incidents on project_id_inc = id_pro
                LEFT JOIN (
                    SELECT
                        id_pro project_id,
                        wfl_project_budgets.manpower_file_id_prb manpower_file_id   
                    FROM
                        wfl_project_budgets
                    LEFT JOIN wfl_project_status_log on id_psl = status_log_id_prb
                    left join wfl_projects on id_pro = project_id_psl
                    WHERE 
                        deleted_prb != 1
                    and deleted_pro != 1
                    and deleted_psl != 1
                    and manpower_file_id_prb is not null
                ) manpower on manpower.project_id = id_pro
                WHERE
                    deleted_pro != 1
                    '.static::_additionalParameters($additionalParameters).'
            ) projects;
        ';

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

        $sql = "
        select * from
            (
                SELECT
                    ".static::_dataTableColumns()."
                FROM
                    wfl_projects
                LEFT JOIN (
                    select * from (
                        select
                            project_id_psl project_id, max(manual_entry_date_psl) max_date
                            from (
                                SELECT
                                    project_id_psl,
                                    manual_entry_date_psl
                                FROM
                                    wfl_project_status_log
                                LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                                where deleted_psl != 1 and deleted_slr != 1
                                GROUP BY id_psl
                            ) statusLogAndResponsible group by project_id_psl
                    ) as max_entry
                LEFT JOIN (
                    SELECT
                        id_psl,
                        project_id_psl,
                        log_detail_psl,
                        manual_entry_date_psl,
                        GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                        GROUP_CONCAT(id_usr) responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1
                    GROUP BY id_psl
                    ) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl fiscal_id_psl,
                        project_id_psl fiscal_project_id_psl,
                        log_detail_psl fiscal_log_detail_psl,
                        manual_entry_date_psl fiscal_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr,' ',lastname_usr)) fiscal_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) fiscal_responsible_id
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 8
                    GROUP BY id_psl
                ) log_fiscal on log_fiscal.fiscal_project_id_psl = max_entry.project_id and log_fiscal.fiscal_manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl builder_id_psl,
                        project_id_psl builder_project_id_psl,
                        log_detail_psl builder_log_detail_psl,
                        manual_entry_date_psl builder_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr,' ',lastname_usr)) builder_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) builder_responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 9
                    GROUP BY id_psl
                ) log_builder on log_builder.builder_project_id_psl = max_entry.project_id and log_builder.builder_manual_entry_date_psl = max_entry.max_date
            ) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
                LEFT JOIN wfl_project_status on status_pro = id_pst
                LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
                LEFT JOIN (
                            select inc.*
                            from (
                               select
                                    project_id_inc,
                                    max(manual_entry_date_inc) manual_entry_date_inc
                                    from wfl_incidents
                                    where status_id_inc in (29) -- in_progress
                                    GROUP BY project_id_inc
                            ) as filtered inner join wfl_incidents as inc on inc.project_id_inc = filtered.project_id_inc and inc.manual_entry_date_inc = filtered.manual_entry_date_inc
                        ) wfl_incidents on project_id_inc = id_pro
                LEFT JOIN (
                    SELECT
                        id_pro project_id,
                        wfl_project_budgets.manpower_file_id_prb manpower_file_id   
                    FROM
                        wfl_project_budgets
                    LEFT JOIN wfl_project_status_log on id_psl = status_log_id_prb
                    left join wfl_projects on id_pro = project_id_psl
                    WHERE 
                        deleted_prb != 1
                    and deleted_pro != 1
                    and deleted_psl != 1
                    and manpower_file_id_prb is not null
                ) manpower on manpower.project_id = id_pro
                WHERE
                    deleted_pro != 1
                    ".static::_additionalParameters($additionalParameters)."
            ) projects
            ORDER BY id_pro asc, ".$orderBy." ".$orderType." LIMIT ".$limit." offset ".$offset.";
        ";//echo"<pre>";var_dump($sql);exit;

        $query = $ci->db->query($sql);
        $result = $query->result();
        return $result;
    }

    /**
     * @param $text
     * @param $limit
     * @param $offset
     * @param null $orderBy
     * @param string $orderType
     * @param null $colsArray
     * @param array $additionalParameters
     * @return mixed
     */
    public static function search($text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null, $additionalParameters = array())
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        $like = "";
        if(!is_null($colsArray))
        {
            $like .= " and ( ";
            // $like .= " responsible like '%" . $text . "%' or ";
            foreach ($colsArray as $var)
            {
                $like .= " " . $var . " like '%" . $text . "%' or ";
            }
            $like = substr($like, 0, -3).") ";    
        }

        $sql = "
        select * from
        (
            SELECT
                ".static::_dataTableColumns()."
            FROM
                wfl_projects
            LEFT JOIN (
                select * from (
                    select
                        project_id_psl project_id, max(manual_entry_date_psl) max_date
                        from (
                            SELECT
                                project_id_psl,
                                manual_entry_date_psl
                            FROM
                                wfl_project_status_log
                            LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                            where deleted_psl != 1 and deleted_slr != 1
                            GROUP BY id_psl
                        ) statusLogAndResponsible group by project_id_psl
                ) as max_entry
                LEFT JOIN (
                    SELECT
                        id_psl,
                        project_id_psl,
                        log_detail_psl,
                        manual_entry_date_psl,
                        GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                        GROUP_CONCAT(id_usr) responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1
                    GROUP BY id_psl
                    ) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl fiscal_id_psl,
                        project_id_psl fiscal_project_id_psl,
                        log_detail_psl fiscal_log_detail_psl,
                        manual_entry_date_psl fiscal_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr,' ',lastname_usr)) fiscal_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) fiscal_responsible_id
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 8
                    GROUP BY id_psl
                ) log_fiscal on log_fiscal.fiscal_project_id_psl = max_entry.project_id and log_fiscal.fiscal_manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl builder_id_psl,
                        project_id_psl builder_project_id_psl,
                        log_detail_psl builder_log_detail_psl,
                        manual_entry_date_psl builder_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr,' ',lastname_usr)) builder_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) builder_responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 9
                    GROUP BY id_psl
                ) log_builder on log_builder.builder_project_id_psl = max_entry.project_id and log_builder.builder_manual_entry_date_psl = max_entry.max_date
            ) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro
            LEFT JOIN wfl_project_status on status_pro = id_pst
            LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
            LEFT JOIN (
                            select inc.*
                            from (
                               select
                                    project_id_inc,
                                    max(manual_entry_date_inc) manual_entry_date_inc
                                    from wfl_incidents
                                    where status_id_inc in (29) -- in_progress
                                    GROUP BY project_id_inc
                            ) as filtered inner join wfl_incidents as inc on inc.project_id_inc = filtered.project_id_inc and inc.manual_entry_date_inc = filtered.manual_entry_date_inc
                        ) wfl_incidents on project_id_inc = id_pro
            LEFT JOIN (
                SELECT
                    id_pro project_id,
                    wfl_project_budgets.manpower_file_id_prb manpower_file_id   
                FROM
                    wfl_project_budgets
                LEFT JOIN wfl_project_status_log on id_psl = status_log_id_prb
                left join wfl_projects on id_pro = project_id_psl
                WHERE 
                    deleted_prb != 1
                and deleted_pro != 1
                and deleted_psl != 1
                and manpower_file_id_prb is not null
            ) manpower on manpower.project_id = id_pro            
            WHERE
                deleted_pro != 1
                ".static::_additionalParameters($additionalParameters)."
        ) projects
        where
            1 = 1
            ".$like."
        ORDER BY order_pst asc, ".$orderBy." ".$orderType." LIMIT ".$limit." offset ".$offset.";
        ";

        $query = $ci->db->query($sql);
        return $query->result();
    }

    /**
     * @param $text
     * @param null $colsArray
     * @param array $additionalParameters
     * @return mixed
     */
    public static function searchTotalCount($text, $colsArray = null, $additionalParameters = array())
    {
        $ci = &get_instance();
        $ci->load->database();

        $like = "";
        if(!is_null($colsArray))
        {
            $like .= " and ( ";
            // $like .= " responsible like '%" . $text . "%' or ";
            foreach ($colsArray as $var)
            {
                $like .= " " . $var . " like '%" . $text . "%' or ";
            }
            $like = substr($like, 0, -3).") ";    
        }

        $sql = "
        select count(id_pro) as total from
        (
            SELECT
                ".static::_dataTableColumns()."
            FROM
                wfl_projects
            LEFT JOIN (
                select * from (
                    select
                        project_id_psl project_id, max(manual_entry_date_psl) max_date
                        from (
                            SELECT
                                project_id_psl,
                                manual_entry_date_psl
                            FROM
                                wfl_project_status_log
                            LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                            where deleted_psl != 1 and deleted_slr != 1
                            GROUP BY id_psl
                        ) statusLogAndResponsible group by project_id_psl
                ) as max_entry
                LEFT JOIN (
                    SELECT
                        id_psl,
                        project_id_psl,
                        log_detail_psl,
                        manual_entry_date_psl,
                        GROUP_CONCAT(CONCAT(firstname_usr,' ',lastname_usr)) responsible,
                        GROUP_CONCAT(id_usr) responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1
                    GROUP BY id_psl
                    ) log on log.project_id_psl = max_entry.project_id and log.manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl fiscal_id_psl,
                        project_id_psl fiscal_project_id_psl,
                        log_detail_psl fiscal_log_detail_psl,
                        manual_entry_date_psl fiscal_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr,' ',lastname_usr)) fiscal_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) fiscal_responsible_id
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 8
                    GROUP BY id_psl
                ) log_fiscal on log_fiscal.fiscal_project_id_psl = max_entry.project_id and log_fiscal.fiscal_manual_entry_date_psl = max_entry.max_date
                LEFT JOIN (
                    SELECT
                        id_psl builder_id_psl,
                        project_id_psl builder_project_id_psl,
                        log_detail_psl builder_log_detail_psl,
                        manual_entry_date_psl builder_manual_entry_date_psl,
                        GROUP_CONCAT(DISTINCT CONCAT(firstname_usr,' ',lastname_usr)) builder_responsible,
                        GROUP_CONCAT(DISTINCT id_usr) builder_responsible_ids
                    FROM
                        wfl_project_status_log
                    LEFT JOIN wfl_status_log_responsibles on status_log_id_slr = id_psl
                    LEFT JOIN wfl_status_responsibles on id_sre = responsible_id_slr
                    LEFT JOIN sec_users on id_usr = user_id_sre
                    LEFT JOIN sec_userroles on userid_uro = user_id_sre
                    where deleted_psl != 1  and deleted_slr != 1 and roleid_uro = 9
                    GROUP BY id_psl
                ) log_builder on log_builder.builder_project_id_psl = max_entry.project_id and log_builder.builder_manual_entry_date_psl = max_entry.max_date
            ) as status_log_manual_entry_date on status_log_manual_entry_date.project_id_psl = id_pro

            LEFT JOIN wfl_project_status on status_pro = id_pst
            LEFT JOIN (
                select inc.*
                from (
                   select
                        project_id_inc,
                        max(manual_entry_date_inc) manual_entry_date_inc
                        from wfl_incidents
                        where status_id_inc in (29) -- in_progress
                        GROUP BY project_id_inc
                ) as filtered inner join wfl_incidents as inc on inc.project_id_inc = filtered.project_id_inc and inc.manual_entry_date_inc = filtered.manual_entry_date_inc
            ) wfl_incidents on project_id_inc = id_pro
            LEFT JOIN wfl_warehouses on project_id_war = id_pro and deleted_war != 1
            LEFT JOIN (
                SELECT
                    id_pro project_id,
                    wfl_project_budgets.manpower_file_id_prb manpower_file_id   
                FROM
                    wfl_project_budgets
                LEFT JOIN wfl_project_status_log on id_psl = status_log_id_prb
                left join wfl_projects on id_pro = project_id_psl
                WHERE 
                    deleted_prb != 1
                and deleted_pro != 1
                and deleted_psl != 1
                and manpower_file_id_prb is not null
            ) manpower on manpower.project_id = id_pro
            WHERE
                deleted_pro != 1
                ".static::_additionalParameters($additionalParameters)."
        ) projects
        where
            1 = 1
            ".$like."
        ;
        ";

        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        return $totalCount;
    }

    private static function _dataTableColumns()
    {
        $columns = static::TABLE_NAME.".*,
                        status_name_pst,
                        keyword_pst,
                        IFNULL(percentage_inc,0) percentage_inc,
                        detail_inc,
                        order_pst,
                        status_log_manual_entry_date.manual_entry_date_psl,
                        status_log_manual_entry_date.responsible,
                        status_log_manual_entry_date.responsible_ids,
                        status_log_manual_entry_date.fiscal_responsible,
                        status_log_manual_entry_date.fiscal_responsible_id,
                        status_log_manual_entry_date.builder_responsible,
                        status_log_manual_entry_date.builder_responsible_ids,
                        manpower.manpower_file_id,
                        id_psl,
                        id_war
        ";
        return $columns;
    }

    private static function _additionalParameters($list = array())
    {
        $ci=&get_instance();
        $ci->load->database();
        // echo"<pre>";var_dump($list);exit;
        $sql = "";
        // echo"<pre>";var_dump($list,'df');exit;
        if(is_array($list) && count($list) >= 1)
        {
            foreach($list as $parameter => $value)
            {
                switch ($parameter)
                {
                    //For this parameter the ids are separated by comma
                    case "status":
                        $statusList = explode(",",$value);
                        $statusScape = "";
                        foreach ($statusList as $status)
                        {
                            $statusScape .= $ci->db->escape($status).", ";
                            $includeFilter = TRUE;
                        }
                        $statusScape = substr($statusScape,0,-2);
                        $sql .= " and status_pro in ( ".$statusScape." )";
                    break;
                    case "responsible-id":
                        if($value != "")
                            $sql .= " and responsible_ids like '%".$value."%'";
                    break;
                    case "work-area":
                        $sql .= " and work_area_pro = ".$ci->db->escape($value)." ";
                    break;
                    case "fiscal-responsible-id":
                        if($value != "")
                            $sql .= " and fiscal_responsible_id = ".$ci->db->escape($value)." ";
                    break;
                    case "builder-responsible-id":
                        if($value != "")
                            $sql .= " and builder_responsible_ids like '%".$value."%'";
                    break;
                    case "manpower-uploaded":
                        if($value == 1)
                            $sql .= " and manpower_file_id is not null ";
                        else if($value == 0)
                            $sql .= " and manpower_file_id is null ";
                        else
                            $sql .= " ";
                    break;
                    case "has-location":
                        if($value == 1)
                            $sql .= " and latitude_pro is not null and latitude_pro != '' ";
                        else if($value == 0)
                            $sql .= " and latitude_pro is null or latitude_pro = '' ";
                        else
                            $sql .= " ";
                    break;
                }
            }
        }
        return $sql;
    }

    private static function _statusDetailQuery($statusId)
    {
        $ci = &get_instance();
        $ci->load->database();
        $sql = "
        select 
            id_psl,
            project_id_psl,
            status_id_psl,  
            filter.entry_date,
            GROUP_CONCAT(CONCAT(builder.builder_id)) builder_responsible_id,
            GROUP_CONCAT(CONCAT(builder.builder_firstname,' ',builder.builder_lastname)) builder_responsible,
            GROUP_CONCAT(CONCAT(fiscal.fiscal_id)) fiscal_responsible_id,
            GROUP_CONCAT(CONCAT(fiscal.fiscal_firstname,' ',fiscal.fiscal_lastname)) fiscal_responsible
        from 
            wfl_project_status_log
        RIGHT JOIN(
            SELECT          
                project_id_psl project_id,
                max(manual_entry_date_psl) entry_date
            FROM
                wfl_project_status_log
            WHERE       
            status_id_psl = ".$ci->db->query($statusId)."
            and deleted_psl != 1
            GROUP BY project_id_psl
        ) as filter on filter.entry_date = manual_entry_date_psl and filter.project_id = project_id_psl
        LEFT JOIN wfl_projects on id_pro = project_id_psl
        LEFT JOIN wfl_status_log_responsibles on wfl_status_log_responsibles.status_log_id_slr = id_psl
        LEFT JOIN wfl_status_responsibles on responsible_id_slr = id_sre        
        LEFT JOIN sec_users responsible on user_id_sre = responsible.id_usr
        LEFT JOIN (
                SELECT
                    id_usr builder_id,
                    firstname_usr builder_firstname,
                    lastname_usr builder_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 9
                and deleted_uro != 1
            ) as builder on builder.builder_id = user_id_sre
        LEFT JOIN (
                SELECT
                    id_usr fiscal_id,
                    firstname_usr fiscal_firstname,
                    lastname_usr fiscal_lastname
                FROM
                    sec_users
                right JOIN sec_userroles on userid_uro = id_usr
                where 
                    roleid_uro = 8
                and deleted_uro != 1
            ) as fiscal on fiscal.fiscal_id = user_id_sre
        where deleted_pro != 1 and deleted_slr != 1 -- and id_pro = 871
        GROUP BY id_psl
        ";
        return $sql;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS

    ################################################################################################# BEGIN - DATATABLE AJAX METHODS

    /**
     * @param string $statusId
     * @return mixed
     */
    public static function countAll_deprecated($statusId = "", $userId = "")
    {
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_count_all('.$ci->db->escape($statusId).','.$ci->db->escape($userId).')';
        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        $ci->db->close();
        return $totalCount;
    }

    /**
     * @param string $statusId
     * @param string $userId
     * @param $limit
     * @param $offset
     * @param null $orderBy
     * @param string $orderType
     * @return mixed
     */
    public static function getAllProjects_deprecated($statusId = "", $userId = "", $limit, $offset, $orderBy = null, $orderType = 'asc')
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_get_all('.$ci->db->escape($statusId).','.$ci->db->escape($userId).','.$limit.','.$offset.','.$ci->db->escape($orderBy).', '.$ci->db->escape($orderType).')';
        $query = $ci->db->query($sql);
        $result = $query->result();
        $ci->db->close();
        return $result;
    }

    /**
     * @param string $statusId
     * @param string $userId
     * @param $text
     * @param $limit
     * @param $offset
     * @param null $orderBy
     * @param string $orderType
     * @param null $colsArray
     * @return mixed
     */
    public static function searchProject_deprecated($statusId = "", $userId = "", $text, $limit, $offset, $orderBy = null, $orderType = 'asc', $colsArray = null)
    {
        if ($orderBy === null)
        {
            $orderBy = static::TABLE_ID;
        }
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_search('.$ci->db->escape($statusId).','.$ci->db->escape($userId).','.$limit.','.$offset.','.$ci->db->escape($orderBy).', '.$ci->db->escape($orderType).','.$ci->db->escape($text).')';
        $query = $ci->db->query($sql);
        $result = $query->result();
        $ci->db->close();
        return $result;
    }

    /**
     * @param string $statusId
     * @param string $userId
     * @param string $text
     * @param null $colsArray
     * @return mixed
     */
    public static function searchTotalCount_deprecated($statusId = "", $userId = "", $text = "", $colsArray = null)
    {
        $ci = &get_instance();
        $ci->load->database();

        //check definition on Model_project_sp.txt
        $sql = 'CALL project_search_total_count('.$ci->db->escape($statusId).','.$ci->db->escape($userId).','.$ci->db->escape($text).')';
        $query = $ci->db->query($sql);
        $totalCount = $query->row()->total;
        $ci->db->close();
        return $totalCount;
    }
    ################################################################################################# END - DATATABLE AJAX METHODS
}
