<?php

namespace Common\Model;

use Think\Model;

class ArtContentModel extends CommonModel {

    public $_fields = array(
//字段
        'artid' => 'Artid',
        'content' => 'Content',
    );
//自动验证
    protected $_validate = array();
//自动完成
    protected $_auto = array();

}
