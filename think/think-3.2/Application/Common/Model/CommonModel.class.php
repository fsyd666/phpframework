<?php

namespace Common\Model;

use Think\Model;

/**
 * 基类 模型
 */
class CommonModel extends Model {

    protected $nostatus = false;

    //列表
    function getList($param) {
        $def = array(
            'where' => 1,
            'order' => 'id desc',
            'rows' => 10,
            'cache' => 60,
        );
        $param = array_merge($def, $param);
        $cache = $param['cache'] ? true : false;
        return $this->cache($cache, $param['cache'])->order($param['order'])->where($param['where'])->limit($param['rows'])->select();
    }

    function select($options = array()) {
        $this->setStatus();
        return parent::select($options);
    }

    function find($options = array()) {
        $this->setStatus();
        return parent::find($options);
    }

    function count() {
        $this->setStatus();
        return parent::count();
    }

    protected function setStatus() {
        if ($this->nostatus) {
            return $this->options['where'];
        }
        $where = $this->options['where'];
        if ($where['status'] == 'no') {
            unset($where['status']);
            $no_status = true;
        }
        if (in_array('status', $this->fields)) {
            if (strpos($where['_string'], 'status') === false && !$no_status && !isset($where['status'])) {
                $where['status'] = 1;
            }
        }
        $this->options['where'] = $where;
    }

}
