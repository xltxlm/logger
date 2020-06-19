<?php


namespace xltxlm\logger;


/**
 * 跟踪资源的耗时
 * Class LoggerTrack
 *
 */
class LoggerTrack extends LoggerTrack\LoggerTrack_implements
{
    public function __construct()
    {
        if (isset($_SERVER['logid'])) {
            $this->setlogid($_SERVER['logid']);
        } else {
            $this->setlogid(\dk_get_next_id());
        }
        $this->settimestamp_start(microtime(true));
        $this->setadd_time(date('Y-m-d H:i:s'));

        $debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($debug_backtrace as $k => $item) {
            if (strpos($item['file'], '/vendor/') !== false) {
                unset($debug_backtrace[$k]);
            }
        }
        $this->setdebug_backtrace($debug_backtrace);

    }

    /**
     * 记录起来：打印到错误日志文件里面
     */
    function __invoke()
    {
        //记录日志的过程中，任何一点错误都不能影响业务的主进程继续
        try {
            $this->__realinvoke();
        } catch (\Throwable $e) {
            error_log(json_encode(['日志logger本身错误', $e->getMessage(), $e->getFile(), $e->getLine()], JSON_UNESCAPED_UNICODE));
        }
    }

    function __realinvoke()
    {
        static $log_num = 0;
        $log_num++;
        $this->setlog_num($log_num);
        $this->settimestamp_end(microtime(true));
        //如果没有设置运行时间差，那么初始化类，到结束就是时间差
        if (!$this->getuse_times()) {
            $this->setuse_times(sprintf('%.4f', floatval($this->gettimestamp_end() - $this->gettimestamp_start())));
        }

        $this->sethaveloged(true);
        if (!flow::isgetready()) {
            return;
        }
        //如果当前项目配置有回调函数，那么把日志给到回调函数进行处理
        $getcallback_function = flow::getcallback_function();
        if (is_callable($getcallback_function)) {
            $this_array = [];
            //有几个私有的属性，不要传递成日志内容，只是辅助计算而已
            $Properties = (new \ReflectionClass($this))->getProperties(\ReflectionProperty::IS_PROTECTED);
            /** @var \ReflectionProperty $property */
            foreach ($Properties as $property) {
                $property->setAccessible(true);
                $this_array[$property->getName()] = $property->getValue($this);
            }
            //在进程的第一次运行时候，把运行环境的所有配置，作为一次日志记录起来（）不受任何条件的约束。
            if ($log_num == 1) {
                call_user_func($getcallback_function, [
                    'dockername' => @$_SERVER['dockername'],
                    'ip' => (string)@$_SERVER['HTTP_X_REAL_IP'] ?? @$_SERVER['REMOTE_ADDR'],
                    'PHP_SAPI' => PHP_SAPI,
                    'refer' => @$_SERVER['HTTP_REFERER'],
                    'get' => $_GET,
                    'post' => $_POST,
                    'file' => $_FILES,
                    'cookie' => $_COOKIE,
                    'args' => @$_SERVER['argv']
                ]);
            }
            //本次日志
            call_user_func($getcallback_function, $this_array);
        }
    }

    public function __destruct()
    {
        if (empty($this->gethaveloged())) {
            $this->__invoke();
        }
    }


}