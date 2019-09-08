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
