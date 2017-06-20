<?php

namespace Common\Controller;

use Think\Controller;

class HomeController extends Controller {

    function _initialize() {
        //网站全局配置
        $this->assign('global', D('Config')->getConf());
        $this->assign('user', $_SESSION['member']);
    }

    protected function getUser($key = 'id') {
        if ($key === 'ALL') {
            return $_SESSION['member'];
        } else {
            return $_SESSION['member'][$key];
        }
    }

    protected function page($model, $param = array(), $customUrl = null) {
        $_param = array(
            'where' => 1, //查询条件
            'order' => 'id desc', //排序
            'relation' => false, //关联模型
            'rows' => 10
        );
        //var_dump($param);
        $param = array_merge($_param, $param); //获得最新参数

        $count = $model->where($param['where'])->count();
        $Page = new \Think\Page($count, $param['rows']);
        if ($param['relation']) {//关联模型
            $list = $model->relation($param['relation'])->order($param['order'])->where($param['where'])->limit($Page->firstRow . ',' . $Page->listRows)->select();
        } else {
            $list = $model->order($param['order'])->where($param['where'])->limit($Page->firstRow . ',' . $Page->listRows)->select();
        }

        //echo ($model->getLastSql());
        $Page->setConfig('header', '共 %TOTAL_ROW% 条记录 共%TOTAL_PAGE%页');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('first', '第一页');
        $Page->lastSuffix = FALSE;
        $Page->setConfig('last', '末页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        //自定义url
        if ($customUrl) {
            $Page->customUrl = $customUrl;
        }

        $this->assign('page', $Page->show());
        return $list;
    }

    //重定义success函数
    function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
        exit;
    }

}
