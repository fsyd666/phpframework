<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Menu;

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

}
