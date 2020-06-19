<?php
namespace xltxlm\logger\test\LoggerTrack\LoggerTrack_noflow_238_0Test;

/**
* 测试案例的数据供给
*/
Trait LoggerTrack_noflow_238_0Provider {

    /**
     * 测试的数据供给器
     */
    public function MyProvider(){
        return [
        ["",true,null,""],
        ]+ $this->remoteconfig();
    }

    /**
     * 获取远程配置代码。
     * 因为是远程获取配置的原因，所以传递过去一定是字符串
     */
    function remoteconfig()
    {
        $config = [];
        return $config;
    }
}

