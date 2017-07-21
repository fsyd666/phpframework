<?php

use yii\helpers\Html;
use app\modules\manage\components\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单管理';
?>


<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="icon-home"></i>主页</a>', "@web/" . $this->context->module->id, ["target" => "_top"]) ?></li>
        <li><?= Html::a($this->title, ["index"]) ?></li>
        <li class="active">列表</li>
    </ol>
</div>

<div class="panel panel-default">    
    <div class="panel-body">
        <div class="box_header">
            <div class="btn-group pull-left">
                <?= Html::a('<i class="icon-plus"></i>添加', ["create"], ["class" => "btn btn-success"]) ?>               
            </div>
        </div>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                ['attribute' => 'parent', 'value' =>
                    function($model) {
                        return $model->parents[$model->parent];
                    }
                ],
                'name',
                'route',
                'order',
                ['class' => 'app\modules\manage\components\ActionColumn'],
            ],
        ]);
        ?>
    </div>
</div>