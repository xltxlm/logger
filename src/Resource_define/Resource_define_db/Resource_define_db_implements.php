<?php
namespace xltxlm\logger\Resource_define\Resource_define_db;

use \xltxlm\logger\Resource_define\Resource_define_TraitClass;

/**
 * :类;
 * 资源链接日志:DB;
*/
abstract class Resource_define_db_implements
{
    use Resource_define_TraitClass;

    /* @var string  资源类型 */
    protected $resources_type = '';

    /**
    * @return string;
    */
    public function getresources_type():string
    {
        return $this->resources_type;
    }

    /**
    * @param string $resources_type;
    * @return $this
    */
    public function setresources_type(string $resources_type  = "")
    {
        $this->resources_type = $resources_type;
        return $this;
    }
}
