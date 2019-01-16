<?php
namespace xltxlm\logger\Thelostlog\TraitClass;

use \xltxlm\logger\Log\Destruct_Log;

/**
 * :Trait;
 * 记录各种日志的基础逻辑;
*/
trait TraitClass_implements
{
    use Destruct_Log;

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

    /* @var int  日志记录的次数 */
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

    /**
    *  生成json字符串,写入日志服务器上面;
    *  @return ;
    */
    abstract public function __invoke();
}
