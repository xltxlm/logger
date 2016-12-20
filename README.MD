#用法
日志记录.内容记录在 php.ini 设置error_log参数的相同目录下,文件名的命名方式是[项目名称.log]

日志的类型定义参考字典类
\Psr\Log\LogLevel

#使用
记录的内容是一种结构化的数据,步骤是:
+ 需要先定义日志类  extends DefineLog
+ new 日志类  set 各个参数
+ 用(new Logger()) 写入 日志类

##功能
+ key=>var 的日志记录方式,方便以后统计入库
+ QPS报警


#案例
查看 tests 目录下的例子