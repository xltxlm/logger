<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/20
 * Time: 14:59.
 */

namespace xltxlm\logger\Operation\Connect;

use xltxlm\logger\Log\BasicLog;
use xltxlm\logger\Log\DefineLog;
use xltxlm\logger\Operation\EnumResource;
use xltxlm\orm\Config\PdoConfig;
use xltxlm\orm\PdoClient;

class PdoConnectLog extends BasicLog
{
    /** @var PdoConfig */
    protected $pdoConfig;

    /**
     * PdoConnectLogger constructor.
     */
    public function __construct($pdoConfig = null)
    {
        parent::__construct();
        $this->setReource(EnumResource::SHU_JU_KU);
        $this->setAction(DefineLog::LIAN_JIE);
        if ($pdoConfig) {
            $this->setPdoConfig($pdoConfig);
        }
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
    public function setPdoConfig(PdoConfig $pdoConfig): PdoConnectLog
    {
        $this->pdoConfig = $pdoConfig;

        return $this;
    }
}
