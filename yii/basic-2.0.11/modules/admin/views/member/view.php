<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Member */

$this->title = '会员管理';

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
            'gid',
            'utype',
            'username',
            'mobile',
            'password',
            'encrypt',
            'nickname',
            'gender',
            'photo',
            'email:email',
            'qq',
            'status',
            'valid',
            'valid_date',
            'uid',
            'promote_url:url',
            'last_time',
            'last_ip',
            'reg_ip',
            'login_num',
            'addtime',
            'remark',
            'play_time:datetime',
            'from_url:url',
            'has_worker',
            'font_color',
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
