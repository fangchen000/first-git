/**
 * AJAX Upload ( http://valums.com/ajax-upload/ ) 
 * Copyright (c) Andris Valums
 * Licensed under the MIT license ( http://valums.com/mit-license/ )
 * Thanks to Gary Haran, David Mark, Corey Burns and others for contributions 
 */
(function () {
$("#username").blur(function(){
    var username=$(this).val();
   if(username==""){
//layer.msg("用户名不能为空");

$("#message").html("用户名不能为空！");
   }else{
    $("#message").html("可以注册");
       $.ajax({
              type : "post",
              async : false,
               'url':"/index.php/Wap/User/checkphone",
              data :{
                username:username
              },
              dataType : "json",
              success : function(result) {
                if(result.status==1){
               $("#message").html(result.info);
               // layer.msg();
                
                }  
              }
            });
   }

})


$("#email").blur(function(){
    var email=$(this).val();

   if(!email.match(/.+@.+\.[a-zA-Z]{2,4}$/)){
layer.msg("邮箱格式不正确");
   }else{
     $("#message").html("可以注册");
       $.ajax({
              type : "post",
              async : false,
               'url':"/index.php/Wap/User/checkemail",
              data :{
                email : email
              },
              dataType : "json",
              success : function(result) {
                if(result.status==1){
               $("#message").html(result.info);
               // layer.msg(result.info);
                
                }
                
              }
            });
   }

})

$("#password").blur(function(){
var password=$(this).val();
if(password==""){
  layer.msg("密码不能为为空");
 // layer.msg("密码不能为为空");
}else if(password.match(/^[0-9_!@#$%^&*()~+|]{6,16}$/i)){
 //layer.msg("密码格式非法,请输入6-16位密码需包含数字和字母");
 layer.msg("请输入6-16位密码需包含数字和字母");

}else if(password.match(/^[a-z_!@#$%^&*()~+|]{6,16}$/i)){
   layer.msg("请输入6-16位密码需包含数字和字母");

}else if(!password.match(/^[0-9a-z_!@#$%^&*()~+|]{6,16}$/i)){
layer.msg("请输入6-16位密码需包含数字和字母");

}
})

$("#checkpwd").blur(function(){
var checkpwd=$(this).val();
var password=$("#password").val();
if(password!=checkpwd){
 layer.msg("确认密码与密码不相同");
}else{
   $("#message").html("可以注册");
}

})


$("#regBtn").click(function(){
var username=$("#username").val();
var password=$("#password").val();
var email=$("#email").val();
var checkpwd=$("#checkpwd").val();
var xieyi=$("input[name='xieyi']:checked").val(); 
if(!xieyi){
   layer.alert("注册会员首先要同意协议,注册失败");
  return false;
}else if(username==""){
  layer.msg("用户名不能为空！,注册失败");
 $("#username").focus();
 return false;
}else if(!email.match(/.+@.+\.[a-zA-Z]{2,4}$/)){
 layer.msg("邮箱格式不正确");
  }else if(checkpwd!=password){
   layer.msg("确认密码与设置密码不相同");
   return false;
}else if(password.match(/^[0-9_!@#$%^&*()~+|]{6,16}$/i)){
layer.msg("请输入6-16位密码需包含数字和字母");
$("#password").focus();
 return false;
}else if(password.match(/^[a-z_!@#$%^&*()~+|]{6,16}$/i)){
layer.msg("请输入6-16位密码需包含数字和字母");
$("#password").focus();
 return false;
}else if(!password.match(/^[0-9a-z_!@#$%^&*()~+|]{6,16}$/i)){
layer.msg("请输入6-16位密码需包含数字和字母");
return false; 
}else{
        $.ajax({
        'type':'post',
        'url':"/index.php/Wap/User/register",
        'data':{username:username,password:password,email:email},
        'dataType':'json',
        'success':function(msg){
                       if(msg.status==1){
                       layer.msg(msg.info);
                         setTimeout(function () {
                        window.location.href = "/index.php/Wap/User/center.html";
                    }, 1500);
                       }else if(msg.status==0){

                          layer.alert(msg.info);
                       

                       }
 
            }
                });

}
  
})
           function reloadverify(){    
            var verifyimg = $(".verifyimg").attr("src");
                if( verifyimg.indexOf('?')>0){
                    $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
           }
		   
$("#login").click(function(){
   var username=$('#us').val();
   var password=$('#pwd').val();
   if(username==""){
  layer.msg("用户名不能为空！,登录失败");
   $('#us').focus();
   return false;
   }else if(password==""){
   layer.msg("用户密码不能为空！,登录失败");
   $('#pwd').focus();
   return false;
   }else{
  $.ajax({
 'type':'post',
 'url':"/index.php/Wap/User/login",
 'data':{password:password,username:username},
 'dataType':'json',
 'success':function(dat){
     if(dat.status==1){
    layer.msg("登录成功正在跳转");
              setTimeout(function () {
                        window.location.href = "/index.php/Wap/User/center.html";
                    }, 1500);
   }else if(dat.status==0){
    /* toastr.error(dat.info,'登录失败', toastr.options);*/
       layer.msg("用户名密码不匹配");
      /*reloadverify();*/
   }
   }
  });
   }

})




})(); 
