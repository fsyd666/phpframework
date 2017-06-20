<?php

/**
 * 配置控制器
 */

namespace Admin\Controller;

use Think\Controller;

class ConfigController extends CommonController {

    public $model = 'Config';

    //列表
    public function index() {
        if (!empty($_GET['stype'])) {
            $stype = $_GET['stype'];
            switch ($stype) {
                default :
                    $where = "$stype like '%{$_GET['skey']}%'";
            }
            $list = D($this->model)->where($where)->select();
        } else {
            $list = D($this->model)->select();
        }
        $this->assign('list', $list);
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
        $this->assign('data', array('type' => 1));
        $this->display('form');
    }

    //编辑
    public function edit($name) {
        $m = D($this->model);
        if (IS_POST) {
            if (!$m->create()) {
                $this->error($m->getError());
            }
            if (false !== $m->save()) {
                $this->success('修改成功', 'index');
            } else {
                $this->error('修改失败');
            }
        }
        $this->assign('action_name', '修改')
                ->assign('data', $m->find($name));
        $this->display('form');
    }

    //编辑
    public function editval() {
        $m = D($this->model);
        if (IS_POST) {
            $flag = true;
            foreach ($_POST['val'] as $k => $v) {
                if (false === $m->where("name='{$_POST['name'][$k]}'")->save(array('val' => $v))) {
                    $flag = false;
                }
            }
            if ($flag) {
                exit('y');
            } else {
                exit('修改失败');
            }
        }
    }

}
