<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-11
 * Time: 下午 9:17
 */

namespace xltxlm\logger\tests\Resource;

use xltxlm\logger\Log\DefineLog;

class DemoDefineLog extends DefineLog
{
    protected $name = __FILE__;
    protected $id = __LINE__;
}
