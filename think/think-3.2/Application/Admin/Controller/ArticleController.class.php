<?php

/**
 * sf控制器
 */

namespace Admin\Controller;

use Think\Controller;

class ArticleController extends CommonController {

    public $model = 'Article';
    protected $moduleid = 1;
    private $teach = null;

    public function _initialize() {
        parent::_initialize();

        $this->teach = D('Teacher')->getField('id,name');

        $this->assign('tid', $this->teach);
        $this->assign('cid', D('Category')->getField('id,name'));
        $this->assign('auth', D('MemGroup')->getAuth());
        $this->assign('_type', D($this->model)->_type);
        $this->assign('recommend', D('Recommend')->_fields);
    }

    //列表
    public function index() {
        if (!empty($_GET['stype'])) {
            $stype = $_GET['stype'];
            switch ($stype) {
                case 'tid':
                    $param['where'] = "$stype = {$_GET['tid']}";
                    break;
                case 'cid':
                    $param['where'] = "$stype = {$_GET['cid']}";
                    break;
                case 'type':
                    $param['where'] = "$stype = {$_GET['type']}";
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
            //判断所选的栏目是否是最底 栏目
            $cid = $_POST['cid'];
            if (D('Category')->where("fid=$cid")->find()) {
                $this->error("请不要在父栏目中直接添加内容！");
            }
            $m = D($this->model);

            $_POST['desc'] = $_POST['desc'] ? $_POST['desc'] : strip_tags_ext($_POST['content'], 120);

            if (!$m->create()) {
                $this->error($m->getError());
            }
            //老师名字
            if ($_POST['tid']) {
                $m->tname = $this->teach[I('tid')];
            }
            //作者
            $m->author = $this->user('nickname');
            if ($id = $m->add()) {
                if (D('ArtContent')->add(array('artid' => $id, 'content' => $_POST['content']))) {
                    $this->success('添加成功');
                } else {
                    $this->error("添加出错");
                }
            } else {
                $this->error('添加失败');
            }
        }
        //获取模型对应的栏目
        $this->assign('cid', D('Category')->getListFromModule($this->moduleid));

        $this->assign('action_name', '添加');
        //带有checkbox的默认值  1默认是开 0默认是关闭
        $this->assign('data', array(
            'type' => 1,
            'status' => 1,
            'cid' => $_GET['cid'],
            'hits' => rand(100, 200),
            'zan_num' => rand(100, 200),
            'col_num' => rand(100, 200),
            'com_num' => rand(100, 200),
        ));
        $this->display('form');
    }

    //编辑
    public function edit($id) {
        $m = D($this->model);
        if (IS_POST) {

            $cid = $_POST['cid'];
            if (D('Category')->where("fid=$cid")->find()) {
                $this->error("请不要在父栏目中直接添加内容！");
            }

            $_POST['desc'] = $_POST['desc'] ? $_POST['desc'] : strip_tags_ext($_POST['content'], 120);

            if (!$m->create()) {
                $this->error($m->getError());
            }

            if ($_POST['tid']) {
                $m->tname = $this->teach[I('tid')];
            }

            if (false !== $m->save()) {
                if (false !== D('ArtContent')->where("artid=" . I('id'))->save(array('content' => $_POST['content'])))
                    $this->success('修改成功', cookie('edit_prev_url'));
            } else {
                $this->error('修改失败');
            }
        }
        //获取模型对应的栏目
        $this->assign('cid', D('Category')->getListFromModule($this->moduleid));
        $data = $m->find($id);
        $data['content'] = D('ArtContent')->where("artid=$id")->getField('content');
        $this->assign('action_name', '修改')
                ->assign('data', $data);
        $this->display('form');
    }

    //查看
    public function view($id) {
        $data = D($this->model)->find($id);
        $cont = D('ArtContent')->find($id);
        $data['content'] = $cont['content'];
        $this->assign('data', $data);
        $this->display();
    }

}
