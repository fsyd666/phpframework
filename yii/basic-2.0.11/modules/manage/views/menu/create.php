<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\models\Menu */

$this->title = '菜单管理';
?>
<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="icon-home"></i>主页</a>', "@web/" . $this->context->module->id, ["target" => "_top"]) ?></li>
        <li><?= Html::a($this->title, ["index"]) ?></li>
        <li class="active">添加</li>
    </ol>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?> - 添加内容</div>
    <div class="panel-body">
        <?=
        $this->render('_form', [
            'model' => $model,
            'pers' => $pers,
        ])
        ?>
    </div>
</div>
