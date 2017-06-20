<?php

namespace Admin\Model;

use Think\Model;

class AdminModel extends Model {

    protected $nostatus = true;
    
    public $_fields = array(
        //字段
        'id' => 'ID',
        'user' => '用户名',
        'pwd' => '密码',
        'nickname' => '昵称',
        'status' => '状态',
        'last_date' => '最后登录日期',
        'last_ip' => '最后登录IP',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array(
        array('pwd', 'md5', 1, 'function')
    );

}
