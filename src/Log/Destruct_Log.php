<?php

namespace xltxlm\logger\Log;

include_once __DIR__ . '/dk_get_dt_id.php';

/**
 * 在类注销的时候,写入日志;
 */
trait Destruct_Log
{
    use Destruct_Log\Destruct_Log_implements;

    public function __construct()
    {
        if ($_REQUEST['c']) {
            $this->setAtcion_entrance(strtr($_REQUEST['c'], ['/' => '@']));
        }
        $this->settimestamp_start(microtime(true));
    }

    /**
     * 如果是异常退出，保证记录下数据
     */
    public function __destruct()
    {
        if ($this->haveloged == false) {
            $this->__invoke();
        }
    }

}
