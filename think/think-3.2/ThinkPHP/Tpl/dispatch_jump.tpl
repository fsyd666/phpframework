<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>跳转提示</title>
        <style type="text/css">           
            *{ padding:0; margin:0; font-size:12px;}
            .zalert-background{width:100%; height:100%; background-color:#000; position: fixed; z-index: 9998; top: 0;left: 0;opacity: 0.5;}
            .zalert-wrap{position: fixed; width:540px; left:50%; top:50%; margin-left:-270px; margin-top:-171px; z-index:9999;}
            .zalert-title{background-image: url(/Public/image/msg/cstbg.png);margin-top: -12px; background-repeat: x-repeat; width:540px; height:78px; float: left; color:#fff; line-height:78px; font-size:24px;}
            .zalert-title-img{margin:0; margin-left:11px; display: block; float: left; margin-right:18px;}
            .zalert-close{text-decoration:none;float: right; font-size:20px; font-style:normal; line-height:14px; margin-top:34px; margin-right:14px; cursor:pointer;}
            .zalert-content{margin:0; padding:0; line-height:80px; color:#ff7800; text-align:center; font-size:24px;}
            .zalert-ok-btn{height:50px; background-color:#174790; color:#fff; font-size:18px; line-height:50px;text-align:center;}   
            .zalert-wrap a{ color:inherit;color:expression(this.parentNode.currentStyle.color);text-decoration:unline;} /*继承 父元素样式*/
        </style>
        <script src="/Public/home/js/common.js" type="text/javascript"></script>
    </head>
    <body>

        <div id="zalert-dlg"><div class="zalert-background"></div>
            <div  class="zalert-wrap">
                <div class="zalert-title">
                    <present name="message">
                        <img src="/Public/image/msg/zccg1.png" class="zalert-title-img" />
                        <else/>
                        <img src="/Public/image/msg/cstimg.png" class="zalert-title-img" />
                    </present>
                    温馨提示<a href="javascript:goBack(<?php echo $jumpUrl==100 ? 100 : -1 ?>)" class="zalert-close">X</a>
                </div>
                <div style=" background-color:#fff;">
                    <present name="message">
                        <div class="zalert-content" style="color:#009966;"><?php echo $message; ?></div>
                        <else/>
                        <div class="zalert-content"><?php echo $error; ?></div>
                    </present>
                    <div class="zalert-ok-btn" >等待时间:<b id="wait"><?php echo $waitSecond; ?></b>
                        <a  href="<?php echo($jumpUrl); ?>" id="href">如果您的浏览器没有自动跳转，请点击这里</a>
                    </div>
                </div>
            </div>
        </div>
        </div>        
    </body>
    <script type="text/javascript">
        (function () {
            var wait = document.getElementById('wait'), href = document.getElementById('href').href;
            var interval = setInterval(function () {
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

