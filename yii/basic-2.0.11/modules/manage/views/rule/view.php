<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\models\AuthRule */

$this->title = '规则管理';
?>

<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?= Html::a("<i class=\"icon-home\"></i>主页</a>", "@web/" . $this->context->module->id, ["target" => "_top"]) ?></li>
        <li><?= Html::a($this->title, ["index"]) ?></li>
        <li class="active">详情页</li>
    </ol>
</div>

<div class="data-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'data:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ])
    ?>
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->name], ['class' => 'btn btn-info']) ?>
        <?=
        Html::a('删除', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '是否真的要删除此项数据？',
                'method' => 'post',
            ],
        ])
        ?>

        <?= Html::a('返回', 'javascript:history.back()', ['class' => 'btn btn-default']) ?>
    </p>
</div>
