<?php
namespace xltxlm\logger\Mysqllog\Mysqllog_TraitClass;

use \xltxlm\logger\Log\Destruct_Log;

/**
 * :类;
 * DB日志记录;
*/
abstract class Mysqllog_TraitClass_implements
{
    /*  */
    public const MESSAGETYPE_INFO="info";
    /*  */
    public const MESSAGETYPE_ERROR="error";

    use Destruct_Log;

    /* @var string  操作的表格名称 */
    protected $table_name = '';

    /**
    * @return string;
    */
    public function gettable_name():string
    {
        return $this->table_name;
    }

    /**
    * @param string $table_name;
    * @return $this
    */
    public function settable_name(string $table_name  = "")
    {
        $this->table_name = $table_name;
        return $this;
    }

    /* @var string  数据库连接,设置查询的时候,记录执行次数 */
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

    /* @var string  执行的sql语句 */
    protected $pdoSql = '';

    /**
    * @return string;
    */
    public function getpdoSql():string
    {
        return $this->pdoSql;
    }

    /**
    * @param string $pdoSql;
    * @return $this
    */
    public function setpdoSql(string $pdoSql  = "")
    {
        $this->pdoSql = $pdoSql;
        return $this;
    }

    /* @var string  绑定的关键词对象 */
    protected $sqlbinds = '';

    /**
    * @return string;
    */
    public function getsqlbinds():string
    {
        return $this->sqlbinds;
    }

    /**
    * @param string $sqlbinds;
    * @return $this
    */
    public function setsqlbinds(string $sqlbinds  = "")
    {
        $this->sqlbinds = $sqlbinds;
        return $this;
    }

    /* @var string  Mysql的会话id */
    protected $thread_id = '';

    /**
    * @return string;
    */
    public function getthread_id():string
    {
        return $this->thread_id;
    }

    /**
    * @param string $thread_id;
    * @return $this
    */
    public function setthread_id(string $thread_id  = "")
    {
        $this->thread_id = $thread_id;
        return $this;
    }

    /* @var string  SQL的操作函数 */
    protected $sqlaction = '';

    /**
    * @return string;
    */
    public function getsqlaction():string
    {
        return $this->sqlaction;
    }

    /**
    * @param string $sqlaction;
    * @return $this
    */
    public function setsqlaction(string $sqlaction  = "")
    {
        $this->sqlaction = $sqlaction;
        return $this;
    }

    /* @var string  影响到的行数 */
    protected $fetchnum = '';

    /**
    * @return string;
    */
    public function getfetchnum():string
    {
        return $this->fetchnum;
    }

    /**
    * @param string $fetchnum;
    * @return $this
    */
    public function setfetchnum(string $fetchnum  = "")
    {
        $this->fetchnum = $fetchnum;
        return $this;
    }

    /* @var string  消息类型:'info','error' */
    protected $messagetype = 'info';

    /**
    * @return string;
    */
    public function getmessagetype():string
    {
        return $this->messagetype;
    }

    /**
    * @param string $messagetype;
    * @return $this
    */
    public function setmessagetype(string $messagetype  = "info")
    {
        $this->messagetype = $messagetype;
        return $this;
    }

    /* @var string  异常消息 */
    protected $exception = '';

    /**
    * @return string;
    */
    public function getexception():string
    {
        return $this->exception;
    }

    /**
    * @param string $exception;
    * @return $this
    */
    public function setexception(string $exception  = "")
    {
        $this->exception = $exception;
        return $this;
    }

    /* @var bool  写入日志 */
    protected $Writefilelog = true;
    
    /**
    * @return bool;
    */
    public function getWritefilelog():bool
    {
        return $this->Writefilelog;
    }

    public function isWritefilelog():bool
    {
        return $this->getWritefilelog();
    }
    
    /**
    * @param bool $Writefilelog;
    * @return $this
    */
    public function setWritefilelog(bool $Writefilelog  = true)
    {
        $this->Writefilelog = $Writefilelog;
        return $this;
    }

    /* @var string  日志记录 */
    protected $trace = '';

    /**
    * @return string;
    */
    public function gettrace():string
    {
        return $this->trace;
    }

    /**
    * @param string $trace;
    * @return $this
    */
    public function settrace(string $trace  = "")
    {
        $this->trace = $trace;
        return $this;
    }
}
