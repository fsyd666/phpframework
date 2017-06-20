<?php

namespace Gii\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function index() {
        //列出所有表
        $m = new \Think\Model();
        $db_name = C('DB_NAME');
        $temp_tables = $m->query("SHOW TABLES FROM $db_name");
        //把表转化为模型 名称
        foreach ($temp_tables as $v) {
            //截取前缀
            $temStr = str_replace(C('DB_PREFIX'), '', current($v));
            //转化为大写字符  移除_ 转化为大写 去除空格
            $tables[] = str_replace(' ', '', ucwords(str_replace('_', ' ', $temStr)));
        }
        $this->assign('tables', $tables);
        $m_menu = new \Admin\Model\MenuModel();
        $this->assign('menu', $m_menu->menu);
        $this->display();
    }

    function creat_model() {
        if (empty($_POST['model'])) {
            $this->error('模型名称不能为空');
        }
        $dir = $_POST['dir'];
        $model_name = $_POST['model'];
        $_fields = D($model_name)->getDbFields();
        ob_start();
        include(APP_PATH . 'Gii/Template/model.php');
        $output = ob_get_contents();
        ob_end_clean();
        file_put_contents(APP_PATH . $dir . '/Model/' . $model_name . 'Model.class.php', $output);
        $this->success('模型创建成功');
    }

    function creat_controll() {
        if (empty($_POST['model']) || empty($_POST['name']) || empty($_POST['title'])) {
            $this->error('信息没有填写完整');
        }
        //创建index.html
        $model = $_POST['model'];
        //判断模型是否创建了
        $m = null;
        if (class_exists('Common\\Model\\' . $model . 'Model')) {
            $m = D($model);
        } else if (class_exists('Admin\\Model\\' . $model . 'Model')) {
            $str_model_class = 'Admin\\Model\\' . $model . 'Model';
            $m = new $str_model_class;
        } else if (class_exists('Home\\Model\\' . $model . 'Model')) {
            $str_model_class = 'Home\\Model\\' . $model . 'Model';
            $m = new $str_model_class;
        } else {
            $this->error('请先创建模型(Model)');
        }

        $fields = $m->_fields;
        $title = $_POST['title'];
        $ctrl_name = $_POST['name'];

        $view_dir = APP_PATH . '/Admin/View/' . $ctrl_name;
        mkdir($view_dir);

        ob_start();
        include(APP_PATH . 'Gii/Template/list.php');
        $output = ob_get_contents();
        ob_end_clean();
        if (!file_put_contents($view_dir . '/index.html', $output)) {
            $this->error('创建index失败');
        }

        //创建add,edit页面
        ob_start();
        include(APP_PATH . 'Gii/Template/form.php');
        $output = ob_get_contents();
        ob_end_clean();
        if (!file_put_contents($view_dir . '/form.html', $output)) {
            $this->error('创建form失败');
        }
        //创建view页面
        ob_start();
        include(APP_PATH . 'Gii/Template/view.php');
        $output = ob_get_contents();
        ob_end_clean();
        if (!file_put_contents($view_dir . '/view.html', $output)) {
            $this->error('创建view失败');
        }


        //创建ctroller
        ob_start();
        include(APP_PATH . 'Gii/Template/controller.php');
        $output = ob_get_contents();
        ob_end_clean();
        if (!file_put_contents(APP_PATH . 'Admin/Controller/' . $ctrl_name . 'Controller.class.php', $output)) {
            $this->error('创建controller失败');
        }

        //添加规则到数据库
        $rules = array(
            array(
                'name' => $ctrl_name . '/' . 'index',
                'title' => $title . '管理',
                'is_left_menu' => 1,
                'fid' => $_POST['fid']
            ),
            array(
                'name' => $ctrl_name . '/' . 'add',
                'title' => $title . '添加',
                'is_left_menu' => 0,
                'fid' => $_POST['fid']
            ),
            array(
                'name' => $ctrl_name . '/' . 'edit',
                'title' => $title . '修改',
                'is_left_menu' => 0,
                'fid' => $_POST['fid']
            ),
            array(
                'name' => $ctrl_name . '/' . 'remove',
                'title' => $title . '删除',
                'is_left_menu' => 0,
                'fid' => $_POST['fid']
            ),
            array(
                'name' => $ctrl_name . '/' . 'view',
                'title' => $title . '查看',
                'is_left_menu' => 0,
                'fid' => $_POST['fid']
            )
        );
        $m = M('AuthRule');
        if (!$m->addAll($rules)) {
            $this->error('添加规则失败');
        }
        $this->success('控制器创建成功');
    }

    function chk_ctrl() {
        if (file_exists(APP_PATH . 'Admin/Controller/' . $_POST['name'] . 'Controller.class.php')) {
            exit ('y');
        } else {
            exit('n');
        }
    }
    function chk_model(){
        if (file_exists(APP_PATH . 'Admin/Model/' . $_POST['name'] . 'Model.class.php') || file_exists(APP_PATH . 'Common/Model/' . $_POST['name'] . 'Model.class.php')) {
            exit ('y');
        } else {
            exit('n');
        }
    }

}
