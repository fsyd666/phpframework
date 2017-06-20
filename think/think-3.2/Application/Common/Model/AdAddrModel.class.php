<?php

namespace Common\Model;

use Think\Model;

/**
 * 广告位
 */
class AdAddrModel extends Model {

    public $_fields = array(
        //字段
        'id' => 'Id',
        'name' => '名称',
    );
    public $_type = array(
        1 => '图片广告',
        2 => '幻灯广告',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array();

}
