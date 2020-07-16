<?php
namespace xltxlm\logger\Writer\Nginx_Logger;

/**
 * :类;
 * 通用的日志记录，不再详细到每种分类，相关信息全部一个数组，需要的话，自己到日志服务端拆开;
*/
abstract class Nginx_Logger_implements
{


/* @var string  当前执行类的名字，用来识别是哪个页面发出的日志 */
    protected $entrance = '';





    /**
    * 当前执行类的名字，用来识别是哪个页面发出的日志;
    * @return string;
    */
            public function getentrance():string        {
                return $this->entrance;
        }

    
    




/**
* @param string $entrance;
* @return $this
*/
    public function setentrance(string $entrance  = "")
    {
    $this->entrance = $entrance;
    return $this;
    }



/* @var array  要记录的消息日志，数组格式 */
    protected $context = [];





    /**
    * 要记录的消息日志，数组格式;
    * @return array;
    */
            public function getcontext():array        {
                return $this->context;
        }

    
    




/**
* @param array $context;
* @return $this
*/
    public function setcontext(array $context  = [])
    {
    $this->context = $context;
    return $this;
    }



/* @var string  记录日志的远程网址 */
    protected $loggerhost = '';





    /**
    * 记录日志的远程网址;
    * @return string;
    */
            public function getloggerhost():string        {
                return $this->loggerhost;
        }

    
    




/**
* @param string $loggerhost;
* @return $this
*/
    public function setloggerhost(string $loggerhost  = "")
    {
    $this->loggerhost = $loggerhost;
    return $this;
    }



/* @var float  耗时多少作为慢日志 */
    protected $slowtimeout=0.4;





    /**
    * 耗时多少作为慢日志;
    * @return float;
    */
            public function getslowtimeout():float        {
                return $this->slowtimeout;
        }

    
    




/**
* @param float $slowtimeout;
* @return $this
*/
    public function setslowtimeout(float $slowtimeout )
    {
    $this->slowtimeout = $slowtimeout;
    return $this;
    }



/**
*  提交日志，如果接口失败，那么写本地磁盘，再有定时任务扔过去;
*  @return ;
*/
abstract public function __invoke();
}