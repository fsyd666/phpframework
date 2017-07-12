<?php

use yii\helpers\Html;
use app\modules\admin\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员管理';
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
                <?= Html::a('<i class="icon-remove"></i>删除', ['delete'], ['class' => 'btn btn-default', 'id' => 'removeAll']) ?>                          
            </div>
        </div>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'app\modules\admin\components\SelectColumn'],
                ['attribute' => 'id', 'options' => ['width' => 80]],
                'username',
                'nickname',
                [
                    'attribute' => 'status',
                    'value' => function($data) {
                        return $data->status == 1 ? '正常' : '禁用';
                    }
                ],
                'last_time:datetime',
                'last_ip',
                'addtime',
                ['class' => 'app\modules\admin\components\ActionColumn'],
            ],
        ]);
        ?>
    </div>
</div>