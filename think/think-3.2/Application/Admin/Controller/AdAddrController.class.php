<?php

/**
 * 广告位控制器
 */

namespace Admin\Controller;

use Think\Controller;

class AdAddrController extends CommonController {

    public $model = 'AdAddr';

    function _initialize() {
        parent::_initialize();
        $this->assign('type', D($this->model)->_type);
    }

    //列表
    public function index() {
        if (!empty($_GET['stype']) && !empty($_GET['skey'])) {
            $stype = $_GET['stype'];
            $sval = $_GET['skey'];
            $param['where'] = "$stype like '%$sval%'";
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
                ->assign('data', $m->find($id));

        $this->display('form');
    }

    //查看
    public function view($id) {
        $this->assign('data', D($this->model)->find($id));
        $this->display();
    }

    //Excel导入会员
    function toExcel() {
        $m = D($this->model);
        $data['title'] = array(
            'id' => 'Id',
            'name' => '名称',
        );
        $data['data'] = $m->field(array_keys($data['title']))->select();
        $this->data2excel($data, 'AdAddr');
    }

    //从Excel导入
    function fromExcel() {
        $file = $this->uploadExcelFile('excel_file');
        $field_key = array(
            'A' => 'id',
            'B' => 'name',
        );
        $signature = array(
            'A1' => 'Id',
            'B1' => '名称'
        );
        $this->excel2data($file, $field_key, $this->model, $signature);
    }

}
