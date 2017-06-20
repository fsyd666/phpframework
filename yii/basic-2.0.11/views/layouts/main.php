<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=2.0,user-scalable=no" />
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        <meta content="telephone=no" name="format-detection" />
        <title><?= $this->title ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
