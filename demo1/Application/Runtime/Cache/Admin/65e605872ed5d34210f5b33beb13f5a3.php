<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">

<title>后台管理系统</title>

<link rel="stylesheet" type="text/css" href="/demo1/Public/admin/css/style.css" />

<script src="/demo1/Public/admin/js/jquery.js"></script>
<script src="/demo1/Public/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/demo1/Public/admin/js/PCASClass.js"></script>
<script src="/demo1/Public/layer/layer.js"></script>
    <style>
        *{margin: 0; padding: 0; text-decoration: none;list-style: none;outline:none;border:none;background:none;vertical-align:top;}
        @font-face {
            font-family: 'iconfont';  /* project id 200468 */
            src: url('//at.alicdn.com/t/font_gfd4hencw1ybke29.eot');
            src: url('//at.alicdn.com/t/font_gfd4hencw1ybke29.eot?#iefix') format('embedded-opentype'),
            url('//at.alicdn.com/t/font_gfd4hencw1ybke29.woff') format('woff'),
            url('//at.alicdn.com/t/font_gfd4hencw1ybke29.ttf') format('truetype'),
            url('//at.alicdn.com/t/font_gfd4hencw1ybke29.svg#iconfont') format('svg');
        }

        .iconfont{
            font-family:"iconfont" !important;
            font-size:16px;font-style:normal;
            -webkit-font-smoothing: antialiased;
            -webkit-text-stroke-width: 0.2px;
            -moz-osx-font-smoothing: grayscale;}
        .clear:after{content:".";height:0;display:block;visibility:hidden;clear:both;}
        .clear{*zoom:1}
        .fl{float: left}
        .msg-wrap{width: 930px;margin-left: 300px}
        .msg-wrap div{width: 300px;height: 100px;float: left;margin-left: 10px}
        .msg-wrap h1{border-radius: 50%;text-align: center;width:80px;height: 80px;line-height: 80px;font-size: 40px;color:#fff}
        nav{width: 200px;height: 80px; margin-left: 20px}
        .msg-wrap h6{text-align: left;height: 60px;line-height: 60px;font-size: 16px;color:#333}
        .msg-wrap h4{text-align: left;margin-top:25px;height: 20px;line-height: 20px;font-size: 16px;color:#333}
        .msg-wrap h5{text-align: left;height: 30px;line-height: 30px;font-size: 14px;color:#333}
        .msg1 h1{background: #00b700}
        .msg2 h1{background: #803ac5}
        .msg3 h1{background: #fe5141}
        .msg4 h1{background: #d358ff}
        .msg5 h1{background: #ffc926}
        .msg6 h1{background: #7a98ff}
        .msg7 h1{background: #00b700}


    </style>
<script>
	(function($){
		$(window).load(function(){
			
			$("a[rel='load-content']").click(function(e){
				e.preventDefault();
				var url=$(this).attr("href");
				$.get(url,function(data){
					$(".content .mCSB_container").append(data); //load new content inside .mCSB_container
					//scroll-to appended content 
					$(".content").mCustomScrollbar("scrollTo","h2:last");
				});
			});
			
			$(".content").delegate("a[href='top']","click",function(e){
				e.preventDefault();
				$(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
			});
			
		});
	})(jQuery);
</script>

<link href="/demo1/Public/admin/css/toastr.css" rel="stylesheet"/>

<script src="/demo1/Public/admin/js/toastr.js"></script>
<script>
  
        $(function(){
		
	
	            toastr.options = {
				"closeButton": false,
				  "debug": false,
				  "positionClass":$('#positionGroup input:radio:checked').val() || 'toast-center',
				  "onclick": null,
				  "showDuration": "300",
				  "hideDuration": "1000",
				  "timeOut": "50000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
            };	
				});	
</script>

   
</head>
<body>
<!--header-->
<header>
 <h1><img src="/demo1/Public/admin/images/admin_logo.png"/></h1>
 <ul class="rt_nav">
  <li><a href="<?php echo U('Home/Index/index');?>" target="_blank" class="website_icon">站点首页</a></li>
  <li><a  class="set_icon"  rel="leanModal" name="signup" href="#admin">密码设置</a></li>
 
  <li><a href="<?php echo U('Ning/Index/tc');?>" class="quit_icon">安全退出</a></li>
 </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar">
 <h2><a href="<?php echo U('Admin/Index/index');?>">起始页</a></h2>
    <div class="tab">
 <ul>
 <li>
   <dl>
    <dt>会员管理</dt>
    <dd><a href="<?php echo U('Admin/User/index');?>" id="Userindex" class="active1">会员列表</a></dd>
   </dl>
  </li>

     <li>
         <dl>
             <dt>新闻管理</dt>
             <dd><a href="<?php echo U('Admin/News/addnotice');?>" id="News" class="active1">新闻添加</a></dd>
             <dd><a href="<?php echo U('Admin/News/index');?>" id="Newslist" class="active1">新闻列表</a></dd>
         </dl>
     </li>
    
   
  
  
  <li>
   <p class="btm_infor">©杰尔古格商贸有限公司</p>
  </li>
 </ul>
    </div>
</aside>
<script type="text/javascript" src="/demo1/Public/admin/assets/js/jquery.leanModal.min.js"></script>
<script type="text/javascript">
			$(function() {
    			$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });		
			});
		</script>
<script>
var CONTROLLER="<?php echo ' /demo1/index.php/Admin/User/index' ?>" 

var arr=CONTROLLER.split('/');
var str=arr[3]+arr[4];

$("#"+str).addClass("active");
</script> 
	<div class="yin" id="admin">
		<div id="signup-ct">
			<div id="signup-header">
				<h2>密码设置</h2>
				<a class="modal_close" href="#"></a>
				
			</div>
		  <div class="txt-fld">
		    <label for="">原始密码</label>
		    <input id="password" class="good_input" name="" type="password"  />
		  </div>

		   <div class="txt-fld">
		    <label for="">新密码</label>
		    <input id="newpassword" class="good_input" name="" type="password" />

		  </div>
		  <div class="txt-fld">
		    <label for="">确认密码</label>
		    <input id="checkpassword" name="" type="password" />
		  </div>
		  <div class="btn-fld">
		  <button type="button" class="admin" onclick="setadmin()">确定</button>
		</div>
				   
	</div>
</div>

<script type="text/javascript">


//添加会员积分
function setadmin(){


   if(confirm("您确定要修改后台密码吗？你可一定要记住您自己设置的密码啊，丢失了很麻烦！！！")){

    var password=$("#password").val();
    var newpassword=$("#newpassword").val();
    var checkpassword=$("#checkpassword").val();
    if(password==""){
   toastr.error("初始密码不能为空",'操作成功',toastr.options);
   return  false;
    }else if(newpassword==""){
    	toastr.error("新密码不能为空",'操作成功',toastr.options);
    	return  false;
    }else if(checkpassword!=newpassword){
toastr.error("确认密码与新密码不相同",'操作成功',toastr.options);
return  false;
    }else{
         $.ajax({
                    type:'post',
                    url:"<?php echo U('Ning/Index/setpwd');?>",
                    data:{password:password,newpassword:newpassword,checkpassword:checkpassword},
                    success:function(msg){
                        if(msg.status==1){
                            toastr.success(msg.info,'操作成功',toastr.options);
                         setTimeout(function () {
                              location.reload();
                            }, 1500);
                        }else{
                            toastr.error(msg.info,'操作失败',toastr.options);    
                        }
                    }
                });

    }
             
   }                 
 }

</script>



     <section class="rt_wrap content mCustomScrollbar">

 <div class="rt_content">
     <section>

      <div class="page_title">
       <h2 class="fl">用户列表</h2>
          <section>
              <form method="post" action="<?php echo U('Admin/User/index');?>">
                  <input type="text" class="textbox" placeholder="用户账号" name="keywords" value="<?php echo ($keywords); ?>"/>
                 
                  <input type="submit" value="搜索" class="group_btn"/>
              </form>
             

          </section>
      </div>

	  <div class="btm_btn">
          <!--<?php if($_SESSION["adminjurisdiction"] == 0): ?>-->
                <!--<a href="#" class="link_btn" id="open" >开启</a>-->
                <!--<a href="#" class="link_btn" id="ban">禁用</a>-->

              <!--<a href="#" class="link_btn" id="add_users">添加地区管理员</a>-->
          <!--<?php endif; ?>-->

       </div>

      <table class="table">
       <tr>
      <th>选择</th>
      <th>会员编号</th>
		<th>会员账号</th>
		
		
		<th>注册时间</th>
		
        <th>账户状态</th>
        
         <th>操作</th>
       </tr>
	   <tbody class="middle-align table table-bordered table-striped">
	   <?php if(is_array($userInfo)): $i = 0; $__LIST__ = $userInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
        <td><input type="checkbox" value="<?php echo ($v["id"]); ?>" name="ids"></td>
        <td><?php echo ($v["id"]); ?></td>
        <td><?php echo ($v["mobile"]); ?></td>
		
		
		<td><?php echo (date("Y-m-d H:i:d",$v["create_time"])); ?></td>
		<td><?php if($v['lock'] == 1): ?><span style="color:red">后台</span><?php elseif($v['lock'] == 0): ?><span style="color:green">前台</span><?php endif; ?></td>
           <td>
               <a href="<?php echo U('Admin/User/addnotice',array('id'=>$v['id']));?>"><img src="/demo1/Public/admin/assets/images/icon_edit.gif" alt="编辑" title="编辑"></a>&nbsp;&nbsp;
               <img src="/demo1/Public/admin/assets/images/icon_trash.gif" onclick="setdel(<?php echo ($v['id']); ?>)" alt="删除" title="删除">
           </td>
       </tr><?php endforeach; endif; else: echo "" ;endif; ?>   
       <tr>
	    <td colspan="10"><?php echo ($page); ?></td>
	   </tr>
	   </tbody>
      </table>
     
     </section>
   
 </div>
</section>
<!---弹出层-->
<!---弹出层-->
	  <script>
     $(document).ready(function(){
		 //弹出文本性提示框
		 $("#showPopTxt").click(function(){
			 $(".pop_bg").fadeIn();
			 });
		 //弹出：确认按钮
		
		 //弹出：取消或关闭按钮
		 $(".falseBtn").click(function(){
			 alert("你点击了取消/关闭！");//测试
			 $(".pop_bg").fadeOut();
			 });
		 });
     </script>
    
<script type="text/javascript">

//检测会员是否存在
$("#username").blur(function(){
var username=$(this).val();
		$.ajax({
				type:'post',
				url:"<?php echo U('Admin/User/checkusername');?>",
				data:{username:username},
				success:function(msg){
					if(msg.status==1){
						
			alert("会员已存在请更换账号");
					}else{
						
						
					}
				}
			});

})

//单条删除视频
function  setdel(e){
    if(confirm("您确定删除该会员吗？？")){
        $.ajax({
            type:'post',
            url:"<?php echo U('Admin/User/setvimeodel');?>",
            data:{id:e},
            success:function(msg){
                if(msg.status==1){
                    toastr.success(msg.info,'删除成功',toastr.options);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }else{
                    toastr.error(msg.info,'删除失败',toastr.options);

                }
            }
        });

    }
}

      $("#open").click(function(){   
                    var ids =[]; 
                $('input[name="ids"]:checked').each(function(){ 
                ids.push($(this).val()); 
                });
			if(confirm("您确定认证您所选会员？？")){
			               $.ajax({
                                type:'post',
                                url:"<?php echo U('Admin/User/setuserstatus');?>",
                                data:{ids:ids,status:1},
                                success:function(msg){
                            
                                    if(msg.status==1){
                                        toastr.success(msg.info,'开启成功',toastr.options);
                                     setTimeout(function () {
								location.reload();
							}, 1500);
                                    }else{
                                        toastr.error(msg.info,'操作失败',toastr.options);
                                        
                                    }
                                }
                            });
			}

                    })  
                    $("#ban").click(function(){
                    var ids =[]; 
                $('input[name="ids"]:checked').each(function(){ 
                ids.push($(this).val()); 
                });
				if(confirm("您确定关闭您所选认证会员？？")){
                    $.ajax({
                                type:'post',
                                url:"<?php echo U('Admin/User/setuserstatus');?>",
                                data:{ids:ids,status:0},
                                success:function(msg){
                                    if(msg.status==1){
                                        toastr.success(msg.info,'禁用成功',toastr.options);
                                     setTimeout(function () {
                        window.location.href = "/index.php/Admin/User/index.html";
                    }, 1500);
                                    }else{
                                        toastr.error(msg.info,'操作失败',toastr.options);
                                        
                                    }
                                }
                            });
               }
                    })
$("#add_users").click(function(){

      setTimeout(function () {
            window.location.href = "/index.php/Admin/User/chongmi.html";
        }, 0);
        })

</script>