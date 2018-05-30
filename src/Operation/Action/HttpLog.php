<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/18
 * Time: 17:24
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\guzzlehttp\UrlRequest;
use xltxlm\logger\Operation\Connect\PdoConnectLog;
use xltxlm\logger\Operation\EnumResource;

/**
 * 网址请求耗时日志
 * Class HttpLog
 */
class HttpLog extends PdoConnectLog
{

    /**
     * HttpLog constructor.
     */
    public function __construct(UrlRequest $urlRequest = null)
    {
        parent::__construct();
        $parse_url = parse_url($urlRequest->getUrl(),PHP_URL_HOST);
        $this->setMessage($urlRequest)
            ->setTableName($parse_url)
            ->setAction(EnumResource::HTTP)
            ->setPdoSql($urlRequest->getUrl())
            ->setSqlbinds(is_array($urlRequest->getBody()) ? $urlRequest->getBody() : [$urlRequest->getBody()]);
    }
}