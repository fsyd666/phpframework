<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AdminAsset;
use yii\bootstrap\Alert;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

        <?php
        if (Yii::$app->getSession()->hasFlash('error')) {
            echo Alert::widget([
                'options' => [
                    'class' => 'alert alert-danger',
                ],
                'body' => Yii::$app->getSession()->getFlash('error'),
            ]);
        } else if (Yii::$app->getSession()->hasFlash('success')) {
            echo Alert::widget([
                'options' => [
                    'class' => 'alert alert-success',
                ],
                'body' => Yii::$app->getSession()->getFlash('success'),
            ]);
        }
        ?>

        <?php $this->beginBody(); ?>
        <?= $content ?>
        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
