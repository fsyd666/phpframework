<?php

use yii\helpers\Html;
use app\modules\admin\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gid')->textInput() ?>

    <?= $form->field($model, 'utype')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'encrypt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([ '女' => '女', '男' => '男', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'valid')->textInput() ?>

    <?= $form->field($model, 'valid_date')->textInput() ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'promote_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reg_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'login_num')->textInput() ?>

    <?= $form->field($model, 'addtime')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'play_time')->textInput() ?>

    <?= $form->field($model, 'from_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'has_worker')->textInput() ?>

    <?= $form->field($model, 'font_color')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-default">重置</button>
        </div>        
    </div>

    <?php ActiveForm::end(); ?>

</div>
