package Grpclog

type Grpclog struct {
    /* 模块名称 */
    model_name string

    /* 主键id */
    Keyid string

    /* 目标地址ip/地址 */
    ip string

    /* 端口 */
    port string

    /* 接口返回的数据 */
    return_data string

    /* 请求的数据 */
    request_data string

    /* 接口错误的理由 */
    error string

    /* 请求的反向类型.客户端还是服务端 */
    Logtype string

    /* 执行次数 */
    log_times int

}

func NewGrpclog(Keyid string,Logtype string) *Grpclog{
    var this = new(Grpclog)
    this.SetKeyid(Keyid);
    this.SetLogtype(Logtype);
    return this
}

func (this *Grpclog)GetKeyid() string{
    return this.Keyid;
}

func (this *Grpclog)SetKeyid(Keyid string) *Grpclog{
    this.Keyid = Keyid;
    return this
}
func (this *Grpclog)GetLogtype() string{
    return this.Logtype;
}

func (this *Grpclog)SetLogtype(Logtype string) *Grpclog{
    this.Logtype = Logtype;
    return this
}

