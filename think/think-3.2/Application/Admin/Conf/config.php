<?php

return array(
    //'配置项'=>'配置值'
    'AUTH_CONFIG' => array(
        //'AUTH_TYPE'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'AUTH_USER' => 'admin',
    ),
    'NO_AUTH_CTROLLER' => array(//不进行认证的 控制器 注意是要小写
        'index',
    ),
    'NO_AUTH_ACTION' => array(//不进行认证的 方法 注意要是小写
        'setting/clear_cache',
        'admin/edit_pwd'
    ),    
);
