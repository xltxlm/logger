<?php

namespace xltxlm\logger\Mysqllog;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Log\Destruct_Log;
use xltxlm\statistics\Config\Kkreview\LogmysqlModel;

/** @var \xltxlm\logger\Mysqllog\Mysqllog_TraitClass $this */

/**
 * DB日志记录;
 */
class Mysqllog_TraitClass extends Mysqllog_TraitClass\Mysqllog_TraitClass_implements
{
    public function __invoke()
    {
        //判断是否真正需要写日志
        $不需要写入日志 = DefineLog::$writelog == false || $this->getWritefilelog() == false;
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

            $MysqllogModel = (new LogmysqlModel());
            $MysqllogModel
                ->setId($id)
                ->setProject_name((string)$_SERVER['projectname'])
                ->setDockername((string)$_SERVER['dockername'])
                ->setLogid((string)$_SERVER['logid'])
                ->setRunTime(sprintf('%.4f', microtime(true) - $this->timestamp_start))
                ->setCallClass($this->getAtcion_entrance())
                ->setPosix_getpid($posixid)
                ->setLogi($log_num)
                ->setUniqid($uniqid)
                ->setUsername((string)$_COOKIE['username'])
                ->setAdd_time(date('Y-m-d H:i:s'));

            $MysqllogModel
                ->setTns((string)$this->gettns())
                ->setTable_name((string)$this->gettable_name())
                ->setPdoSql((string)$this->getpdoSql())
                ->setSqlbinds((string)$this->getsqlbinds())
                ->setThread_id((string)$this->getthread_id())
                ->setSqlaction((string)$this->getsqlaction())
                ->setFetchnum((string)$this->getfetchnum())
                //错误类型
                ->setMessagetype((string)$this->getmessagetype())
                ->setException($this->getexception())
                ->setTrace((string)(new \Exception())->getTraceAsString());
            error_log($MysqllogModel->__toString() . "\n", 3, "/opt/logs/".date('Ymd/') . ((new \ReflectionClass($this))->getShortName()) . date('.YmdHi') . ".log");
            //SQL执行次数+1
            Destruct_Log::$log_cout['mysqllog']++;
            //错误日志+1
            if ($this->getmessagetype() == Mysqllog_TraitClass::MESSAGETYPE_ERROR) {
                Destruct_Log::$log_cout['error']++;
            }
            $this->sethaveloged(true);
        } catch (\Exception $e) {
            \xltxlm\helper\Util::d([$e->getMessage(), $e->getFile(), $e->getLine()]);
        }
    }


}
