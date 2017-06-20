<style>
    .panel-primary>.panel-heading {
        color: #555;
        background-color: #EEEEEE;
        border-color: #aaa;
    }
    .panel-primary {
        border-color: #aaa;
    }
</style>
<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li class="active"><i class="icon-home"></i>Home</li>            
    </ol>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">我的状态</h3>
    </div>
    <div class="panel-body">
        <p>登陆者：<?= $user->user ?> , 用户昵称：<?= $user->nickname ?></p>
        <p>上次登录时间：<?= date('Y-m-d H:i:s', $user->last_time) ?>，登录IP:<?= $user->last_ip ?></p>            
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">最新内容</h3>
    </div>
    <div class="panel-body">
        <p>最新提问：{$q_num}</p>
        <p>诊断数量：{$z_num}</p>
        <p>服务器时间：{:date('Y-m-d H:i:s')}</p>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">服务器信息</h3>
    </div>
    <div class="panel-body">
        <p>服务器软件：<?= $_SERVER['SERVER_SOFTWARE'] ?></p>
        <p>服务器系统：<?= php_uname() ?></p>
        <p>服务器时间：<?= date('Y-m-d H:i:s') ?></p>
        <p>服务器IP：<?= $_SERVER['SERVER_ADDR'] ?></p>
        <p>PHP版本：<?= phpversion() ?></p>
        <p>MySQL版本：<?= Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION); ?></p>
        <p>全局变量：<?= ini_get('register_globals') ? '开启' : '关闭' ?><span class="help-block" style="display: inline;">(建议关闭)</p>
        <p>最大上传文件：<?= ini_get('post_max_size') ?></p>
    </div>
</div>
