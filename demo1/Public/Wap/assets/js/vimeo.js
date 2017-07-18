/**
 * AJAX Upload ( http://valums.com/ajax-upload/ ) 
 * Copyright (c) Andris Valums
 * Licensed under the MIT license ( http://valums.com/mit-license/ )
 * Thanks to Gary Haran, David Mark, Corey Burns and others for contributions 
 */
(function () {
	
//发送验证码到手机

//账号验证
/* $("#useredit").click(function(){
  var photo=$("#newbikephoto").attr("src");
    var realname=$("#realname").val();
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
                          photo : photo,realname:realname,email:email,oldpwd:oldpwd,newpwd:newpwd
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
                         'url':"/index.php/Home/User/creat_channel",
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
}) */

//添加视频
	$("#submit").click(function(){
	
    var vid=$("#vid").val();
	var image=$("#newbikephoto").attr("src");
	var type_id=$("#type_id").val();
	var channel_id=$("#channel_id").val();
	var title=$("#title").val();
	var content=$("#content").val();
	
	if(vid==""){
		layer.msg("视频必须上传");
		return false;
	}else if(image==""){
		layer.msg("视频封面不能为空");
		return false;
	}else if(title==""){
		layer.msg("视频标题不能为空");
		return false;
	}else if(content==""){
		layer.msg("视频内容不能为空");
		return false;
	}else{
	
		  $.ajax({
				type : "post",
				async : false,
				 'url':"/index.php/Home/User/dovimeo",
				data :{
				  vid : vid,image:image,type_id:type_id,channel_id:channel_id,title:title,content:content
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
    
    
})


})(); 
