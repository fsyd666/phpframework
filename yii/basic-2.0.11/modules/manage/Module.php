<?php

namespace app\modules\manage;

/**
 * manage module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\manage\controllers';
    public $layout = 'main';

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
