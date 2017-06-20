<?php

namespace Common\Model;

use Think\Model;
/**
 * 友情链接分类
 */
class LinkCateModel extends CommonModel {

    public $_fields = array(
        //字段
        'id' => 'ID',
        'name' => '名称',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array();

}
