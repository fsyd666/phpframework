<?php

namespace Common\Model;

use Think\Model;

/**
 * 文章视频
 */
class ArticleModel extends CommonModel {

    public $_type = array(
        1 => '文章',
        2 => '视频'
    );
    public $_fields = array(
        //字段
        'id' => 'Id',
        'tid' => '老师',
        'cid' => '分类',
        'title' => '标题',
        'photo' => '图片',
        'tname' => '老师名字',
        'author' => '发布者',
        'type' => '类型',
        'vedio_url' => '视频地址',
        'auth' => '权限',
        'zan_num' => '点赞数',
        'addtime' => '添加时间',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array();

    protected function _after_insert($data, $options) {

        parent::_after_insert($data, $options);
        //更新teacher_post
        $data['url'] = '/live/art/' . $data['id'];
        D('TeacherPost')->addData($data, $this->name);
    }

    protected function _after_update($data, $options) {
        parent::_after_update($data, $options);
        $data['url'] = '/live/art/' . $data['id'];
        D('TeacherPost')->saveData($data, $this->name);
    }

    protected function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        if (is_array($data['id'])) {
            D('TeacherPost')->delData($data['id'][1], $this->name);
        } else {
            D('TeacherPost')->delData($data['id'], $this->name);
        }

        //删除content 表的内容
        $cont['artid'] = $data['id'];
        D('ArtContent')->where($cont)->delete();
    }

    protected function _after_select(&$resultSet, $options) {
        parent::_after_select($resultSet, $options);
        foreach ($resultSet as $k => $v) {
            if (isset($v['photo']))
                $resultSet[$k]['photo'] = $v['photo'] ? $v['photo'] : '/Uploads/default/pic.png';
        }
    }

    //从栏目获取
    function getListCate($cid, $rows = 10, $order = 'id desc') {
        return $this->cache(true)->order($order)->where("cid=$cid")->limit($rows)->select();
    }

}
