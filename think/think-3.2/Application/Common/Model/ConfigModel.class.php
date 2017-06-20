<?php

namespace Common\Model;

use Think\Model;
/**
 * 网站配置
 */
class ConfigModel extends CommonModel {

    public $_fields = array(
        //字段
        'name' => '名称',
        'val' => '值',
        'desc' => '描述',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array();

    function getConf() {
        $data = F('config_cache');
        if (!$data) {
            $data = $this->getField('name,val');
            F('config_cache', $data);
        }
        return $data;
    }

    //清缓存
    private function clear_cache() {
        F('config_cache', null);
    }

    //更改了配置 自动清除缓存
    protected function _after_update($data, $options) {
        parent::_after_update($data, $options);
        $this->clear_cache();
    }

    //更改了配置 自动清除缓存
    protected function _after_insert($data, $options) {
        parent::_after_insert($data, $options);
        $this->clear_cache();
    }

}
