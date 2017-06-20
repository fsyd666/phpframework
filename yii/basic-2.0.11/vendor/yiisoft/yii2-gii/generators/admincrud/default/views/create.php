<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = '<?= $generator->title.'管理' ?>';

?>
<div class="mybreadcrumb">
    <ol class="breadcrumb">
        <li><?='<?='?>Html::a('<i class="icon-home"></i>主页</a>', "@web/" . $this->context->module->id, ["target" => "_top"])?></li>
        <li><?='<?='?>Html::a($this->title, ["index"])?></li>
        <li class="active">添加</li>
    </ol>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><?= '<?='?> $this->title ?> - 添加<?= $generator->title ?></div>
    <div class="panel-body">
        <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
