<?php

/**
 * 友情链接控制器
 */

namespace Admin\Controller;

use Think\Controller;

class LinkController extends CommonController {

    public $model = 'Link';

    public function _initialize() {
        parent::_initialize();
        $this->assign('cid', D('LinkCate')->getField('id,name'));
    }

    //列表
    public function index() {
        if (!empty($_GET['stype'])) {
            $stype = $_GET['stype'];
            switch ($stype) {
                case 'cid':
                    $param['where'] = "$stype = {$_GET['cid']}";
                    break;
                default :
                    $param['where'] = "$stype like '%{$_GET['skey']}%'";
            }
            $list = $this->page(D($this->model), $param);
        } else {
            $list = $this->page(D($this->model));
        }
        $this->assign('list', $list);
        cookie('edit_prev_url', __SELF__);
        $this->display();
    }

    //添加
    public function add() {
        if (IS_POST) {
            $m = D($this->model);
            if (!$m->create()) {
                $this->error($m->getError());
            }
            if ($m->add()) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        }
        $this->assign('action_name', '添加');
        //带有checkbox的默认值  1默认是开 0默认是关闭
        $this->assign('data', array('status' => 1));
        $this->display('form');
    }

    //编辑
    public function edit($id) {
        $m = D($this->model);
        if (IS_POST) {
            if (!$m->create()) {
                $this->error($m->getError());
            }
            if (false !== $m->save()) {
                $this->success('修改成功', cookie('edit_prev_url'));
            } else {
                $this->error('修改失败');
            }
        }
        $this->assign('action_name', '修改')
                ->assign('data', $m->find($id));
        $this->display('form');
    }

    //查看
    public function view($id) {
        $this->assign('data', D($this->model)->find($id));
        $this->display();
    }
}
