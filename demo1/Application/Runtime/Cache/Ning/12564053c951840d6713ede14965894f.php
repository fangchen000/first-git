<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台登录</title>
<meta name="author" content="DeathGhost" />
<link rel="stylesheet" type="text/css" href="/demo1/Public/admin/css/style.css" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="/demo1/Public/admin/js/jquery.js"></script>
<script src="/demo1/Public/admin/js/verificationNumbers.js"></script>
<script src="/demo1/Public/admin/js/Particleground.js"></script>
<script>
//$(document).ready(function() {
//  //粒子背景特效
//  $('body').particleground({
//    dotColor: '#5cbdaa',
//    lineColor: '#5cbdaa'
//  });
//  //验证码
//  createCode();
  //测试提交，对接程序删除即可
//  $(".submit_btn").click(function(){
//	  location.href="index.html";
//	  });
//});
</script>
</head>
<body>
<dl class="admin_login">
 <dt>
  <strong>站点后台管理系统</strong>
  <em>Management System</em>
 </dt>
 
 <form method="post" role="form"  id="login" class="login-form fade-in-effect">
 <dd class="user_icon">
  <input type="text" placeholder="账号" class="login_txtbx" name="username" id="username"  />
 </dd>
 <dd class="pwd_icon">
  <input type="password" placeholder="密码" class="login_txtbx" name="password" id="password" />
 </dd>
 
 <dd>
  <input type="button"  value="立即登陆" class="submit_btn"/>
 </dd>
 
 <script type="text/javascript">
					
					$(".submit_btn").click(function(){
					 var username=$("#username").val();
					 var password=$("#password").val();
					 if(username==""){
					 alert("用户名不能为空");
					 $("#username").focus();
					 return false;
					 }else if(password==""){
                      alert("登录密码不能为空");
                      $("#password").focus();
                      return false;					  
					 }else{
					    $.ajax({
						 'type':'post',
						 'url':"<?php echo U('Index/index');?>",
						 'data':{username:username,password:password},
						 'dataType':'json',
						 'success':function(msg){
						  console.log(msg);
						   if(msg.status==1){
//												window.location.href = "/index.php/Admin/Index/index";
												window.location.href = "<?php echo U('Admin/Index/index');?>";
									   }else{
										 alert(msg.info);
						   }
						  }
						  });
					 
					 }
					
					
					})
					
					
				</script>
				

				
 
 
 </form>
 
 <dd>
  <!--<p>© 2015-2016 DeathGhost 版权所有</p>-->
  <p>后台管理</p>
 </dd>
</dl>
</body>
</html>