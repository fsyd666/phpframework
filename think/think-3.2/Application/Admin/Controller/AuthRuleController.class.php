<?php

/**
 * 菜单控制器
 */

namespace Admin\Controller;

use Think\Controller;

class AuthRuleController extends CommonController {

    public $model = 'AuthRule';

    //列表
    public function index() {
        if (!empty($_GET['stype']) && !empty($_GET['skey'])) {
            $stype = $_GET['stype'];
            $sval = $_GET['skey'];
            $param['where'] = "$stype like '%$sval%'";
            $list = $this->page(D($this->model), $param, true);
        } else {
            $list = $this->page(D($this->model), array(), true);
        }
        $this->assign('list', $list);

        $this->assign('menu', D('menu')->menu);
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
        $this->assign('data', array('status' => 1, 'type' => 1))
                ->assign('menu', D('Menu')->menu);
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
                ->assign('data', $m->find($id))
                ->assign('menu', D('Menu')->menu);
        $this->display('form');
    }

    //查看
    public function view($id) {
        $this->assign('data', D($this->model)->find($id));
        $this->display();
    }

}
