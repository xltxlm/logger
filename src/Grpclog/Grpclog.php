<?php

namespace xltxlm\logger\Grpclog;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Log\Destruct_Log;
use xltxlm\statistics\Config\Kkreview\LoggrpcModel;

/**
 * 记录远程请求的日志;
 */
class Grpclog extends Grpclog\Grpclog_implements
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

            $time = date('Y-m-d H:i:s');
            $GrpclogModel = (new LoggrpcModel)
                ->setId($id)
                ->setPosixid($posixid)
                ->setPosix_log_num($log_num)
                ->setLogid((string)$_SERVER['logid'])
                ->setProject_name((string)$_SERVER['projectname'])
                ->setrundocker((string)$_SERVER['dockername'])
                ->setusername((string)$_COOKIE['username'])
                ->setusernameip((string)$_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'])
                ->setuse_time(sprintf('%.4f', microtime(true) - $this->timestamp_start))
                ->setAdd_time($time);

            $GrpclogModel
                ->setmodel_name($this->getmodel_name())
                ->setKeyid($this->getKeyid())
                ->setLogtype($this->getLogtype())
                ->setip($this->getip())
                ->setport($this->getport())
                ->setreturn_data((string)$this->getreturn_data())
                ->setrequest_data($this->getrequest_data())
                ->seterror($this->geterror());

            $logfile = "/opt/logs/" . date('Ymd/') . ((new \ReflectionClass($this))->getShortName()) . date('.YmdHi') . ".log";
            error_log($GrpclogModel->__toString() . "\n", 3, $logfile);

            Destruct_Log::$log_cout['grpc']++;
            //错误日志+1
            if ($this->geterror()) {
                Destruct_Log::$log_cout['error']++;
            }
            $this->sethaveloged(true);
        } catch (\Exception $e) {
            p([$e->getMessage(), $e->getFile(), $e->getLine()]);
        }
    }

}
