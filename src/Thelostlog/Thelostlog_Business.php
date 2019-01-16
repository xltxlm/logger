<?php

namespace xltxlm\logger\Thelostlog;

use xltxlm\logger\Log\DefineLog;
use \xltxlm\logger\Thelostlog\TraitClass;
use xltxlm\resources\Resources\Define;
use xltxlm\snownum\Config\RedisCacheConfig;

/**
 * 记录业务的逻辑意义;
 */
class Thelostlog_Business extends Thelostlog_Business\Thelostlog_Business_implements
{
    public function __construct(string $message = "")
    {
        if ($message) {
            $this->setFunction_name($message);
        }
        $this->setresources_type('逻辑');
        parent::__construct();
    }

    public function __invoke()
    {
        Thelostlog_Business::$log_times++;
        parent::__invoke();
        //判断是否真正需要写日志
        $不需要写入日志 = DefineLog::$writelog == false;
        if ($不需要写入日志) {
            return null;
        }


        $data = sprintf('{ "update":  { "_index": "thelostlog_thread", "_type": "data","_id":"%s"}}' . "\n", (string)$_SERVER['logid']) . '{"doc":{"logic":"' . (string)Thelostlog_Business::$log_times . '"}}' . "\n";

        (new RedisCacheConfig())
            ->__invoke()
            ->lPush('log_list', $data);
    }


}
