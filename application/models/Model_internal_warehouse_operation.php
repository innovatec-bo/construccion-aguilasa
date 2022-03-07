<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 * Date: 2022-02-08
 * Time: 14:03:07
 */

class Model_internal_warehouse_operation extends Model_internal_warehouse_operation_base
{
    public function __construct($entryDate = "", $detail = "", $operationTypeId = "", $fiscalId = NULL, $builderId = NULL, $projectId = NULL)
    {
        parent::__construct($entryDate, $detail, $operationTypeId, $fiscalId, $builderId, $projectId);
    }

    public function operationType()
    {
        return Model_internal_warehouse_operation_type::getById($this->_operationTypeId);
    }

    public function project()
    {
        return Model_project::getById($this->_projectId);
    }

    public function fiscal()
    {
        return Model_user::getById($this->_fiscalId);
    }

    public function builder()
    {
        return Model_user::getById($this->_builderId);
    }
}