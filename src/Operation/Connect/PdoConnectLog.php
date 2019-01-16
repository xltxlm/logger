<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/20
 * Time: 14:59.
 */

namespace xltxlm\logger\Operation\Connect;

use Psr\Log\LogLevel;
use xltxlm\helper\Basic\Str;
use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\Action\PdoRunLog;
use xltxlm\logger\Operation\EnumResource;
use xltxlm\orm\Config\PDO;
use xltxlm\orm\Config\PdoConfig;
use xltxlm\orm\PdoInterface;
use xltxlm\snownum\Config\RedisCacheConfig;
use xltxlm\statistics\Config\Kkreview\MysqllogModel;

class PdoConnectLog extends BasicLog
{
    const LIAN_JIE = "链接";
    const ZHI_XIN = "执行";
    const TI_JIAO_SHI_WU = "提交事务";
    const HUI_GUN_SHI_WU = "回滚事务";

    /** @var PdoConfig */
    protected $pdoConfig;

    /** @var string 数据库配置 */
    protected $tns = "";
    /** @var string 数据库 */
    protected $db = "";
    /** @var int 数据库会话id */
    protected $thread_id = 0;
    /** @var bool 是否开启事务的标志 */
    protected $Transaction = true;
    protected $action = self::LIAN_JIE;
    /** @var  string */
    protected $pdoSql = "";
    protected $sqlbinds = [];

    /** @var bool 本条记录是否写入日志文件 */
    protected $writefilelog = true;

    /**
     * @return bool
     */
    public function isWritefilelog(): bool
    {
        return $this->writefilelog;
    }

    /**
     * @param bool $writefilelog
     * @return $this
     */
    public function setWritefilelog(bool $writefilelog)
    {
        $this->writefilelog = $writefilelog;
        return $this;
    }


    /** @var string 执行语句的表格名称 */
    protected $table_name = "";
    /** @var string  所执行的sql操作是读取还是修改类的 */
    protected $sqlaction = "";

    /**
     * 构造函数
     * PdoConnectLogger constructor.
     */
    public function __construct(PdoInterface $PdoInterface = null)
    {
        parent::__construct();
        $this->setReource(EnumResource::SHU_JU_KU);
        if ($PdoInterface) {
            //日志不要记录密码这个字段
            //$PdoInterface = clone $PdoInterface;
            $this->setDb($PdoInterface->getPdoConfig()->getDb());
            $this->setTns($PdoInterface->getPdoConfig()->getTNS());
            $this->setPdoConfig($PdoInterface->getPdoConfig());
            $this->setTransaction($PdoInterface->isBuff());
            if ($PdoInterface->getSqlParserd()) {
                $this->setPdoSql($PdoInterface->getSqlParserd()->getSql());
                $this->setSqlbinds($PdoInterface->getSqlParserd()->getBindArray());
            }
            $sign = $PdoInterface->getPdoConfig()->getPdoString() . $PdoInterface->getPdoConfig()->getUsername() . $PdoInterface->getPdoConfig()->getPassword() . $this->getPosixGetpid() . (int)$PdoInterface->isBuff();
            $thread_id = intval(PDO::thread_id($sign));
            $this->setThreadId($thread_id);
            if ($thread_id == 0) {
                $this->trace["kaoinfo"] = [
                    $PdoInterface,
                    $sign,
                    PDO::$thread_ids
                ];
            }
            //记录日志的时候，不要写入密码
            //$PdoInterface->getPdoConfig()->setPassword('');
        }
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    /**
     * @param string $table_name
     * @return $this
     */
    public function setTableName(string $table_name)
    {
        $this->table_name = $table_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSqlaction(): string
    {
        return $this->sqlaction;
    }

    /**
     * @param string $sqlaction
     * @return $this
     */
    public function setSqlaction(string $sqlaction)
    {
        $this->sqlaction = $sqlaction;
        return $this;
    }


    /**
     * @return string
     */
    public function getTns(): string
    {
        return $this->tns;
    }

    /**
     * @param string $tns
     * @return PdoConnectLog
     */
    public function setTns(string $tns)
    {
        $this->tns = $tns;
        return $this;
    }


    /**
     * @return bool
     */
    public function isTransaction(): bool
    {
        return $this->Transaction;
    }


    /**
     * @param bool $Transaction
     * @return $this
     */
    public function setTransaction(bool $Transaction)
    {
        $this->Transaction = $Transaction;
        return $this;
    }

    /**
     * @return string
     */
    public function getDb(): string
    {
        return $this->db;
    }


    /**
     * @param string $db
     * @return $this
     */
    public function setDb(string $db)
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @return PdoConfig
     */
    public function getPdoConfig(): PdoConfig
    {
        return $this->pdoConfig;
    }

    /**
     * @param PdoConfig $pdoConfig
     *
     * @return PdoConnectLog
     */
    public function setPdoConfig(PdoConfig $pdoConfig)
    {
        $this->pdoConfig = $pdoConfig;

        return $this;
    }

    /**
     * @return int
     */
    public function getThreadId(): int
    {
        return $this->thread_id;
    }

    /**
     * @param int $thread_id
     * @return $this
     */
    public function setThreadId(int $thread_id)
    {
        $this->thread_id = $thread_id;
        return $this;
    }

    /**
     * @return array
     */
    public function getSqlbinds(): array
    {
        return $this->sqlbinds;
    }

    /**
     * @param array $sqlbinds
     * @return PdoRunLog
     */
    public function setSqlbinds(array $sqlbinds)
    {
        $this->sqlbinds = $sqlbinds;
        return $this;
    }

    /**
     * @return string
     */
    public function getPdoSql(): string
    {
        return $this->pdoSql;
    }

    /**
     * @param string $pdoSql
     * @return PdoRunLog
     */
    public function setPdoSql(string $pdoSql)
    {
        $this->pdoSql = $pdoSql;
        return $this;
    }

    public function __invoke()
    {
        //判断是否真正需要写日志
        $不需要写入日志 = !DefineLog::$writelog || $this->isWritefilelog() == false;
        if ($不需要写入日志) {
            return null;
        }
        parent::__invoke();
        $buffer = get_object_vars($this);
        /** @var MysqllogModel $mysqllogModel */
        $id = $buffer['logid'] . $buffer['dockername'] . $buffer['uniqid'] . $buffer['logi'];
        $mysqllogModel = (new MysqllogModel());
        $mysqllogModel
            ->setId($id)
            ->setHost_ip($buffer['HOST_IP'])
            ->setDockername($this->getDockername())
            ->setProject_name($this->getProjectname())
            ->setTable_name($this->getTableName())
            ->setPdoSql($this->getPdoSql())
            ->setSqlbinds(json_encode($buffer['sqlbinds'] ?: [], JSON_UNESCAPED_UNICODE))
            ->setRunTime($buffer['runTime'])
            ->setThread_id($this->getThreadId())
            ->setPosix_getpid($this->getPosixGetpid())
            ->setLogid($this->getLogid())
            ->setCallClass($buffer['callClass'])
            ->setHostname($buffer['hostname'])
            ->setFetchnum($buffer['fetchnum']);
        //方法调用链过长的时候，ide不识别剩下的方法
        $mysqllogModel
            ->setRemote_addr($buffer['remote_addr'])
            ->setReferer($buffer['referer'])
            ->setAdd_time($buffer['add_time'])
            ->setUniqid($buffer['uniqid'])
            ->setAction($this->getAction())
            ->setSqlaction($buffer['sqlaction'])
            ->setLogi($buffer['logi'])
            ->setTns($buffer['tns'])
            ->setTransaction($buffer['Transaction'] ? '是' : '否')
            ->setMessagetype($this->getType());
        //如果是错误日志,记录全部的调试信息,否则简化
        $mysqllogModel
            ->setException($buffer['Exception'])
            ->setTrace(join("\n", $this->getTrace()));
        $mysqllogModel
            ->setEventid($this->getEventid())
            ->setMemory($buffer['memory']);

        $data = sprintf('{ "index":  { "_index": "mysqllog", "_type": "data","_id":"%s"}}' . "\n", $id) . $mysqllogModel->__toString() . "\n";
        try {
            (new RedisCacheConfig())
                ->__invoke()
                ->lPush('log_list', $data);
        } catch (\Exception $e) {
            \xltxlm\helper\Util::d([$e->getMessage(),$e->getFile(),$e->getLine()]);
        }
    }

}
