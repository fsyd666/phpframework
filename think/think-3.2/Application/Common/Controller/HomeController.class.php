<?php

namespace Common\Controller;

use Think\Controller;

class HomeController extends Controller {

    function _initialize() {
        //网站全局配置
        $this->assign('global', D('Config')->getConf());
        //导航菜单
        $ctrl = strtolower(CONTROLLER_NAME);
        $module = strtolower(MODULE_NAME);
        $nav = array(
            array('name' => '官网首页', 'url' => '/', 'check' => "$module/$ctrl" == 'home/index' ? 1 : 0),
            array('name' => '新手入门', 'url' => '/novice', 'check' => $ctrl == 'novice' ? 1 : 0),
            array('name' => '名师直播', 'url' => '/live', 'check' => $ctrl == 'live' ? 1 : 0),
            array('name' => '服务体系', 'url' => '/service', 'check' => $ctrl == 'service' ? 1 : 0),
            array('name' => '工具下载', 'url' => '/download', 'check' => $ctrl == 'download' ? 1 : 0),
            array('name' => '关于我们', 'url' => '/about', 'check' => $ctrl == 'about' ? 1 : 0),
            array('name' => '个人中心', 'url' => '/member', 'check' => $module == 'member' ? 1 : 0),
        );
        $this->assign('nav', $nav);
        //用户信息
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
