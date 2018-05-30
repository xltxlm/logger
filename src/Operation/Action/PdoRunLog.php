<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 6:42.
 */

namespace xltxlm\logger\Operation\Action;

use xltxlm\logger\Operation\Connect\PdoConnectLog;
use xltxlm\orm\PdoInterface;

class PdoRunLog extends PdoConnectLog
{


    /** @var int 读取或者更改影响到的行数 */
    protected $fetchnum = 0;

    /**
     * @return int
     */
    public function getFetchnum(): int
    {
        return $this->fetchnum;
    }

    /**
     * @param int $fetchnum
     * @return PdoRunLog
     */
    public function setFetchnum(int $fetchnum)
    {
        $this->fetchnum = $fetchnum;
        return $this;
    }


    /**
     * PdoRunLog constructor.
     */
    public function __construct(PdoInterface $PdoInterface)
    {
        parent::__construct($PdoInterface);
        $this->setAction(PdoConnectLog::ZHI_XIN);
    }


}
