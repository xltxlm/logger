<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2018/5/31
 * Time: 下午1:18
 */

namespace xltxlm\logger\Log;

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
        return;
    }
}