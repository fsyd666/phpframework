<?php

namespace Admin\Model;

use Think\Model;

class AuthGroupModel extends Model {
    
     protected $nostatus=true;

    public $_fields = array(
        //字段
        'id' => 'ID',
        'title' => '组名称',
        'status' => '状态',
    );
    //自动验证
    protected $_validate = array();
    //自动完成
    protected $_auto = array(
         array('rules','paseRule',3,'callback'), 
    );
    protected function paseRule($data){
        return implode($data,',');
    }

}
