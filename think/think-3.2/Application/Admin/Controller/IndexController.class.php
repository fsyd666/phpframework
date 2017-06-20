<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends CommonController {

    public function index() {
        $this->display();
    }

    function left() {
        //菜单
        $this->assign('menu', D('Menu')->getMenu()); //权限菜单 
        $this->display();
    }

    function top() {
        $this->display();
    }

    function main() {
        $user = D('Admin')->find($this->user());
        $this->assign('user', $user);
        //最新提问
        $q_num = D('Question')->where('has_answer=0')->count();
        $z_num = D('Detection')->count();

        $this->assign('q_num', $q_num)
                ->assign('z_num', $z_num);
        $this->display();
    }

    public function add() {
        $this->display();
    }

    public function view() {
        $this->display();
    }

    public function lock() {
        $this->display();
    }

}
