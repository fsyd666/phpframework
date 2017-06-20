<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>跳转提示</title>
        <style type="text/css">
            <!--
            *{ padding:0; margin:0; font-size:12px}
            body{background:#FFF8EE;}
            a:link,a:visited{text-decoration:none;color:#2A69CA;}
            a:hover,a:active{color:#ff6600;text-decoration: underline}
            .showMsg{zoom:1; width:398px; height:153px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px;
			background:url(__PUBLIC__/image/msg/msgbox.png) no-repeat;}
            .showMsg h5{background-image: background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
            .showMsg .content{ padding-top:70px; font-size:14px; height:44px; padding-left:40px; text-align:left;}
            .showMsg .bottom{margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
            .showMsg .error{background: url(__PUBLIC__/image/msg/error.png) no-repeat 0px 70px;}
            .showMsg .success{background: url(__PUBLIC__/image/msg/success.png) no-repeat 0px 60px;}
            -->
        </style>
    </head>
    <body>
        <div class="showMsg" style="text-align:center">
            
            <present name="message">
                <div class="content success" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;max-width:330px"><?php echo $message; ?></div>           
                <else/>
                <div class="content error" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;max-width:330px"><?php echo $error; ?></div> 
            </present>
            <div class="bottom">等待时间:<b id="wait"><?php echo $waitSecond; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo($jumpUrl); ?>" id="href">如果您的浏览器没有自动跳转，请点击这里</a>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        (function() {
            var wait = document.getElementById('wait'), href = document.getElementById('href').href;
            var interval = setInterval(function() {
                var time = --wait.innerHTML;
                if (time == 0) {
                    location.href = href;
                    clearInterval(interval);
                }
                ;
            }, 1000);
        })();
    </script>
</html>

