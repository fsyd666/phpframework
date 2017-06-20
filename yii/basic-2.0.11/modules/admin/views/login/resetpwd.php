<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Metronic | Login Page</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<include file="Public:style" />
<link href="__PUBLIC__/admin/css/login.css" rel="stylesheet" type="text/css"/>
</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login">

<!-- BEGIN LOGO -->

<div class="logo"> <img src="__PUBLIC__/admin/image/logo-big.png" alt="" /> </div>

<!-- END LOGO --> 

<!-- BEGIN LOGIN -->

<div class="content"> 
  <!-- BEGIN REGISTRATION FORM -->
  <form class="form-vertical resetpwd-form" style="display:block;" action="index.html">
    <h3 class="">重设密码</h3>
    <p>在下面输入您的新密码:</p>
    <div class="control-group">
      <label class="control-label visible-ie8 visible-ie9">密码</label>
      <div class="controls">
        <div class="input-icon left"> <i class="icon-lock"></i>
          <input class="m-wrap placeholder-no-fix" type="password" id="new_password" placeholder="密码" name="password"/>
        </div>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label visible-ie8 visible-ie9">确认密码</label>
      <div class="controls">
        <div class="input-icon left"> <i class="icon-ok"></i>
          <input class="m-wrap placeholder-no-fix" type="password" placeholder="确认密码" name="rpassword"/>
        </div>
      </div>
    </div>
    <div class="form-actions"> <a  href="__URL__/index.html" type="button" class="btn"> <i class="m-icon-swapleft"></i> 登录 </a>
      <button type="submit" id="register-submit-btn" class="btn green pull-right"> 修改 <i class="m-icon-swapright m-icon-white"></i> </button>
    </div>
  </form>
  <!-- END REGISTRATION FORM --> 
  
</div>
<div class="copyright">

		2013 © Ruijin. Admin Dashboard Template.

	</div>
<include file="Public:js" /> 
<script src="__PUBLIC__/admin/js/login.js" type="text/javascript"></script> 
<script type="text/javascript">
        Login.init();
    </script>
</body>
</html>