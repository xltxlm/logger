package Log

type Destruct_Log struct {
    /* 开始记录日志的时间戳 */
    timestamp_start string

    /* 是否已经主动写入日志 */
    haveloged bool

    /* 记录相同进行下,当条日志的时序 */
    posix_log_num array

    /* 程序执行的入口标志 */
    Atcion_entrance string

    /* 各种日志条数的统计存储 */
    log_cout array

}

func NewDestruct_Log(Atcion_entrance string) *Destruct_Log{
    var this = new(Destruct_Log)
    this.SetAtcion_entrance(Atcion_entrance);
    return this
}

func (this *Destruct_Log)GetAtcion_entrance() string{
    return this.Atcion_entrance;
}

func (this *Destruct_Log)SetAtcion_entrance(Atcion_entrance string) *Destruct_Log{
    this.Atcion_entrance = Atcion_entrance;
    return this
}

/**
    析构的时候,尝试写入日志*/
func (this *Destruct_Log)__destruct(){

}

/**
    手动调用写入日志的接口*/
func (this *Destruct_Log)__invoke(){

}

/**
    初始化入口标志和日志开始计时时间*/
func (this *Destruct_Log)__construct(){

}

