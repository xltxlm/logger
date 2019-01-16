<?php
namespace xltxlm\logger\Grpclog\Grpclog;

use \xltxlm\logger\Log\Destruct_Log;

/**
 * :类;
 * 记录远程请求的日志;
*/
abstract class Grpclog_implements
{
    use Destruct_Log;

    /* @var string  模块名称 */
    protected $model_name = '';

    /**
    * @return string;
    */
    public function getmodel_name():string
    {
        return $this->model_name;
    }

    /**
    * @param string $model_name;
    * @return $this
    */
    public function setmodel_name(string $model_name  = "")
    {
        $this->model_name = $model_name;
        return $this;
    }

    /* @var string  主键id */
    protected $Keyid = '';

    /**
    * @return string;
    */
    public function getKeyid():string
    {
        return $this->Keyid;
    }

    /**
    * @param string $Keyid;
    * @return $this
    */
    public function setKeyid(string $Keyid  = "")
    {
        $this->Keyid = $Keyid;
        return $this;
    }

    /* @var string  目标地址ip/地址 */
    protected $ip = '';

    /**
    * @return string;
    */
    public function getip():string
    {
        return $this->ip;
    }

    /**
    * @param string $ip;
    * @return $this
    */
    public function setip(string $ip  = "")
    {
        $this->ip = $ip;
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

    /* @var string  接口返回的数据 */
    protected $return_data = '';

    /**
    * @return string;
    */
    public function getreturn_data():string
    {
        return $this->return_data;
    }

    /**
    * @param string $return_data;
    * @return $this
    */
    public function setreturn_data(string $return_data  = "")
    {
        $this->return_data = $return_data;
        return $this;
    }

    /* @var string  请求的数据 */
    protected $request_data = '';

    /**
    * @return string;
    */
    public function getrequest_data():string
    {
        return $this->request_data;
    }

    /**
    * @param string $request_data;
    * @return $this
    */
    public function setrequest_data(string $request_data  = "")
    {
        $this->request_data = $request_data;
        return $this;
    }

    /* @var string  接口错误的理由 */
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

    /* @var string  请求的反向类型.客户端还是服务端 */
    protected $Logtype = '';

    /**
    * @return string;
    */
    public function getLogtype():string
    {
        return $this->Logtype;
    }

    /**
    * @param string $Logtype;
    * @return $this
    */
    public function setLogtype(string $Logtype  = "")
    {
        $this->Logtype = $Logtype;
        return $this;
    }

    /* @var int  执行次数 */
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
    protected function setlog_times(int $log_times  = 0)
    {
        static::$log_times = $log_times;
        return $this;
    }
}
