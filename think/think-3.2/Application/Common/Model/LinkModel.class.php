<?php

namespace Common\Model;

use Think\Model;

/**
 * 友情链接
 */
class LinkModel extends Model {

    public $_fields = array(
        //字段
        'id' => 'ID',
        'cid' => '类别',
        'name' => '名称',
        'logo' => 'Logo',
        'url' => 'Url',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array();

    function getLink($cid) {
        $data = $this->where("cid=$cid")->cache(true,0)->select();
        return $data;
    }

}
