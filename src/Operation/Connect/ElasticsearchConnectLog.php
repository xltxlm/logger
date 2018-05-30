<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/13
 * Time: 9:48.
 */

namespace xltxlm\logger\Operation\Connect;

use xltxlm\elasticsearch\Elasticsearch;
use xltxlm\elasticsearch\Unit\ElasticsearchConfig;
use xltxlm\helper\Hclass\ConvertObject;
use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\EnumResource;

/**
 * 链接记录
 * Class ElasticsearchConnectLogger.
 */
class ElasticsearchConnectLog extends BasicLog
{
    /** @var ElasticsearchConfig */
    protected $ElasticsearchConfig;

    /**
     * 当前记录的类算在运行类身上,不是orm
     * PdoRunLog constructor.
     */
    public function __construct($ElasticsearchConfig = null)
    {
        $this->setReource(EnumResource::ELASTICSEARCH);
        $this->setAction(DefineLog::LIAN_JIE);
        parent::__construct();
        if ($ElasticsearchConfig) {
            $this->setElasticsearchConfig($ElasticsearchConfig);
        }
    }

    /**
     * @return ElasticsearchConfig
     */
    public function getElasticsearchConfig(): ElasticsearchConfig
    {
        return $this->ElasticsearchConfig;
    }

    /**
     * @param ElasticsearchConfig $ElasticsearchConfig
     *
     * @return ElasticsearchConnectLog
     */
    public function setElasticsearchConfig(ElasticsearchConfig $ElasticsearchConfig): ElasticsearchConnectLog
    {
        if (strpos(get_class($ElasticsearchConfig), 'class@anonymous') !== false) {
            $this->ElasticsearchConfig = (new ConvertObject())
                ->setObject($ElasticsearchConfig)
                ->toArray();
        } else {
            $this->ElasticsearchConfig = $ElasticsearchConfig;
        }

        return $this;
    }
}
