<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * 角色管理
 */
class RoleController extends CommonController {

    private $_type = 1;

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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find()->where(['type' => $this->_type]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AuthItem();

        $model->type = $this->_type;

        if ($model->load(Yii::$app->request->post()) && $model->addRole()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
                    'model' => $model,
                    'pers' => $this->getPermissions(),
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->updateRole()) {
            return $this->redirect(['index']);
        } else {
            //获取child的数据
            $rows = (new \yii\db\Query())
                    ->select(['child'])
                    ->from('auth_item_child')
                    ->where(['parent' => $model->name])
                    ->all();
            $childs = ArrayHelper::getColumn($rows, 'child');
            return $this->render('update', [
                        'model' => $model,
                        'pers' => $this->getPermissions(),
                        'childs' => $childs
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getPermissions() {
        $pers = Yii::$app->authManager->getPermissions();
        foreach ($pers as $v) {
            list($key, $name) = explode('/', $v->name);
            $desc = $v->description ? $v->description : $v->name;
            if ($name == 'index') {
                $data[$key] = [$v->name => $desc] + $data[$key];
            } else {
                $data[$key][$v->name] = $desc;
            }
        }
        return $data;
    }

}
