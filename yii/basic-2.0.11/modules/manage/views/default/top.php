<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerCssFile('@web/lib/font-awesome/css/font-awesome.min.css', ['depends' => 'yii\bootstrap\BootstrapAsset']);
$this->registerCss(
        '.header {height: 45px;	background: #1f262e;color: white;line-height: 48px;padding:0 20px;}
    .message a{position: relative;font-size: 18px;margin-left:30px;color:#8a8a8a !important;}
    .message a:hover{text-decoration:none;}
    .badge {background: #e02222;position: absolute;left: -15px;top: -8px;font-size: 12px;font-weight:100;}
    .username{color:white;font-size:14px;position:relative;top:-3px;}
    .pull-left a{color: rgb(255, 255, 255); font-weight: bold; font-size: 26px; text-shadow: 0px 1px 1px rgb(79, 101, 199);}
    .pull-left sup{font-size: 14px; top: -0.75em; margin-left: 4px;}
    .pull-left a:hover{text-decoration: none;}'
);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="header">
            <div class="pull-left"><a class="brand" href="/" target="_blank"> 后台系统<sup>V3.0</sup> </a></div>
            <div class="pull-right message">        
                <a href="/AdminMsg/index" target="mainFrame" title="最新消息">
                    <?php if (isset($msg)): ?>
                        <span class="badge">{$msg}</span>
                    <?php endif; ?>
                    <i class="icon-envelope"></i>
                </a>
                <a href="/Setting/clear_cache" target="mainFrame" title="刷新缓存"><i class="icon-repeat"></i></a>
                <a href="<?= Url::to(['login/logout']) ?>" target="_top" title="退出登录"><i class="icon-off"></i></a>
                <a href="<?= Url::to(['default/myinfo']) ?>" id="user_menu" target="mainFrame"> 
                    <img alt="" src="<?= Url::to('@web/backend/images/avatar.jpg'); ?>" width="30" height="30" style="margin-top:-6px;"> 
                    <span class="username"><?= $user->nickname ?></span>
                </a>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
