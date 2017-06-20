<?php

/**
 * 用户组控制器
 */

namespace Admin\Controller;

use Think\Controller;

class AuthGroupController extends CommonController {

    public $model = 'AuthGroup';

    //列表
    public function index() {
        if (!empty($_GET['stype']) && !empty($_GET['skey'])) {
            $stype = $_GET['stype'];
            $sval = $_GET['skey'];
            $param['where'] = "$stype like '%$sval%'";
            $list = D($this->model)->where($param['where'])->select();
        } else {
            $list = D($this->model)->select();
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

        //规则       
        $this->assign('rules', D('AuthRule')->getRules());
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
        $data = $m->find($id);
        $this->assign('action_name', '修改')
                ->assign('data', $data);

        $this->assign('rules', D('AuthRule')->getRules());
        //把rule转换为 数组
        $this->assign('arr_rules', explode(',', $data['rules']));
        $this->display('form');
    }

    //查看
    public function view($id) {
        $this->assign('data', D($this->model)->find($id));
        $this->display();
    }

}
