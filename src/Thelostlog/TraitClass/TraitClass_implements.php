<?php
namespace xltxlm\logger\Thelostlog\TraitClass;

/**
 * :Trait;
 * 记录各种日志的基础逻辑;
*/
trait TraitClass_implements
{

/* @var array  记录相同进行下,当条日志是第几次 */
    protected static $posix_log_num = [];

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
    protected function setposix_log_num(array $posix_log_num  = [])
    {
        static::$posix_log_num = $posix_log_num;
        return $this;
    }

    /* @var string  类生成的时间戳=开始记录日志的时间戳 */
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

    /* @var string  程序执行的入口标志 */
    protected static $Atcion_entrance = '';

    /**
    * @return string;
    */
    public function getAtcion_entrance():string
    {
        return static::$Atcion_entrance;
    }

    /**
    * @param string $Atcion_entrance;
    * @return $this
    */
    public function setAtcion_entrance(string $Atcion_entrance  = "")
    {
        static::$Atcion_entrance = $Atcion_entrance;
        return $this;
    }

    /* @var string  所属的资源类型,db?redis? */
    protected $resources_type = '';

    /**
    * @return string;
    */
    public function getresources_type():string
    {
        return $this->resources_type;
    }

    /**
    * @param string $resources_type;
    * @return $this
    */
    public function setresources_type(string $resources_type  = "")
    {
        $this->resources_type = $resources_type;
        return $this;
    }

    /* @var string  所在函数/业务意义 */
    protected $Function_name = '';

    /**
    * @return string;
    */
    public function getFunction_name():string
    {
        return $this->Function_name;
    }

    /**
    * @param string $Function_name;
    * @return $this
    */
    public function setFunction_name(string $Function_name  = "")
    {
        $this->Function_name = $Function_name;
        return $this;
    }

    /* @var bool  析构的时候,如果还没记录日志,重新记录下 */
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

    /**
    *  生成json字符串,写入日志服务器上面;
    *  @return ;
    */
    abstract public function __invoke();
}
