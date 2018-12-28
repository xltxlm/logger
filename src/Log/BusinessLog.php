<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2018/5/31
 * Time: 下午1:18
 */

namespace xltxlm\logger\Log;

use xltxlm\snownum\Config\RedisCacheConfig;
use xltxlm\statistics\Config\Kkreview\BusinesslogModel;

/**
 * 记录业务日志
 * Class BusinessLog
 * @package xltxlm\logger\Log
 */
class BusinessLog extends BasicLog
{

    protected $tablename = '';

    /**
     * @return string
     */
    public function getTablename(): string
    {
        return $this->tablename;
    }

    /**
     * @param string $tablename
     * @return BusinessLog
     */
    public function setTablename(string $tablename): BusinessLog
    {
        $this->tablename = $tablename;
        return $this;
    }

    protected $business_id;

    /**
     * @return mixed
     */
    public function getBusinessId()
    {
        return $this->business_id;
    }

    /**
     * @param mixed $business_id
     * @return BusinessLog
     */
    public function setBusinessId($business_id)
    {
        $this->business_id = $business_id;
        return $this;
    }

    protected $key_id_1;

    /**
     * @return mixed
     */
    public function getKeyId1()
    {
        return $this->key_id_1;
    }

    /**
     * @param mixed $key_id_1
     * @return BusinessLog
     */
    public function setKeyId1($key_id_1)
    {
        $this->key_id_1 = $key_id_1;
        return $this;
    }

    protected $key_id_2;

    /**
     * @return mixed
     */
    public function getKeyId2()
    {
        return $this->key_id_2;
    }

    /**
     * @param mixed $key_id_2
     * @return BusinessLog
     */
    public function setKeyId2($key_id_2)
    {
        $this->key_id_2 = $key_id_2;
        return $this;
    }

    protected $hook;

    /**
     * @return mixed
     */
    public function getHook()
    {
        return $this->hook;
    }

    /**
     * @param mixed $hook
     * @return BusinessLog
     */
    public function setHook($hook)
    {
        $this->hook = $hook;
        return $this;
    }


    protected $tns = '';

    /**
     * @return string
     */
    public function getTns(): string
    {
        return $this->tns;
    }

    /**
     * @param string $tns
     * @return BusinessLog
     */
    public function setTns(string $tns): BusinessLog
    {
        $this->tns = $tns;
        return $this;
    }

    protected $mark;

    /**
     * @return mixed
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param mixed $mark
     * @return BusinessLog
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
        return $this;
    }


    public function __invoke()
    {
        //判断是否真正需要写日志
        if (!DefineLog::$writelog) {
            return;
        }

        parent::__invoke();

        $id = $this->getLogid() . $this->getDockername() . $this->getUniqid() . $this->getLogi();
        $BusinesslogModel = (new BusinesslogModel());

        $BusinesslogModel
            ->setId($id)
            ->setLogi($this->getLogi())
            ->setProject_name($this->getProjectname())
            ->setTablename($this->getTablename())
            ->setMark($this->getMark())
            ->setBusiness_id($this->getBusinessId())
            ->setKey_id_1($this->getKeyId1())
            ->setKey_id_2($this->getKeyId2())
            ->setFrom_event($this->getFromEvent())
            ->setHook($this->getHook())
            ->setMessagetype($this->getType())
            ->setCallClass($this->getCallClass())
            ->setUniqid($this->getUniqid())
            ->setEventid($this->getEventid())
            ->setDockername($this->getDockername())
            ->setHost_ip($this->getHOSTIP())
            ->setUsername($this->getUsername())
            ->setUsernameip($this->getRemoteaddr())
            ->setUpdate_time(date('Y-m-d H:i:s'))
            ->setAdd_time(date('Y-m-d H:i:s'))
            ->setTns($this->getTns())
            ->setTrace($this->getTrace());

        $data = sprintf('{ "index":  { "_index": "businesslog", "_type": "data","_id":"%s"}}' . "\n", $id) . $BusinesslogModel->__toString() . "\n";
        (new RedisCacheConfig())
            ->__invoke()
            ->lPush('log_list', $data);
        //file_put_contents("/var/www/html/log@" . date('YmdHi') . ".json", $data, FILE_APPEND);

    }
}