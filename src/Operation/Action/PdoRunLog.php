<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 6:42.
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\Connect\PdoConnectLog;
use xltxlm\orm\Sql\SqlParserd;

class PdoRunLog extends PdoConnectLog
{
    /** @var  sqlParserd */
    protected $pdoSql;

    /**
     * PdoRunLog constructor.
     */
    public function __construct($pdoConfig = null)
    {
        $this->setAction(DefineLog::ZHEN_CHANG);
        parent::__construct($pdoConfig);
    }


    /**
     * @return SqlParserd
     */
    public function getPdoSql(): SqlParserd
    {
        return $this->pdoSql;
    }

    /**
     * @param SqlParserd $pdoSql
     * @return PdoRunLog
     */
    public function setPdoSql(SqlParserd $pdoSql): PdoRunLog
    {
        $this->pdoSql = $pdoSql;
        return $this;
    }
}
