<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Menu;
use app\modules\admin\models\Admin;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends CommonController {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->renderPartial('index');
    }

    public function actionLeft() {
        $this->view->title = "菜单";
        //查询菜单
        $menu = new Menu();
        return $this->renderPartial('left', ['data' => $menu->getMenu()]);
    }

    public function actionTop() {
        $user = \Yii::$app->admin->identity;
        return $this->renderPartial('top', ['user' => $user]);
    }

    public function actionMain() {
        $user = \Yii::$app->admin->identity;
        return $this->render('main', ['user' => $user]);
    }

    public function actionMyinfo() {
        $model = Admin::findone(\Yii::$app->admin->identity->id);

        $model->scenario = 'myinfo';
        $oldpwd = $model->password;

        $req = \Yii::$app->request;
        if ($req->isPost) {
            $post = $req->post('Admin');
            if (md5($post['oldpwd']) != $oldpwd) {
                $this->error('原密码错误');
            } else {
                $model->password = md5($post['password']);
                $model->nickname = $post['nickname'];
                if ($model->save(false)) {
                    return $this->redirect(['login/logout']);
                } else {
                    $this->error('修改失败');
                }
            }
        }

        $model->password = '';
        return $this->render('myinfo', ['model' => $model]);
    }
    
    public function actionError(){
        return $this->renderContent('404');
    }

}
