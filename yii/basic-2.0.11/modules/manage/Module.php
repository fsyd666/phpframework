<?php

namespace app\modules\manage;

/**
 * manage module definition class
 */
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\manage\controllers';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function bootstrap($app) {
        $app->getUrlManager()->suffix = '';
    }

    public function init() {

        parent::init();
        \Yii::configure($this, [
            'params' => [
                'noAuthPerm' => ['default/*',], //不验证的权限
            ],
        ]);

        // custom initialization code goes here
    }

}
