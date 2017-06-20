<?php

namespace app\modules\admin\components;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn {

    public $headerOptions = ['width' => '182'];
    public $header = '<a href="#">操作</a>';

    protected function initDefaultButtons() {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => '查看',
                    'class' => 'btn btn-success btn-xs',
                    'aria-label' => '查看',
                    'data-pjax' => '0',
                        ], $this->buttonOptions);
                return Html::a('<i class="icon-external-link"></i>' . $options['title'], $url, $options);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => '修改',
                    'aria-label' => '修改',
                    'class' => 'btn btn-info btn-xs',
                    'data-pjax' => '0',
                        ], $this->buttonOptions);
                return Html::a('<i class="icon-edit"></i>' . $options['title'], $url, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => '删除',
                    'aria-label' => '删除',
                    'data-confirm' => '是否要删除此条数据？',
                    'class' => 'btn btn-danger btn-xs',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                        ], $this->buttonOptions);
                return Html::a('<i class="icon-remove"></i>' . $options['title'], $url, $options);
            };
        }
    }

}
