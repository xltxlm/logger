<?php

namespace xltxlm\logger\Resource_define;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Log\Destruct_Log;
use xltxlm\snownum\Config\RedisCacheConfig;
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
            $thelostlogModel
                ->setId($id)
                ->setProject_name((string)$_SERVER['projectname'])
                ->setDockname((string)$_SERVER['dockername'])
                ->setLogid((string)$_SERVER['logid'])
                ->setResources_type($this->getresources_type())
                ->setExecution_time(sprintf('%.4f', microtime(true) - $this->timestamp_start))
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


            $data = sprintf('{ "index":  { "_index": "thelostlog_resource_define", "_type": "data","_id":"%s"}}' . "\n", $id) . $thelostlogModel->__toString() . "\n";

            (new RedisCacheConfig())
                ->__invoke()
                ->lPush('log_list', $data);
            $this->sethaveloged(true);
        } catch (\Exception $e) {
            \xltxlm\helper\Util::d([$e->getMessage(), $e->getFile(), $e->getLine()]);
        }
    }


}
