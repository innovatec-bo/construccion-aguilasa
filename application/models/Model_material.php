<?php
/**
 * Created by CodeGenHandler.
 * User: Jair
 */

class Model_material extends Model_material_base
{
    public function __construct($code = "", $name = "", $description = "")
    {
        parent::__construct($code, $name, $description);
    }
}
