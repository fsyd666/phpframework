<?php

use yii\helpers\Url;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>后台管理系统</title>
        <link rel="shortcut icon" href="<?= Url::to('@web/favicon.ico') ?>" />
    </head>
    <frameset rows="45,*" cols="*" frameborder="no" border="0" framespacing="0">
        <frame src="<?php echo Url::to(['top']) ?>" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
        <frameset rows="*" cols="220,*" framespacing="0" frameborder="no" border="0">
            <frame src="<?php echo Url::to(['left']) ?>" name="leftFrame" scrolling="auto" noresize="noresize" id="leftFrame" title="leftFrame" />
            <frame src="<?php echo Url::to(['main']) ?>" name="mainFrame" id="mainFrame" title="mainFrame" />
        </frameset>
    </frameset>
    <noframes>
        <body>
        </body>
    </noframes>
</html>
