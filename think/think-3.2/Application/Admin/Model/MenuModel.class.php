<?php

namespace Admin\Model;

use Think\Model;

/**
 * 定义菜单模型
 * 不使用数据库
 */
class MenuModel extends Model {

    public $menu = array(
        3 => '会员管理',
        7 => '内容管理',
        2 => '管理员管理',
        1 => '其他管理',
        8 => '专题管理',
        6 => '系统管理'
    );

    //获取菜单列表
    public function getMenu() {
        //保存到SESSION中       
        if (session('menu')) {
            return session('menu');
        } else {
            $m = M('auth_rule');
            $menu = null;
            $map['is_left_menu'] = 1;

            if ($_SESSION['admin']['id'] != 1) {
                //找出当前用户的所有权限  //超级管理员 排除在外
                $group = M('auth_group_access')->where("uid={$_SESSION['admin']['id']}")->getField('group_id', true); //获取组
                $tmp_map['id'] = array('IN', $group);
                $auth_rule = M('auth_group')->where($tmp_map)->getField('rules', true);
                $rules = array_unique(explode(',', implode(',', $auth_rule)));
                $map['id'] = array('IN', $rules);
            }

            foreach ($this->menu as $k => $v) {
                //根据ID查找有权访问的菜单规则
                $map['fid'] = $k;
                $temp_item = $m->field('name,title')->where($map)->order('sort desc')->select();
                if ($temp_item) {
                    $menu[] = array('name' => $v, 'item' => $temp_item);
                }
            }
            session('menu', $menu);
            return $menu;
        }
    }

}
