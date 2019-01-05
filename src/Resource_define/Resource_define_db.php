<?php

namespace xltxlm\logger\Resource_define;

use \xltxlm\logger\Resource_define\Resource_define_TraitClass;
use xltxlm\resources\Resources\Define;

/**
 * 资源链接日志:DB;
 */
class Resource_define_db extends Resource_define_db\Resource_define_db_implements
{
    public function __construct()
    {
        $this->setresources_type(Define::SHU_JU_KU);
        parent::__construct();
    }

}
