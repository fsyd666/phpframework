<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionTest() {
        return $this->renderContent('测试内容');
    }

}
