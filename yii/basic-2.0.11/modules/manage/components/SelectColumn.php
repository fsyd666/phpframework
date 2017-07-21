<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\manage\components;

use yii\helpers\Html;

/**
 * SerialColumn displays a column of row numbers (1-based).
 *
 * To add a SerialColumn to the [[GridView]], add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => 'namespace app\modules\manage\components\SelectColumn',
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SelectColumn extends \yii\grid\Column {

    /**
     * @inheritdoc
     */
    public $header = '<input id="selAll" type="checkbox" />';

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index) {
        return Html::checkbox('ids[]', false, ['value' => $key, 'class' => 'checkbox-sel']);
        $pagination = $this->grid->dataProvider->getPagination();
        if ($pagination !== false) {
            return $pagination->getOffset() + $index + 1;
        } else {
            return $index + 1;
        }
    }

}
