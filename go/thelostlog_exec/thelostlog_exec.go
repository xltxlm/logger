package thelostlog_exec

type thelostlog_exec struct {
    /* 统计执行的次数 */
    log_times int

    /* 执行的命令 */
    command string

    /* 执行的结果 */
    result string

    /* 返回的错误信息 */
    error string

}

func Newthelostlog_exec() *thelostlog_exec{
    var this = new(thelostlog_exec)
    return this
}


