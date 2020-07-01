<?php

namespace xltxlm\logger\Resource_define;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Log\Destruct_Log;
use xltxlm\logger\LoggerTrack;
use xltxlm\statistics\Config\Kkreview\Thelostlog_resource_defineModel;

/**
 * 资源链接日志;
 */
trait Resource_define_TraitClass
{
    use Resource_define_TraitClass\Resource_define_TraitClass_implements;

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

            $thelostlogModel = (new Thelostlog_resource_defineModel());
            $use_time = sprintf('%.4f', microtime(true) - $this->timestamp_start);
            $thelostlogModel
                ->setId($id)
                ->setProject_name((string)$_SERVER['projectname'])
                ->setDockname((string)$_SERVER['dockername'])
                ->setLogid((string)$_SERVER['logid'])
                ->setResources_type($this->getresources_type())
                ->setExecution_time($use_time)
                ->setAtcion_entrance($this->getAtcion_entrance())
                ->setPosixid($posixid)
                ->setPosix_log_num($log_num)
                ->setUniqueid($uniqid)
                ->setUsername((string)$_COOKIE['username'])
                ->setAdd_time(date('Y-m-d H:i:s'));

            $thelostlogModel
                ->setTns((string)$this->gettns())
                ->setUser((string)$this->getuser())
                ->setPort((string)$this->getport());

            $class_shortName = (new \ReflectionClass($this))->getShortName();
            error_log($thelostlogModel->__toString() . "\n", 3, "/opt/logs/" . $class_shortName . date('.Ymd') . ".log");

            (new LoggerTrack())
                ->setresource_type($class_shortName)
                ->setuse_times($use_time)
                ->setContext($thelostlogModel->__toArray())
                ->__invoke();


            Destruct_Log::$log_cout['resource_connect']++;

            $this->sethaveloged(true);
        } catch (\Exception $e) {
            p([$e->getMessage(), $e->getFile(), $e->getLine(),$e->getTraceAsString()]);
        }
    }


}
