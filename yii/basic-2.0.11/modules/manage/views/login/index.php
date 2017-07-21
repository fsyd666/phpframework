<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->registerJsFile('@web/backend/js/menu.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerCssFile('@web/backend/css/login.css', ['depends' => 'yii\bootstrap\BootstrapAsset']);
$this->registerCssFile('@web/lib/font-awesome/css/font-awesome.min.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>后台管理登录</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <?php $this->head() ?>
    </head>
    <body style="background-image:url(<?= Url::to('@web/backend/images/bg4_1920x1200.jpg') ?>)">
        <?php $this->beginBody() ?>
        <div class="page-container">
            <div class="main_box">
                <div class="login_box">
                    <div class="login_logo">
                        <img src="<?= Url::to('@web/backend/images') ?>/logo.png" >
                    </div>
                    <div class="login_form">
                        <?php
                        $form = ActiveForm::begin([
                                    'action' => ['index'],
                                    'fieldConfig' => [
                                        'labelOptions' => ['class' => 't', ''],
                                        'inputOptions' => ['class' => 'form-control x319 in']
                                    ]
                        ]);
                        ?>       
                        <?= $form->field($model, 'username')->textInput()->label('帐　号：'); ?>
                        <?= $form->field($model, 'password')->passwordInput()->label('密　码：') ?>
                        <?=
                        $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                            'captchaAction' => Url::to(['login/captcha']),
                            'template' => '{input}&nbsp;&nbsp;&nbsp;&nbsp;{image}',
                            'imageOptions' => ['title' => '点击刷新'],
                            'options' => ['class' => 'form-control x164 in']
                        ])->label('验证码：')
                        ?>       
                        <?= $form->field($model, 'rememberMe')->checkbox()->label('') ?>
                        <div class="form-group space">
                            <label class="t"></label>　　　
                            <input type="submit"  id="submit_btn" 
                                   class="btn btn-primary btn-lg" value="&nbsp;登&nbsp;录&nbsp" />
                            <input type="reset" value="&nbsp;重&nbsp;置&nbsp;" class="btn btn-default btn-lg">
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>        
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>