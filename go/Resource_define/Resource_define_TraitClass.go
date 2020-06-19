package Resource_define

type Resource_define_TraitClass struct {
    /* 链接地址 */
    tns string

    /* 账户 */
    user string

    /* 端口 */
    port string

    /* 资源类型 */
    resources_type string

}

func NewResource_define_TraitClass() *Resource_define_TraitClass{
    var this = new(Resource_define_TraitClass)
    return this
}


/**
    生成json字符串,写入日志redis服务器*/
func (this *Resource_define_TraitClass)__invoke(){

}

