<?php
class CodeGen
{
    private $_tableName;

	public function __construct($tableName)
	{
        $this->_tableName = $tableName;
	}

	function generateModelFiles()
	{
        $tableDefinition = My_Model::getTableDefinition($this->_tableName);   
        echo "<pre>";var_dump($tableDefinition);exit;
	}
}