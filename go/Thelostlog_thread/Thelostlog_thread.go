package Thelostlog_thread

type Thelostlog_thread struct {
    /* 最后一次错误信息 */
    error_message string

}

func NewThelostlog_thread() *Thelostlog_thread{
    var this = new(Thelostlog_thread)
    return this
}


/**
    */
func (this *Thelostlog_thread)重置日志次数统计(){

}

