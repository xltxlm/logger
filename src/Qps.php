<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-18
 * Time: 下午 12:58
 */

namespace xltxlm\logger;

use Tac\Tac;

/**
 * 将记录的日志取出来最新的2000条,计算QPS
 * Class Qps
 * @package xltxlm\logger
 */
final class Qps
{
    /** @var string 日志文件的路径 */
    protected $file = "";
    /** @var int 读取的行数 */
    protected $lines = 2000;

    /**
     * Qps constructor.
     * @param $file
     */
    public function __construct($file)
    {
        if ($file) {
            $this->setFile($file);
        }
    }

    /**
     * @return int
     */
    public function getLines(): int
    {
        return $this->lines;
    }

    /**
     * @param int $lines
     * @return Qps
     */
    public function setLines(int $lines): Qps
    {
        $this->lines = $lines;
        return $this;
    }

    /**
     * @param mixed $file
     * @return Qps
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function __invoke()
    {
        $tacs = (new Tac($this->file))
            ->tail($this->getLines());
        $qps = [];
        $endTime = date('Y-m-d H:i:s', strtotime("- 30 minute"));
        foreach ($tacs as $tac) {
            preg_match("/ logClassName=([^ ]+) .* logtimeshow=([^=]+)/", $tac, $items);
            $logCLassName = $items[1];
            $logTimeShow = $items[2];
            if ($logCLassName && $logTimeShow && $logTimeShow > $endTime) {
                //如果时间已经超过当前 半小时前,不操作
                $qps[$logCLassName][$logTimeShow]++;
            }
        }
        foreach ($qps as &$qp) {
            arsort($qp, SORT_NUMERIC);
        }
        return $qps;
    }
}
