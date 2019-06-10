<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\manage\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
    <div class="form-group field-authitem-name required has-error">
        <label class="col-sm-1 control-label" for="authitem-name">权限</label>
        <div class="col-sm-10" id="id-auth-checkbox">
            <?php
            if (is_array($pers))
                foreach ($pers as $v) {
                    if (is_array($v)) {
                        echo Html::checkboxList('pers', isset($childs)?$childs:null, $v, ['class' => 'check-div']);
                    }
                }
            ?>
        </div>        
    </div>
    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-default">重置</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
