<?php

namespace xltxlm\logger\Thelostlog;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Log\Destruct_Log;
use xltxlm\logger\Mysqllog\Mysqllog_TraitClass;
use xltxlm\statistics\Config\Kkreview\ThelostlogModel;

/**
 * 记录各种日志的基础逻辑;
 */
trait TraitClass
{
    use TraitClass\TraitClass_implements;

    public function __invoke()
    {
        //判断是否真正需要写日志
        $不需要写入日志 = DefineLog::$writelog == false;
        if ($不需要写入日志) {
            return null;
        }

        try {
            $posixid = posix_getpid();
            Destruct_Log::$posix_log_num[$posixid]++;
            $log_num = Destruct_Log::$posix_log_num[$posixid];
            $logid = \dk_get_next_id();
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
                ->setProject_name((string)$_SERVER['projectname'])
                ->setDockname((string)$_SERVER['dockername'])
                ->setLogid((string)$_SERVER['logid'])
                ->setAtcion_entrance($this->getAtcion_entrance())
                ->setResources_type($this->getresources_type())
                ->setExecution_time(sprintf('%.4f', microtime(true) - $this->timestamp_start))
                ->setFunction_name($function_name)
                ->setPosixid($posixid)
                ->setPosix_log_num($log_num)
                ->setUniqueid($uniqid)
                ->setUsername((string)$_COOKIE['username'])
                ->setAdd_time(date('Y-m-d H:i:s'));

            $thelostlogModel
                ->setMessage_type($this->getmessage_type());

            error_log($thelostlogModel->__toString() . "\n", 3, "/opt/logs/" . ((new \ReflectionClass($this))->getShortName()) . date('.Ymd') . ".log");
            if ($this->getmessage_type() == Mysqllog_TraitClass::MESSAGETYPE_ERROR) {
                Destruct_Log::$log_cout['error']++;
            }
            $this->sethaveloged(true);
        } catch (\Throwable $e) {
        }
    }

}
