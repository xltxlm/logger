<?php
namespace xltxlm\logger\thelostlog_exec\thelostlog_exec;

use \xltxlm\logger\Log\Destruct_Log;

/**
 * :类;
 * 命令行执行的日志;
*/
abstract class thelostlog_exec_implements
{
    use Destruct_Log;

    /* @var int  统计执行的次数 */
    public static $log_times = 0;
    
    /**
    * @return int;
    */
    public function getlog_times():int
    {
        return static::$log_times;
    }

    /**
    * @param int $log_times;
    * @return $this
    */
    public function setlog_times(int $log_times  = 0)
    {
        static::$log_times = $log_times;
        return $this;
    }

    /* @var string  执行的命令 */
    protected $command = '';

    /**
    * @return string;
    */
    public function getcommand():string
    {
        return $this->command;
    }

    /**
    * @param string $command;
    * @return $this
    */
    public function setcommand(string $command  = "")
    {
        $this->command = $command;
        return $this;
    }

    /* @var string  执行的结果 */
    protected $result = '';

    /**
    * @return string;
    */
    public function getresult():string
    {
        return $this->result;
    }

    /**
    * @param string $result;
    * @return $this
    */
    public function setresult(string $result  = "")
    {
        $this->result = $result;
        return $this;
    }

    /* @var string  返回的错误信息 */
    protected $error = '';

    /**
    * @return string;
    */
    public function geterror():string
    {
        return $this->error;
    }

    /**
    * @param string $error;
    * @return $this
    */
    public function seterror(string $error  = "")
    {
        $this->error = $error;
        return $this;
    }
}
