<?php

namespace app\modules\manage\controllers;

use Yii;
use app\modules\manage\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\manage\models\AuthItemSearch;

/**
 * 路由管理
 */
class RouteController extends CommonController {

    private $_type = 2;

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
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
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

        if ($model->load(Yii::$app->request->post()) && $model->addPerm()) {
            return $this->redirect(['create']);
        }
        return $this->render('create', [
                    'model' => $model,
                    'routes' => $this->getNoAddPerm(),
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

        if ($model->load(Yii::$app->request->post()) && $model->updatePerm()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'routes' => $this->getNoAddPerm(),
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

    protected function getNoAddPerm() {
        $path = dirname(__FILE__);
        $files = scandir($path);
        $ignore = array('CommonController.php', 'DefaultController.php', 'LoginController.php','RuleController.php');
        $perms = AuthItem::find()->asArray()->where(['type' => 2])->indexBy('name')->all();
        $data=array();

        foreach ($files as $v) {
            if ($v == '.' || $v == '..' || in_array($v, $ignore)) {
                continue;
            }
            $str = file_get_contents($path . DIRECTORY_SEPARATOR . $v);
            preg_match_all('/class\s+(\w+)Controller|function\s+action(\w+)\(?/', $str, $match);
            foreach ($match[2] as $v2) {
                if ($v2) {
                    $name = strtolower($match[1][0] . '/' . $v2);
                    if (!$perms[$name]) {
                        $data[$name] = $name;
                    }
                }
            }
        }
        return $data;
    }

}
