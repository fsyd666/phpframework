<?php

use yii\helpers\Html;
use app\modules\admin\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员管理';

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
                <?= Html::a('<i class="icon-plus"></i>添加',["create"],["class"=>"btn btn-success"])?>                
                <button type="button" to="__URL__/remove" class="btn btn-default" id="removeAll"><i class="icon-remove"></i>删除</button>
                <a href="__URL__/toExcel" onclick="return msg.confirm('确定要导出到Excel？', this)" class="btn btn-default"><i class="icon-signout"></i>导出到Excel</a>
            </div>
        </div>
                            <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

                        'id',
            'gid',
            'utype',
            'username',
            'mobile',
            // 'password',
            // 'encrypt',
            // 'nickname',
            // 'gender',
            // 'photo',
            // 'email:email',
            // 'qq',
            // 'status',
            // 'valid',
            // 'valid_date',
            // 'uid',
            // 'promote_url:url',
            // 'last_time',
            // 'last_ip',
            // 'reg_ip',
            // 'login_num',
            // 'addtime',
            // 'remark',
            // 'play_time:datetime',
            // 'from_url:url',
            // 'has_worker',
            // 'font_color',

            ['class' => 'app\modules\admin\components\ActionColumn'],
            ],
            ]); ?>
                    </div>
</div>