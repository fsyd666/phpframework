<?php

namespace Common\Model;

use Think\Model;

/**
 * 广告
 */
class AdModel extends CommonModel {

    public $_fields = array(
        //字段
        'id' => 'ID',
        'aid' => '广告位',
        'name' => '名称',
        'photo' => '图片',
        'desc' => '描述',
        'url' => 'Url',
        'status' => '状态',
        'sort' => '排序',
    );

    //获取AD列表
    function getAd($aid) {
        //获取广告位
        $addr = D('AdAddr')->find($aid);
        switch ($addr['type']) {
            case 1:
                $ad = $this->where("aid=$aid AND status = 1")->order('sort')->find();
                break;
            case 2:
                $ad = $this->where("aid=$aid AND status = 1")->order('sort')->select();
                break;
            default :
                $ad = false;
                break;
        }
        return $ad;
    }

    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array();

}
