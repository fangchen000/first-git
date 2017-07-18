/**
 * AJAX Upload ( http://valums.com/ajax-upload/ ) 
 * Copyright (c) Andris Valums
 * Licensed under the MIT license ( http://valums.com/mit-license/ )
 * Thanks to Gary Haran, David Mark, Corey Burns and others for contributions 
 */
(function () {
	
//发送验证码到手机


//修改用户名
$("#username").blur(function(){



  
})


//账号验证
$("#useredit").click(function(){
  var photo=$("#newbikephoto").attr("src");
    var username=$("#username").val();
    var email=$("#email").val();
    var oldpwd=$("#oldpwd").val();
    var newpwd=$("#newpwd").val();
    var checkpwd=$("#checkpwd").val();

     if(newpwd!=checkpwd){
      layer.msg("设置的新密码与确认密码不相同");
     }else{
          if(confirm("确认提交个人资料！")){
                 $.ajax({
                        type : "post",
                        async : false,
                         'url':"/index.php/Home/User/set",
                        data :{
                          photo : photo,username:username,email:email,oldpwd:oldpwd,newpwd:newpwd
                        },
                        dataType : "json",
                        success : function(result) {
                          if(result.status==1){
                         layer.msg(result.info);
                         location.reload();
                          }
                          if(result.status==0){       
                            layer.msg(result.info);
                          }  
                        }
                      });
              }
     }    
})
//创建频道
$(".chuan2").click(function(){
  var image=$("#newbikephoto").attr("src");
    var title=$("#title").val();
    var content=$("#content").val();
    
     if(image==""){
      layer.msg("设置频道的封面不能为空");
     }else if(title==""){
       layer.msg("频道名称不能为空");
     }else if(content==""){
       layer.msg("频道描述不能为空");
     }else{
          if(confirm("确认创建该频道，一旦提交不可更改！")){
                 $.ajax({
                        type : "post",
                        async : false,
                         'url':"/index.php/Wap/User/create_channel",
                        data :{
                          image : image,title:title,content:content
                        },
                        dataType : "json",
                        success : function(result) {
                          if(result.status==1){
                         layer.msg(result.info);
                         
						  setTimeout(function () {
                        location.reload();
                    }, 1500);
                          }
                          if(result.status==0){       
                            layer.msg(result.info);
                          }  
                        }
                      });
              }
     }    
})

 function  collect(e){
            $.ajax({
 'type':'post',
 'url':"{:U('Home/Vimeo/addcollect')}",
 'data':{v_id:e},
 'dataType':'json',
 'success':function(msg){
   if(msg.status==1){
         $(".shoucang").toggleClass("shoucangon");
         $(".shoucang1").toggleClass("shoucangon1"); 
           }else{
     alert(msg.info);
                  
                        
           }   
   }
  });
        }


   




//频道删除

         

})(); 
