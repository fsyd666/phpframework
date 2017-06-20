<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\MemberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gid') ?>

    <?= $form->field($model, 'utype') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'encrypt') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'qq') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'valid') ?>

    <?php // echo $form->field($model, 'valid_date') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <?php // echo $form->field($model, 'promote_url') ?>

    <?php // echo $form->field($model, 'last_time') ?>

    <?php // echo $form->field($model, 'last_ip') ?>

    <?php // echo $form->field($model, 'reg_ip') ?>

    <?php // echo $form->field($model, 'login_num') ?>

    <?php // echo $form->field($model, 'addtime') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'play_time') ?>

    <?php // echo $form->field($model, 'from_url') ?>

    <?php // echo $form->field($model, 'has_worker') ?>

    <?php // echo $form->field($model, 'font_color') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
