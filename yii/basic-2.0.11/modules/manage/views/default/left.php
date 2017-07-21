<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile('@web/backend/js/menu.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerCssFile('@web/backend/css/left.css', ['depends' => 'yii\bootstrap\BootstrapAsset']);
$this->registerCssFile('@web/lib/font-awesome/css/font-awesome.min.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <nav class="sidebar-nav">
            <ul id="menu">
                <li class="active">
                    <a href="main" id="home" target="mainFrame"> 
                        <i class="icon-home"></i> 
                        <span class="title">首页</span> 
                        <span class="selected"></span></a> 
                </li>

                <?php if (is_array($data)) foreach ($data as $v) { ?>
                        <li> <a href="#"> <i class="<?= $v['icon'] ?>"></i> <span class="title"><?= $v['name'] ?></span> 
                                <i class="icon-angle-left arrow"></i></a>
                            <ul class="sub-menu">
                                <?php
                                foreach ($v['child'] as $v2) {
                                    echo '<li>' . Html::a($v2['name'], [$v2['route']], ['target' => 'mainFrame']) . '</li>';
                                }
                                ?>
                            </ul>
                        </li>
                    <?php } ?>

            </ul>
        </nav>
        <div class="left-footer">2016 © Admin by Yii.</div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>