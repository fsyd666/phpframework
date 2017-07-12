<?php

use yii\helpers\Html;
use app\modules\admin\components\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent')->dropDownList($model->parents,['prompt'=>'请选择']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'route')->dropDownList(ArrayHelper::map($pers, 'name', 'name'),['prompt'=>'请选择']) ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-default">重置</button>
        </div>        
    </div>

    <?php ActiveForm::end(); ?>

</div>
