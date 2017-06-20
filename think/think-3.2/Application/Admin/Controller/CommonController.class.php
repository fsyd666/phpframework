<?php

namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller {

    function _initialize() {
        //登录状态验证
        if (!$this->user()) {
            $this->redirect('Login/index');
        }
        //Auth 验证
        $auth = new \Think\Auth();
        $auth_name = strtolower(CONTROLLER_NAME) . '/' . strtolower(ACTION_NAME);
        //超级管理员不用验证       
        //如果是首页直接跳过验证
        if ($this->user() != 1 &&
                !in_array(strtolower(CONTROLLER_NAME), C('NO_AUTH_CTROLLER')) &&
                !in_array(strtolower($auth_name), C('NO_AUTH_ACTION')) &&
                !$auth->check($auth_name, $this->user())) {
            $this->error('您无权限访问');
        }
    }

    protected function user($key = 'id') {
        return $_SESSION['admin'][$key];
    }

    //重载success函数
    protected function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
        exit;
    }

    protected function page($model, $param = array(), $status = false) {
        $_param = array(
            'where' => 1, //查询条件
            'order' => 'id desc', //排序
            'relation' => false, //关联模型
            'rows' => 10
        );
        $param = array_merge($_param, $param); //获得最新参数

        if (!$status) {
            if (is_string($param['where']) || is_numeric($param['where'])) {
                $param['where'] = array('_string' => $param['where']);
            }
            $param['where']['status'] = 'no';
        }
        $count = $model->where($param['where'])->count();
        $Page = new \Think\Page($count, $param['rows']);
        if ($param['relation']) {//关联模型
            $list = $model->relation($param['relation'])->order($param['order'])->where($param['where'])->limit($Page->firstRow . ',' . $Page->listRows)->select();
        } else {
            $list = $model->order($param['order'])->where($param['where'])->limit($Page->firstRow . ',' . $Page->listRows)->select();
        }

        //var_dump($model->getLastSql());
        $Page->setConfig('header', '共 %TOTAL_ROW% 条记录 共%TOTAL_PAGE%页');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('first', '第一页');
        $Page->lastSuffix = FALSE;
        $Page->setConfig('last', '末页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $this->assign('show', $Page->show());
        return $list;
    }

    //删除 包含单个和多个
    public function remove() {
        if (IS_AJAX) {
            $map['id'] = array('IN', $_POST['ids']);
            if (D($this->model)->where($map)->delete()) {
                $this->success("删除成功");
            } else {
                $this->error("删除失败");
            }
        } else {
            if (D($this->model)->delete(I('id'))) {
                $this->redirect('index');
            } else {
                $this->error('删除失败');
            }
        }
    }

    //更新排序
    public function resort() {
        if (IS_AJAX) {
            $m = D($this->model);
            foreach ($_POST['ids'] as $k => $v) {
                $map['id'] = $v;
                $data['sort'] = $_POST['val'][$k];
                if (false === $m->where($map)->save($data)) {
                    exit($m->getError());
                }
            }
            exit('y');
        }
    }

    //更改状态
    public function changeStatus() {
        if (IS_AJAX) {
            $data['status'] = I('get.status');
            $map['id'] = array('IN', $_POST['ids']);
            if (FALSE !== D($this->model)->where($map)->save($data)) {
                exit('y');
            } else {
                echo D($this->model)->_sql(); //'更新失败';
            }
        }
    }

    /**
     * 上传Excel文件
     * @param type $file_update  上传文件input 的 name
     * @return string
     */
    protected function uploadExcelFile($file_update) {
        $upload = new \Think\Upload(); // 实例化上传类    
        $upload->maxSize = 3145728; // 设置附件上传大小    
        $upload->exts = array('xls', 'xlsx'); // 设置附件上传类型
        $upload->savePath = 'Excel/'; // 设置附件上传目录 
        $upload->subName = '';
        $info = $upload->uploadOne($_FILES[$file_update]);  // 上传文件 
        if (!$info) {// 上传错误提示错误信息        
            $this->error($upload->getError());
        };
        $file = 'Uploads/' . $info['savepath'] . $info['savename'];
        return $file;
    }

    protected function data2excel($data, $filename) {
        //导入PHPExcel
        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        //设置标题
        $i = 0;
        $asc = ord('A');
        foreach ($data['title'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue(chr($asc + $i++) . '1', $v);
        }
        $i = 0;
        $j = 2;
        foreach ($data['data'] as $v) {
            foreach ($v as $v2) {
                $objPHPExcel->getActiveSheet()->setCellValue(chr($asc + $i++) . $j, $v2);
            }
            $i = 0;
            $j++;
        }
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        //直接下载
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check = 0, pre-check = 0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="' . $filename . '_file.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    //从Excel到如数据到库
    protected function excel2data($file, $field_key, $model, $signature) {
        vendor("PHPExcel.PHPExcel");
        $reader = new \PHPExcel_Reader_Excel2007();
        if (!$reader->canRead($file)) {
            $reader = new \PHPExcel_Reader_Excel5();
            if (!$reader->canRead($file)) {
                $this->error('不是有效的Excel文件');
            }
        }
        $excel = $reader->load($file);
        $sheet = $excel->getSheet(0);
        //取得一共多少行
        $allRow = $sheet->getHighestRow();

        //导入数据开始
        $data = array();
        foreach ($signature as $k => $v) {
            if ($sheet->getCell($k)->getValue() != $v) {
                $this->error('文件模板格式错误');
            }
        }
        $m = D($model);
        for ($i = 2; $i <= $allRow; $i++) {
            foreach ($field_key as $k => $v) {
                $data[$v] = $sheet->getCell($k . $i)->getValue();
            }
            //添加信息
            if (false == $m->add($data)) {
                $err[] = '导入错误：Excel—第' . $i . '行';
            }
        }
        if (empty($err)) {
            $this->success('导入成功');
            exit;
        } else {
            var_dump($err);
        }
    }

}
