<?php

namespace app\modules\admin\components;

use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField {

    /**
     * 静态提示 如 user 
     * @param type $options
     * @return ActiveField
     */
    public function formStatic($options = []) {
        $options = array_merge(['class' => 'form-control-static'], $options);
        $this->adjustLabelFor($options);
        $value = isset($options['value']) ? $options['value'] : Html::getAttributeValue($this->model, $this->attribute);
        $this->parts['{input}'] = Html::tag('p', $value, $options);
        return $this;
    }

}
