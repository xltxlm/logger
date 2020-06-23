<?php
namespace xltxlm\logger\LoggerTrack;

/**
 * :类;
 * 通用的日志结构外壳，具体业务的结构体存放在$context字段;
*/
abstract class LoggerTrack_implements
{


/* @var float  整个日志耗时：单位秒 */
    protected $use_times=0.0;





    /**
    * 整个日志耗时：单位秒;
    * @return float;
    */
            public function getuse_times():float        {
                return $this->use_times;
        }

    
    




/**
* @param float $use_times;
* @return $this
*/
    public function setuse_times(float $use_times )
    {
    $this->use_times = $use_times;
    return $this;
    }



/* @var string  写入日志的时间 */
    protected $add_time = '';





    /**
    * 写入日志的时间;
    * @return string;
    */
            public function getadd_time():string        {
                return $this->add_time;
        }

    
    




/**
* @param string $add_time;
* @return $this
*/
    public function setadd_time(string $add_time  = "")
    {
    $this->add_time = $add_time;
    return $this;
    }



/* @var string  开始记录的时间戳 */
    private $timestamp_start = '';





    /**
    * 开始记录的时间戳;
    * @return string;
    */
            protected function gettimestamp_start():string        {
                return $this->timestamp_start;
        }

    
    




/**
* @param string $timestamp_start;
* @return $this
*/
    protected function settimestamp_start(string $timestamp_start  = "")
    {
    $this->timestamp_start = $timestamp_start;
    return $this;
    }



/* @var string  写入日志的时间戳 */
    private $timestamp_end = '';





    /**
    * 写入日志的时间戳;
    * @return string;
    */
            protected function gettimestamp_end():string        {
                return $this->timestamp_end;
        }

    
    




/**
* @param string $timestamp_end;
* @return $this
*/
    protected function settimestamp_end(string $timestamp_end  = "")
    {
    $this->timestamp_end = $timestamp_end;
    return $this;
    }



/* @var string  日志已经写入完毕了，不需要再记录 */
    private $haveloged = '';





    /**
    * 日志已经写入完毕了，不需要再记录;
    * @return string;
    */
            protected function gethaveloged():string        {
                return $this->haveloged;
        }

    
    




/**
* @param string $haveloged;
* @return $this
*/
    protected function sethaveloged(string $haveloged  = "")
    {
    $this->haveloged = $haveloged;
    return $this;
    }



/* @var array  更加细节的资源相关请求内容。调用方自身的细节 */
    protected $context = [];





    /**
    * 更加细节的资源相关请求内容。调用方自身的细节;
    * @return array;
    */
            public function getcontext():array        {
                return $this->context;
        }

    
    




/**
* @param array $context;
* @return $this
*/
    abstract public function setcontext(array $context  = []);



/* @var string  外部资源类型 */
    protected $resource_type = '';





    /**
    * 外部资源类型;
    * @return string;
    */
            public function getresource_type():string        {
                return $this->resource_type;
        }

    
    




/**
* @param string $resource_type;
* @return $this
*/
    public function setresource_type(string $resource_type  = "")
    {
    $this->resource_type = $resource_type;
    return $this;
    }



/* @var string  日志id，可以用来追踪相同进程内的日志 */
    protected $logid = '';





    /**
    * 日志id，可以用来追踪相同进程内的日志;
    * @return string;
    */
            public function getlogid():string        {
                return $this->logid;
        }

    
    




/**
* @param string $logid;
* @return $this
*/
    public function setlogid(string $logid  = "")
    {
    $this->logid = $logid;
    return $this;
    }



/* @var int  日志编号 */
    protected $log_num = 0;
    




    /**
    * 日志编号;
    * @return int;
    */
            public function getlog_num():int        {
                return $this->log_num;
        }

    
    




/**
* @param int $log_num;
* @return $this
*/
    public function setlog_num(int $log_num  = 0)
    {
    $this->log_num = $log_num;
    return $this;
    }



/* @var array  执行的流程，已经排除了vendor目录 */
    protected $debug_backtrace = [];





    /**
    * 执行的流程，已经排除了vendor目录;
    * @return array;
    */
            public function getdebug_backtrace():array        {
                return $this->debug_backtrace;
        }

    
    




/**
* @param array $debug_backtrace;
* @return $this
*/
    public function setdebug_backtrace(array $debug_backtrace  = [])
    {
    $this->debug_backtrace = $debug_backtrace;
    return $this;
    }



/**
*  回调日志操作函数;
*  @return ;
*/
abstract public function __invoke();
/**
*  析构函数，确认__invoke函数有被调用到;
*  @return ;
*/
abstract public function __destruct();
/**
*  初始化基础条件;
*  @return ;
*/
abstract public function __construct();
}