package Mysqllog

type Mysqllog_TraitClass struct {
    /* 操作的表格名称 */
    table_name string

    /* 数据库连接,设置查询的时候,记录执行次数 */
    tns string

    /* 执行的sql语句 */
    pdoSql string

    /* 绑定的关键词对象 */
    sqlbinds string

    /* Mysql的会话id */
    thread_id string

    /* SQL的操作函数 */
    sqlaction string

    /* 影响到的行数 */
    fetchnum string

    /* 消息类型:'info','error' */
    messagetype string

    /* 异常消息 */
    exception string

    /* 写入日志 */
    Writefilelog bool

    /* 日志记录 */
    trace string

}

func NewMysqllog_TraitClass(Writefilelog bool) *Mysqllog_TraitClass{
    var this = new(Mysqllog_TraitClass)
    this.SetWritefilelog(Writefilelog);
    return this
}

func (this *Mysqllog_TraitClass)GetWritefilelog() bool{
    return this.Writefilelog;
}

func (this *Mysqllog_TraitClass)SetWritefilelog(Writefilelog bool) *Mysqllog_TraitClass{
    this.Writefilelog = Writefilelog;
    return this
}

