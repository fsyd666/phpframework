<?php

return array(
//'配置项'=>'配置值'
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
        '/^gather\/(\d{6,8})/i' => 'gather/index?day=:1',
        'gather/jiedu/:jiedu' => 'gather/jiedu',
        'novice/index/:id' => 'novice/index',
        'live/art/:id' => 'live/art', //文章
        'live/ved/:id' => 'live/ved', //视频
        'live/show/:id' => 'live/show', //直播
    ),
    //静态缓存
//    'HTML_CACHE_ON' => true,
    'HTML_CACHE_TIME' => 60,
    'HTML_CACHE_RULES' => array(
        'index:hangqing' => array('index/hangqing/{type}'),
        'live:zhixun' => array('index/zhixun/{day}', 36000),
        'live:index' => array('live/index', 30),
    )
);
