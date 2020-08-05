<?php
class CodeGenHandler
{
	private $_tableName;
	private $_tableId;
	private $_attribList;
	private $_constructorArguments;
	private $_parentConstructorArguments;
	private $_constructorAssignment;
	private $_toArrayList;
	private $_recastList;
	private $_setters;
	private $_getters;
	private $_attribSubfix;
	private $_genericAttribs;
	private $_modelName;

	public function __construct($tableName, $modelName)
	{
		$this->_tableName = $tableName;
		$this->_genericAttribs = array(
			'id' => 'id',
			'deleted' => 'deleted',
			'createdon' => 'createdOn',
			'createdby' => 'createdBy',
			'editedon' => 'editedOn',
			'editedby' => 'editedBy'
		);
		$this->_modelName = $modelName;
		$this->_setModelInfo();
	}

	public function generateModelFiles()
	{
		$modelBaseTemplate = FCPATH.'/application/models/templateModelBase.php';
		$modelBase = FCPATH.'/application/models/Model_'.$this->_modelName.'_base.php';
		$modelTemplate = FCPATH.'/application/models/templateModel.php';
		$model = FCPATH.'/application/models/Model_'.$this->_modelName.'.php';

		if (!copy($modelBaseTemplate, $modelBase))
		{
			echo "Error al copiar $modelBaseTemplate...\n";
		}
		else if (!copy($modelTemplate, $model))
		{
			echo "Error al copiar $modelTemplate...\n";
		}
		else
		{
			file_put_contents($modelBase,str_replace('{date}', date("Y-m-d"), file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{time}', date("H:i:s"), file_get_contents($modelBase)));
			file_put_contents($modelBase, str_replace('{model_name}', $this->_modelName, file_get_contents($modelBase)));
			file_put_contents($modelBase, str_replace('{table_name}', $this->_tableName, file_get_contents($modelBase)));
			file_put_contents($modelBase, str_replace('{table_id}', $this->_tableId, file_get_contents($modelBase)));
			file_put_contents($modelBase, str_replace('{table_sufix}', $this->_attribSubfix, file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{attrib_list}', $this->_attribList, file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{construct_arguments}', $this->_constructorArguments, file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{construct_assignment}', $this->_constructorAssignment, file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{to_array_list}', $this->_toArrayList, file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{recast_list}', $this->_recastList, file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{setters}', $this->_setters, file_get_contents($modelBase)));
			file_put_contents($modelBase,str_replace('{getters}', $this->_getters, file_get_contents($modelBase)));

			file_put_contents($model,str_replace('{date}', date("Y-m-d"), file_get_contents($model)));
			file_put_contents($model,str_replace('{time}', date("H:i:s"), file_get_contents($model)));
			file_put_contents($model,str_replace('{model_name}', $this->_modelName, file_get_contents($model)));
			file_put_contents($model,str_replace('{construct_arguments}', $this->_constructorArguments, file_get_contents($model)));
			file_put_contents($model,str_replace('{parent_construct_arguments}', $this->_parentConstructorArguments, file_get_contents($model)));
		}
	}

	private function _setModelInfo()
	{
		$tableDefinition = My_Model::getTableDefinition($this->_tableName);
		$i = 0;
		foreach ($tableDefinition as $row)
		{
			$field = substr($row['Field'], 0, -4);
			$attribSubfix = explode("_", $row['Field']);
			$attribSubfix = "_".end($attribSubfix);
			// echo "<pre>";var_dump($field, $this->_genericAttribs);exit;
			if($i == 0)
			{
				$this->_tableId = $row['Field'];
			}
			$this->_attribSubfix = explode("_", $row['Field']);
			$this->_attribSubfix = "_".end($this->_attribSubfix);
			$attribute = str_replace("_", " ", $field);
			$attribute = ucwords($attribute);
			$attribute = lcfirst($attribute);
			$attribute = str_replace(" ", "", $attribute);
			if(array_key_exists($field, $this->_genericAttribs) === FALSE)
			{
				//atribute list
				$this->_attribList .= "protected \$_".$attribute.";\n\t";
				//construct_arguments
				$this->_constructorArguments .= "\$".$attribute." = \"\", ";
				//parent_construct_arguments
				$this->_parentConstructorArguments .= "\$".$attribute.", ";
				//construct_assignment
				$this->_constructorAssignment .= "\$this->_".$attribute." = \$".$attribute.";\n\t\t";
				//recast_list
				$this->_recastList .= "\$object->".$row['Field'].",\n\t\t\t\t";
				//setters
				$this->_setters .= "public function set".ucwords($attribute)."(\$".$attribute.")\n\t{\n\t\t\$this->_".$attribute." = \$".$attribute.";\n\t}\n\n\t";
				// $this->_setters = trim($this->_setters);
				//getters
				$this->_getters .= "public function get".ucwords($attribute)."()\n\t{\n\t\treturn \$this->_".$attribute.";\n\t}\n\n\t";
			}
			//to_array_list
			$this->_toArrayList .= "\"".$row['Field']."\" => \$this->_".$this->_specialAttribs($attribute).",\n\t\t\t";
			$i++;
		}
		$this->_attribList = trim($this->_attribList);
		$this->_constructorArguments = substr($this->_constructorArguments, 0, -2);
		$this->_parentConstructorArguments = substr($this->_parentConstructorArguments, 0, -2);
		$this->_constructorAssignment = trim($this->_constructorAssignment);
		$this->_toArrayList = trim($this->_toArrayList);
		$this->_toArrayList = substr($this->_toArrayList, 0, -1);
		$this->_recastList = trim($this->_recastList);
		$this->_recastList = substr($this->_recastList, 0, -1);
		$this->_setters = trim($this->_setters);
		$this->_getters = trim($this->_getters);
		// echo "<pre>";var_dump($this->_attribList, $this->_attribSubfix);exit;
	}

	private function _specialAttribs($attribute)
	{
		$response = $attribute;
		if(isset($this->_genericAttribs[$attribute]))
		{
			$response = $this->_genericAttribs[$attribute];
		}
		return $response;
	}
}
