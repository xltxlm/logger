<?php

namespace xltxlm\logger\Thelostlog_thread;

use xltxlm\logger\Log\DefineLog;
use xltxlm\snownum\Config\RedisCacheConfig;
use xltxlm\statistics\Config\Kkreview\Thelostlog_threadModel;

/**
 * 记录单独进程的执行;
 */
class Thelostlog_thread extends Thelostlog_thread\Thelostlog_thread_implements
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
            Thelostlog_thread::$posix_log_num[$posixid]++;
            $log_num = Thelostlog_thread::$posix_log_num[$posixid];
            $id = $_SERVER['logid'];

            $Thelostlog_threadModel = (new Thelostlog_threadModel())
                ->setId($id)
                ->setProject_name((string)$_SERVER['projectname'])
                ->setDockname((string)$_SERVER['dockername'])
                ->setLogid((string)$_SERVER['logid'])
                ->setAtcion_entrance($this->getAtcion_entrance())
                ->setExecution_time(sprintf('%.4f', microtime(true) - $this->timestamp_start))
                ->setPosixid($posixid)
                ->setPosix_log_num($log_num)
                ->setUsername((string)$_COOKIE['username'])
                ->setAdd_time(date('Y-m-d H:i:s'));

            $data = sprintf('{ "index":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", $id) . $Thelostlog_threadModel->__toString() . "\n";
            (new RedisCacheConfig())
                ->__invoke()
                ->lPush('log_list', $data);
            $this->sethaveloged(true);
        } catch (\Exception $e) {
            \xltxlm\helper\Util::d([$e->getMessage(), $e->getFile(), $e->getLine()]);
        }
    }

}
