<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
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
