package Thelostlog

type TraitClass struct {
    /* 所属的资源类型,db?redis? */
    resources_type string

    /* 所在函数/业务意义 */
    Function_name string

    /* 日志类型是信息还是错误 */
    message_type string

}

func NewTraitClass(Function_name string) *TraitClass{
    var this = new(TraitClass)
    this.SetFunction_name(Function_name);
    return this
}

func (this *TraitClass)GetFunction_name() string{
    return this.Function_name;
}

func (this *TraitClass)SetFunction_name(Function_name string) *TraitClass{
    this.Function_name = Function_name;
    return this
}

/**
    生成json字符串,写入日志服务器上面*/
func (this *TraitClass)__invoke(){

}

