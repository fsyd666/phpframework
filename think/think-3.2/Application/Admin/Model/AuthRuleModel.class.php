<?php

namespace Admin\Model;

use Think\Model;

class AuthRuleModel extends Model {
    
    protected $nostatus=true;

    public $_fields = array(
        //字段
        'id' => 'ID',
        'name' => '验证规则',
        'fid' => '所属菜单',
        'title' => '标题',
        'type' => '类型',
        'status' => '状态',
        'condition' => '附件条件',
        'is_left_menu' => '是否左侧菜单',
        'sort' => '排序',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array();

    public function getMenuRules() {
        $menu = D('Menu')->menu;
        $rule = null;
        foreach ($menu as $k => $v) {
            //根据ID查找有权访问的菜单规则
            $temp_item = $this->field('id,title')->where('fid = ' . $k)->select();
            if ($temp_item)
                $rule[] = array('name' => $v, 'item' => $temp_item);
        }
        return $rule;
    }

    public function getRules() {
        //查找所有 index
        $top = $this->field('id,name,title')->where("name LIKE '%/index'")->select();
        foreach ($top as $k => &$v) {
            $ctrl_name = str_replace('index', '', $v['name']);
            $v['item'] = $this->where("name LIKE '$ctrl_name%' AND id <> {$v['id']}")->select();
        }
        return $top;
    }

}
