<?php
namespace xltxlm\logger\flow;

/**
 * :类;
 * 指定日志流向的工厂;
*/
abstract class flow_implements
{


/* @var callable  可以被回调的函数入口。本类不提供，需要引入时自己指定。在具体项目中，有一个公用的流程：读取远程配置来控制最终写文件、写nginx，写慢日志，写错误功能 */
        public  static $callback_function;





    /**
    * 可以被回调的函数入口。本类不提供，需要引入时自己指定。在具体项目中，有一个公用的流程：读取远程配置来控制最终写文件、写nginx，写慢日志，写错误功能;
    * @return callable;
    */
            public static  function getcallback_function():callable        {
            return static::$callback_function;
        }

    
    




/**
* @param callable $callback_function;
*/
    abstract public static  function setcallback_function(callable $callback_function );



/* @var bool   */
    public  static $getready = false;
    




    /**
    * ;
    * @return bool;
    */
            public static  function getgetready():bool        {
            return static::$getready;
        }

    
            public static  function isgetready():bool        {
        return static::$getready;
        }
    




/**
* @param bool $getready;
*/
    protected static  function setgetready(bool $getready  = false)
    {
    static::$getready = $getready;
    }



/**
*  清理掉之前设置的回调函数;
*  @return ;
*/
abstract public static function clean();
}