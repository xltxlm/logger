<?php
namespace xltxlm\logger\Resource_define\Resource_define_TraitClass;

use \xltxlm\logger\Log\Destruct_Log;

/**
 * :Trait;
 * 资源链接日志;
*/
trait Resource_define_TraitClass_implements
{
    use Destruct_Log;

    /* @var string  链接地址 */
    protected $tns = '';

    /**
    * @return string;
    */
    public function gettns():string
    {
        return $this->tns;
    }

    /**
    * @param string $tns;
    * @return $this
    */
    public function settns(string $tns  = "")
    {
        $this->tns = $tns;
        return $this;
    }

    /* @var string  账户 */
    protected $user = '';

    /**
    * @return string;
    */
    public function getuser():string
    {
        return $this->user;
    }

    /**
    * @param string $user;
    * @return $this
    */
    public function setuser(string $user  = "")
    {
        $this->user = $user;
        return $this;
    }

    /* @var string  端口 */
    protected $port = '';

    /**
    * @return string;
    */
    public function getport():string
    {
        return $this->port;
    }

    /**
    * @param string $port;
    * @return $this
    */
    public function setport(string $port  = "")
    {
        $this->port = $port;
        return $this;
    }

    /* @var string  资源类型,设置类型的时候,递增记录资源的链接次数 */
    protected $resources_type = '数据库';

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
    abstract public function setresources_type(string $resources_type  = "数据库");

    /* @var int  记录资源的链接次数 */
    public static $connect_times = 0;
    
    /**
    * @return int;
    */
    public function getconnect_times():int
    {
        return static::$connect_times;
    }

    /**
    * @param int $connect_times;
    * @return $this
    */
    protected function setconnect_times(int $connect_times  = 0)
    {
        static::$connect_times = $connect_times;
        return $this;
    }

    /**
    *  生成json字符串,写入日志redis服务器;
    *  @return ;
    */
    abstract public function __invoke();
}
