<?php

/**
 * 网站 内容信息 管理
 */

namespace Admin\Controller;

use Think\Controller;

class SettingController extends CommonController {

    //备份页面
    function back() {
        $back = new \Org\Util\DbBack;
        $this->assign('list', $back->getTables());
        $this->display();
    }

    //数据库备份 列表显示
    function showbackup() {
        $tmp = ShowDir('Database');     
        $files = array();
        foreach ($tmp as $k => $v) {
            if (strpos($v, '.bak')) {
                $files[$k]['filename'] = basename($v);
                $files[$k]['time'] = date('Y-m-d H:i:s', basename($v, '.bak'));
            }
        }
        array_multisort($files,SORT_DESC);
        $this->assign('list',$files);
        $this->display();
    }

    //备份数据库
    function backup() {
        $back = new \Org\Util\DbBack;
        if ($back->backup())
            $this->success('备份成功');
        else
            $this->error('备份失败');
    }

    //还原备份
    function restore($name) {
        //import("ORG.Util.DbBack");
        //$back = new DbBack();
        $back = new \Org\Util\DbBack;
        if ($back->restore($name))
            $this->success('还原成功');
    }

    //删除备份文件
    function delete($name) {
        @unlink('Database/' . $name);
        $this->redirect('Setting/showbackup');
    }

    //数据表优化
    function optimize() {
        $back = new \Org\Util\DbBack;
        $this->assign('list', $back->getTables());
        $this->display();
    }

    //优化保存
    function optimize_ok() {
        $back = new \Org\Util\DbBack;
        if ($_POST['tables']) {
            if ($back->optimize($_POST['tables']))
                $this->success('优化成功');
        } else
            $this->error('没有选择备份表');
    }

    //清除缓存
    function clear_cache() {
        delete_dir(CACHE_PATH);
        delete_dir(TEMP_PATH);
        delete_dir(DATA_PATH);
        session('menu', null);
        $this->success('更新缓存成功', 'javascript:history.back()');
    }
}

?>
