<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Admin;
use app\modules\admin\models\AdminSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\AuthItem;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends CommonController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Admin();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post())) {
            //ajax验证用户名
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\bootstrap\ActiveForm::validate($model);
            }

            $model->auth_key = md5(uniqid());
            $model->pwd = md5($model->pwd);
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return 'aaa';
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $auth = Yii::$app->authManager;

        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (false != ($role = $auth->getRole($model->role_name))) {
                $auth->assign($role, $model->id);
            }
            return $this->redirect(['index']);
        } else {
            //获取角色
            $roles = (new AuthItem())->getRoles();
            $model->role_name = key($auth->getRolesByUser($model->id));  //获取第一个数组的 键名
            return $this->render('update', [
                        'model' => $model,
                        'roles' => $roles,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = []) {
        $ids = Yii::$app->request->post('id');
        if (is_array($ids)) {
            if (Admin::deleteAll(['in', 'id', $ids])) {
                return $this->ajaxReturn(true);
            } else {
                return $this->ajaxReturn(false, '删除失败');
            }
        } else {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
