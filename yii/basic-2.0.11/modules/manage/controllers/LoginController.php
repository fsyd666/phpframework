<?php

namespace app\modules\manage\controllers;

use Yii;
use app\modules\manage\models\LoginForm;

class LoginController extends \yii\web\Controller {

    public function actionIndex() {
        if (!Yii::$app->admin->isGuest) {
            $this->redirect(['default/index']);
        }
        $model = new LoginForm();
        //登录成功
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['default/index']);
        }
        return $this->renderPartial('index', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        $user = Yii::$app->admin;
        $user->logout();
        return $this->redirect($user->loginUrl);
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'height' => 32,
                'offset' => 10,
            ],
        ];
    }

}
