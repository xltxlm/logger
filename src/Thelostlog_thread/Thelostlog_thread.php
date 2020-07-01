<?php

namespace xltxlm\logger\Thelostlog_thread;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Log\Destruct_Log;
use xltxlm\logger\LoggerTrack;
use xltxlm\statistics\Config\Kkreview\Thelostlog_threadModel;

/**
 * 记录单独进程的执行;
 */
class Thelostlog_thread extends Thelostlog_thread\Thelostlog_thread_implements
{
    public function __invoke()
    {
        //判断是否真正需要写日志
        $不需要写入日志 = DefineLog::$writelog == false || empty($_SERVER['logid']);
        if ($不需要写入日志) {
            return null;
        }

        try {
            $posixid = posix_getpid();
            Thelostlog_thread::$posix_log_num[$posixid]++;
            $log_num = Thelostlog_thread::$posix_log_num[$posixid];
            $id = $_SERVER['logid'];

            $use_time = sprintf('%.4f', microtime(true) - $this->timestamp_start);
            $Thelostlog_threadModel = (new Thelostlog_threadModel())
                ->setId($id)
                ->setProject_name((string)$_SERVER['projectname'])
                ->setDockname((string)$_SERVER['dockername'])
                ->setLogid((string)$_SERVER['logid'])
                ->setAtcion_entrance($this->getAtcion_entrance())
                ->setExecution_time($use_time)
                ->setPosixid($posixid)
                ->setPosix_log_num($log_num)
                ->setUsername((string)$_COOKIE['username'])
                ->setAdd_time(date('Y-m-d H:i:s'));

            $Thelostlog_threadModel
                ->setResource_connect(Destruct_Log::$log_cout['resource_connect'])
                ->setMysqllog(Destruct_Log::$log_cout['mysqllog'])
                ->setRedis(Destruct_Log::$log_cout['redis'])
                ->setLogic(Destruct_Log::$log_cout['logic'])
                ->setGrpc(Destruct_Log::$log_cout['grpc'])
                ->setExec(Destruct_Log::$log_cout['exec'])
                ->setError_message($this->geterror_message())
                ->setError_count(Destruct_Log::$log_cout['error']);

            //1:写入进程的总日志.
            $class_shortName = (new \ReflectionClass($this))->getShortName();
            error_log($Thelostlog_threadModel->__toString() . "\n", 3, "/opt/logs/" . date('Ymd/') . $class_shortName . date('.YmdHi') . ".log");

            (new LoggerTrack())
                ->setresource_type($class_shortName)
                ->setuse_times($use_time)
                ->setContext($Thelostlog_threadModel->__toArray())
                ->__invoke();

//            //2:开始逐条计算各个类型日志的条数
//            if ($_SERVER['logid']) {
//                //a:资源链接
//                $data = sprintf('{ "update":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", (string)$_SERVER['logid']) . '{"doc":{"resource_connect":"' . Destruct_Log::$log_cout['resource_connect'] . '","fromlog":"resource_connect"}}' . "\n";
//
//                (new RedisCacheConfig())
//                    ->__invoke()
//                    ->lPush('log_list', $data);
//                //b:mysql
//                $data = sprintf('{ "update":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", (string)$_SERVER['logid']) . '{"doc":{"mysqllog":"' . Destruct_Log::$log_cout['mysqllog'] . '","fromlog":"mysqllog"}}' . "\n";
//
//                (new RedisCacheConfig())
//                    ->__invoke()
//                    ->lPush('log_list', $data);
//                //c:逻辑
//                $data = sprintf('{ "update":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", (string)$_SERVER['logid']) . '{"doc":{"logic":"' . Destruct_Log::$log_cout['logic'] . '","fromlog":"logic"}}' . "\n";
//
//                (new RedisCacheConfig())
//                    ->__invoke()
//                    ->lPush('log_list', $data);
//                //c:接口
//                $data = sprintf('{ "update":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", (string)$_SERVER['logid']) . '{"doc":{"grpc":"' . Destruct_Log::$log_cout['grpc'] . '","fromlog":"grpc"}}' . "\n";
//
//                (new RedisCacheConfig())
//                    ->__invoke()
//                    ->lPush('log_list', $data);
//                //d:系统命令
//                $data = sprintf('{ "update":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", (string)$_SERVER['logid']) . '{"doc":{"exec":"' . Destruct_Log::$log_cout['exec'] . '","fromlog":"exec"}}' . "\n";
//
//                (new RedisCacheConfig())
//                    ->__invoke()
//                    ->lPush('log_list', $data);
//                //e:redis
//                $data = sprintf('{ "update":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", (string)$_SERVER['logid']) . '{"doc":{"redis":"' . Destruct_Log::$log_cout['redis'] . '","fromlog":"redis"}}' . "\n";
//
//                (new RedisCacheConfig())
//                    ->__invoke()
//                    ->lPush('log_list', $data);
//            }

            $this->重置日志次数统计();
            $this->sethaveloged(true);
        } catch (\Exception $e) {
        }
    }

    protected function 重置日志次数统计()
    {
        Destruct_Log::$log_cout = [];
    }


}
