<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Member */

$this->title = '会员管理';

?>
<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?=Html::a('<i class="icon-home"></i>主页</a>', "@web/" . $this->context->module->id, ["target" => "_top"])?></li>
        <li><?=Html::a($this->title, ["index"])?></li>
        <li class="active">修改</li>
    </ol>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?> - 修改内容</div>
    <div class="panel-body">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </div>
</div>
