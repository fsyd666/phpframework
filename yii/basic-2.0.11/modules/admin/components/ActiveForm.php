<?php

namespace app\modules\admin\components;

class ActiveForm extends \yii\widgets\ActiveForm {

    public $fieldClass = 'app\modules\admin\components\ActiveField';
    
    public $options = ['class' => 'form-horizontal'];
    
    public $fieldConfig = [
        'template' => "{label}\n<div class=\"col-sm-5\">{input}</div>\n<div class=\"col-sm-3\">{hint}{error}</div>\n",
        'labelOptions' => ['class' => 'col-sm-1 control-label'],
        'hintOptions' => ['class' => 'hint-help'],
    ];

}
