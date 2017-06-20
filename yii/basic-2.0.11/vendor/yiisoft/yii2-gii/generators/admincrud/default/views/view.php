<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = '<?= $generator->title . '管理' ?>';

?>

<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?= '<?= Html::a("<i class=\"icon-home\"></i>主页</a>", "@web/" . $this->context->module->id, ["target" => "_top"]) ?>' ?></li>
        <li><?= '<?= Html::a($this->title, ["index"]) ?>' ?></li>
        <li class="active">详情页</li>
    </ol>
</div>

<div class="data-view">

    <?= "<?= " ?>DetailView::widget([
    'model' => $model,
    'attributes' => [
    <?php
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            echo "            '" . $name . "',\n";
        }
    } else {
        foreach ($generator->getTableSchema()->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
    ?>
    ],
    ]) ?>
    <p>
        <?= "<?= " ?>Html::a('修改', ['update', <?= $urlParams ?>], ['class' => 'btn btn-info']) ?>
        <?= "<?= " ?>Html::a('删除', ['delete', <?= $urlParams ?>], [
        'class' => 'btn btn-danger',
        'data' => [
        'confirm' => <?= $generator->generateString('是否真的要删除此项数据？') ?>,
        'method' => 'post',
        ],
        ]) ?>

        <?= "<?= " ?>Html::a('返回', 'javascript:history.back()', ['class' => 'btn btn-default']) ?>
    </p>
</div>
