<?php

use yii\helpers\Html;
use app\modules\admin\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AuthRule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-rule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-default">重置</button>
        </div>        
    </div>

    <?php ActiveForm::end(); ?>

</div>
