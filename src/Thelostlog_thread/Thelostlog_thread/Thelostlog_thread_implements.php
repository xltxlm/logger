<?php
namespace xltxlm\logger\Thelostlog_thread\Thelostlog_thread;

use \xltxlm\logger\Log\Destruct_Log;

/**
 * :类;
 * 记录单独进程的执行;
*/
abstract class Thelostlog_thread_implements
{
    use Destruct_Log;

    /* @var string  最后一次错误信息 */
    protected $error_message = '';

    /**
    * @return string;
    */
    public function geterror_message():string
    {
        return $this->error_message;
    }

    /**
    * @param string $error_message;
    * @return $this
    */
    public function seterror_message(string $error_message  = "")
    {
        $this->error_message = $error_message;
        return $this;
    }

    /**
    *  ;
    *  @return ;
    */
    abstract protected function 重置日志次数统计();
}
