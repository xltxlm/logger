<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/6
 * Time: 10:57.
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\Connect\ElasticsearchConnectLog;

class ElasticsearchRunLog extends ElasticsearchConnectLog
{
    /** @var array 查询语句 */
    protected $ElasticsearchQueryString = [];

    /**
     * ElasticsearchRunLog constructor.
     */
    public function __construct($ElasticsearchConfig = null)
    {
        parent::__construct($ElasticsearchConfig);
        $this->setAction(DefineLog::ZHEN_CHANG);
    }


    /**
     * @return array
     */
    public function getElasticsearchQueryString(): array
    {
        return $this->ElasticsearchQueryString;
    }

    /**
     * @param array $ElasticsearchQueryString
     *
     * @return ElasticsearchRunLog
     */
    public function setElasticsearchQueryString(array $ElasticsearchQueryString): ElasticsearchRunLog
    {
        $this->ElasticsearchQueryString = $ElasticsearchQueryString;

        return $this;
    }
}
