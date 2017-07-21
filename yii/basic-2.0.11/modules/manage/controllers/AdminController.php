<?php

namespace app\modules\manage\controllers;

use Yii;
use app\modules\manage\models\Admin;
use app\modules\manage\models\AdminSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\manage\models\AuthItem;

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

        //ajax验证用户名
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->auth_key = md5(uniqid());
            $model->password = md5($model->password);
            $model->access_token = md5(time());
            if ($model->save()) {
                if (false != ($role = Yii::$app->authManager->getRole($model->role_name))) {
                    Yii::$app->authManager->assign($role, $model->id);
                }

                return $this->redirect(['index']);
            } else {
                $this->error('添加失败!');
            }
        }

        $roles = (new AuthItem())->getRoles();

        return $this->render('create', [
                    'model' => $model,
                    'roles' => $roles,
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
        //场景  只需要 在model的rules里设置 然后再这里设置
        $model->scenario = 'update';
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (trim($post['Admin']['password']) == '') {
                unset($post['Admin']['password']);
            } else {
                $post['Admin']['password'] = md5($post['Admin']['password']);
            }
            if ($model->load($post) && $model->save()) {
                if (false != ($role = $auth->getRole($model->role_name))) {
                    //移除所有，重新添加
                    $auth->revokeAll($model->id);
                    $auth->assign($role, $model->id);
                }
                return $this->redirect(['index']);
            }
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
