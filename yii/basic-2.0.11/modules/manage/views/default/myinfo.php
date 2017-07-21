<?php

use yii\helpers\Html;
use app\modules\manage\components\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\models\Admin */

$this->title = '修改个人信息';
?>
<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="icon-home"></i>主页</a>', "@web/" . $this->context->module->id, ["target" => "_top"]) ?></li>
        <li><?= Html::a($this->title, ["index"]) ?></li>
        <li class="active">修改</li>
    </ol>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?> - 修改管理员</div>
    <div class="panel-body">
        <div class="admin-form">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'oldpwd')->passwordInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'repwd')->passwordInput() ?>

            <?= $form->field($model, 'nickname')->textInput() ?>

            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                    <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-success']) ?>
                    <button type="reset" class="btn btn-default">重置</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
