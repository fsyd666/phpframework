<?php

/**
 * 后台用户控制器
 */

namespace Admin\Controller;

use Think\Controller;

class AdminController extends CommonController {

    public $model = 'Admin';

    //列表
    public function index() {
        if (!empty($_GET['stype']) && !empty($_GET['skey'])) {
            $stype = $_GET['stype'];
            $sval = $_GET['skey'];
            $param['where'] = "$stype like '%$sval%' AND id > 1";
            $list = D($this->model)->where($param['where'])->select();
        } else {
            $list = D($this->model)->where('id>1')->select();
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
            if (false != $id = $m->add()) {
                //保存用户组信息
                foreach ($_POST['group_id'] as $v) {
                    $group_list[] = array('uid' => $id, 'group_id' => $v);
                }
                if (D('AuthGroupAccess')->addAll($group_list)) {
                    $this->success('添加成功');
                } else {
                    $this->error('分配管理组失败');
                }
            } else {
                $this->error('添加失败');
            }
        }
        $this->assign('action_name', '添加');
        //带有checkbox的默认值  1默认是开 0默认是关闭
        $this->assign('data', array('status' => 1));

        //用户组
        $this->assign('group', D('AuthGroup')->field('id,title')->select());
        $this->display();
    }

    //编辑
    public function edit($id) {
        $m = D($this->model);
        if (IS_POST) {
            if (!$m->create()) {
                $this->error($m->getError());
            }
            //如果有修改密码
            if (trim($_POST['pwd'])) {
                $m->pwd = md5(trim($_POST['pwd']));
            }

            if (false !== $m->save()) {
                if ($_POST['change_group'] == 1) {//修改组
                    $mg = D('AuthGroupAccess');
                    $mg->where("uid={$_POST['id']}")->delete(); //删除
                    //禁止自己修改 所属用户组*************************
                    if ($this->user() != $_POST['id']) {
                        foreach ($_POST['group_id'] as $v) {
                            $group_list[] = array('group_id' => $v, 'uid' => $_POST['id']);
                        }
                        if (!$mg->addAll($group_list))//添加
                            $this->error('修改用户组失败');
                    }//********************************************/
                }
                $this->success('修改成功', cookie('edit_prev_url'));
            } else {
                $this->error('修改失败');
            }
        }
        $this->assign('action_name', '修改')
                ->assign('data', $m->find($id))
                ->assign('has_group', D('AuthGroupAccess')->where("uid=$id")->getField('group_id', true))//拥有的组                
                ->assign('group', D('AuthGroup')->field('id,title')->select()); //用户组


        $this->display();
    }

    //编辑
    public function edit_pwd() {
        $m = D($this->model);
        if (IS_POST) {
            if (!$m->create()) {
                $this->error($m->getError());
            }

            //如果修改了密码
            if (!empty($_POST['oldpwd'])) {
                $tmp_data = $m->find($this->user());
                if ($tmp_data['pwd'] != md5(trim($_POST['oldpwd']))) {
                    $this->error('原始密码错误');
                } else {
                    $m->pwd = md5($_POST['newpwd']);
                }
            }

            if (false !== $m->save()) {
                if ($_POST['change_group'] == 1) {//修改组
                    $mg = D('AuthGroupAccess');
                    $mg->where("uid={$_POST['id']}")->delete(); //删除
                    foreach ($_POST['group_id'] as $v) {
                        $group_list[] = array('group_id' => $v, 'uid' => $_POST['id']);
                    }
                    if (!$mg->addAll($group_list))//添加
                        $this->error('修改用户组失败');
                }
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
        }
        $this->assign('action_name', '修改')
                ->assign('data', $m->find($this->user()))
                ->assign('has_group', D('AuthGroupAccess')->where(['uid' => $this->user()])->getField('group_id', true))//拥有的组
                ->assign('group', D('AuthGroup')->field('id,title')->select()); //用户组

        $this->display();
    }

    //查看
    public function view($id) {
        $this->assign('data', D($this->model)->find($id));
        $this->display();
    }

    //删除 包含单个和多个
    public function remove() {
        if (IS_AJAX) {
            $map['id'] = array('IN', $_POST['ids']);
            if (D($this->model)->where($map)->delete()) {
                $where['uid'] = array('IN', $_POST['ids']);
                D('AuthGroupAccess')->where($where)->delete();
                $this->success("删除成功");
            } else {
                $this->error("删除失败");
            }
        } else {
            if (D($this->model)->delete(I('id'))) {
                D('AuthGroupAccess')->where("uid=" . I('id'))->delete();
                $this->redirect('index');
            } else {
                $this->error('删除失败');
            }
        }
    }

    //验证用户名是否可用户
    function chkuser() {
        if (false !== stripos($_POST["param"], 'admin')) {
            $this->ajaxReturn(array('status' => 'n', 'info' => '用户不能含admin字样'));
        } else if (D($this->model)->where("user = '{$_POST["param"]}'")->find()) {
            $this->ajaxReturn(array('status' => 'n', 'info' => '用户名已经存在'));
        } else {
            $this->ajaxReturn(array('status' => 'y'));
        }
    }

}
