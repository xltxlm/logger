<?php

namespace xltxlm\logger\Thelostlog;

use xltxlm\logger\Log\DefineLog;
use xltxlm\snownum\Config\RedisCacheConfig;
use xltxlm\statistics\Config\Kkreview\ThelostlogModel;

/**
 * 记录各种日志的基础逻辑;
 */
trait TraitClass
{
    use TraitClass\TraitClass_implements;


    /**
     * TraitClass constructor.
     */
    public function __construct()
    {
        $this->timestamp_start = microtime(true);
        if ($_REQUEST['c']) {
            $this->setAtcion_entrance($_REQUEST['c']);
        }
    }

    public function __invoke()
    {
        //判断是否真正需要写日志
        $不需要写入日志 = DefineLog::$writelog == false;
        if ($不需要写入日志) {
            return null;
        }

        $posixid = posix_getpid();
        self::$posix_log_num[$posixid]++;
        $log_num = self::$posix_log_num[$posixid];
        $logid = $_SERVER['logid'] ?: \dk_get_dt_id();
        $uniqid = DefineLog::getUniqid_static();
        $id = $logid . $_SERVER['dockername'] . $uniqid . '@' . $log_num;

        $function_name = $this->getFunction_name();
        if ($function_name == '') {
            $debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            foreach ($debug_backtrace as $item) {
                if (strpos($item['class'], 'Thelostlog') === false) {
                    $function_name = $item['class'] . '::' . $item['function'];
                    break;
                }
            }
        }
        $thelostlogModel = (new ThelostlogModel());
        $thelostlogModel
            ->setId($id)
            ->setProject_name($_SERVER['projectname'])
            ->setDockname($_SERVER['dockername'])
            ->setAtcion_entrance($this->getAtcion_entrance())
            ->setResources_type($this->getresources_type())
            ->setExecution_time(sprintf('%.4f', microtime(true) - $this->timestamp_start))
            ->setFunction_name($function_name)
            ->setPosixid($posixid)
            ->setPosix_log_num($log_num)
            ->setUniqueid($uniqid)
            ->setAdd_time(date('Y-m-d H:i:s'));


        $data = sprintf('{ "index":  { "_index": "thelostlog", "_type": "data","_id":"%s"}}' . "\n", $id) . $thelostlogModel->__toString() . "\n";
        try {
            (new RedisCacheConfig())
                ->__invoke()
                ->lPush('log_list', $data);
            $this->sethaveloged(true);
        } catch (\Exception $e) {
            \xltxlm\helper\Util::d([$e->getMessage(), $e->getFile(), $e->getLine()]);
        }
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
