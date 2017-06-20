<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Admin */

$this->title = '管理员管理';

?>

<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?= Html::a("<i class=\"icon-home\"></i>主页</a>", "@web/" . $this->context->module->id, ["target" => "_top"]) ?></li>
        <li><?= Html::a($this->title, ["index"]) ?></li>
        <li class="active">详情页</li>
    </ol>
</div>

<div class="data-view">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'user',
            'pwd',
            'auth_key',
            'nickname',
            'status',
            'last_time:datetime',
            'last_ip',
            'addtime',
    ],
    ]) ?>
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
        'confirm' => '是否真的要删除此项数据？',
        'method' => 'post',
        ],
        ]) ?>

        <?= Html::a('返回', 'javascript:history.back()', ['class' => 'btn btn-default']) ?>
    </p>
</div>