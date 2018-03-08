<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/12/27
 * Time: 11:11
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\Action\PdoRunLog;


/**
 * 从数据库取数据的耗时记录
 * Class PdoRead
 * @package xltxlm\allinone\vendor\xltxlm\logger\src\Operation\Action
 */
class PdoRead extends PdoRunLog
{

    /**
     * PdoRead constructor.
     */
    public function __construct($pdoConfig = null)
    {
        parent::__construct($pdoConfig);
        $this->setAction(DefineLog::DU_QU);
    }
}