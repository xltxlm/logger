<?php
namespace xltxlm\logger\Log\Destruct_Log;

/**
 * :Trait;
 * 在类注销的时候,写入日志;
*/
trait Destruct_Log_implements
{

/* @var string  开始记录日志的时间戳 */
    protected $timestamp_start = '';

    /**
    * @return string;
    */
    public function gettimestamp_start():string
    {
        return $this->timestamp_start;
    }

    /**
    * @param string $timestamp_start;
    * @return $this
    */
    public function settimestamp_start(string $timestamp_start  = "")
    {
        $this->timestamp_start = $timestamp_start;
        return $this;
    }

    /* @var bool  是否已经主动写入日志 */
    protected $haveloged = false;
    
    /**
    * @return bool;
    */
    public function gethaveloged():bool
    {
        return $this->haveloged;
    }

    public function ishaveloged():bool
    {
        return $this->gethaveloged();
    }
    
    /**
    * @param bool $haveloged;
    * @return $this
    */
    public function sethaveloged(bool $haveloged  = false)
    {
        $this->haveloged = $haveloged;
        return $this;
    }

    /* @var array  记录相同进行下,当条日志的时序 */
    public static $posix_log_num = [];

    /**
    * @return array;
    */
    public function getposix_log_num():array
    {
        return static::$posix_log_num;
    }

    /**
    * @param array $posix_log_num;
    * @return $this
    */
    public function setposix_log_num(array $posix_log_num  = [])
    {
        static::$posix_log_num = $posix_log_num;
        return $this;
    }

    /* @var string  程序执行的入口标志 */
    protected $Atcion_entrance = '';

    /**
    * @return string;
    */
    public function getAtcion_entrance():string
    {
        return $this->Atcion_entrance;
    }

    /**
    * @param string $Atcion_entrance;
    * @return $this
    */
    public function setAtcion_entrance(string $Atcion_entrance  = "")
    {
        $this->Atcion_entrance = $Atcion_entrance;
        return $this;
    }

    /**
    *  析构的时候,尝试写入日志;
    *  @return ;
    */
    abstract public function __destruct();
    /**
    *  手动调用写入日志的接口;
    *  @return ;
    */
    abstract public function __invoke();
    /**
    *  初始化入口标志和日志开始计时时间;
    *  @return ;
    */
    abstract public function __construct();
}
