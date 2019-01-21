<?php

namespace xltxlm\logger\thelostlog_exec;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Log\Destruct_Log;
use \xltxlm\logger\Resource_define\Resource_define_TraitClass;
use xltxlm\snownum\Config\RedisCacheConfig;
use xltxlm\statistics\Config\Kkreview\Thelostlog_execModel;

/**
 * 命令行执行的日志;
 */
class thelostlog_exec extends thelostlog_exec\thelostlog_exec_implements
{
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

            $thelostlog_execModel = new Thelostlog_execModel();
            $thelostlog_execModel
                ->setId($id)
                ->setProject_name((string)$_SERVER['projectname'])
                ->setDockername((string)$_SERVER['dockername'])
                ->setLogid((string)$_SERVER['logid'])
                ->setExecution_time(sprintf('%.4f', microtime(true) - $this->timestamp_start))
                ->setAtcion_entrance($this->getAtcion_entrance())
                ->setPosixid($posixid)
                ->setPosix_log_num($log_num)
                ->setUsername((string)$_COOKIE['username'])
                ->setAdd_time(date('Y-m-d H:i:s'));

            $thelostlog_execModel
                ->setCommand($this->getcommand())
                ->setResult($this->getresult())
                ->setError($this->geterror());

            $data = sprintf('{ "index":  { "_index": "thelostlog_exec", "_type": "data","_id":"%s"}}' . "\n", $id) . $thelostlog_execModel->__toString() . "\n";

            (new RedisCacheConfig())
                ->__invoke()
                ->lPush('log_list', $data);

            Destruct_Log::$log_cout['exec']++;
            //错误日志+1
            if ($this->geterror()) {
                Destruct_Log::$log_cout['error']++;
            }

            $this->sethaveloged(true);
        } catch (\Exception $e) {
            \xltxlm\helper\Util::d([$e->getMessage(), $e->getFile(), $e->getLine()]);
        }
    }

}
