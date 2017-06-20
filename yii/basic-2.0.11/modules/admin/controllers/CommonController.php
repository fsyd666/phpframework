<?php

namespace app\modules\admin\controllers;

use yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `admin` module
 */
class CommonController extends Controller {

    public function init() {
        parent::init();
        if (Yii::$app->admin->isGuest) {
            $this->redirect([Yii::$app->admin->loginUrl]);
        }
    }

    //权限判断
    public function beforeAction($action) {
        $route = $this->id . '/' . $action->id;
        if (Yii::$app->admin->id == 1 || //超级管理员不做任何限制
                in_array($this->id . '/*', $this->module->params['noAuthPerm']) || //排除controller/*
                in_array($route, $this->module->params['noAuthPerm']) || //排除controller/action
                Yii::$app->admin->can($route)) {  //验证
            return parent::beforeAction($action);
        } else {
            throw new ForbiddenHttpException('您无权访问!');
        }
    }

    protected function error($msg) {
        Yii::$app->getSession()->setFlash('error', $msg);
    }

    protected function success($msg) {
        Yii::$app->getSession()->setFlash('success', $msg);
    }

    protected function ajaxReturn($status, $info = '操作成功') {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => $status, 'info' => $info];
    }

}
