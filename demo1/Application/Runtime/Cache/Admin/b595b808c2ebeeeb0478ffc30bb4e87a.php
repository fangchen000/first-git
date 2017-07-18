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
var CONTROLLER="<?php echo ' /demo1/index.php/Admin/Index/index' ?>" 

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



     



<div class="msg-wrap clear">
    <!--<div class="msg1 clear">-->
        <!--<h1 class="iconfont fl">&#xe635;</h1>-->
        <!--<nav class="fl">-->
        <!--<h4>数据统计</h4>-->
        <!--</nav>-->
    <!--</div>-->
   <!--  <div class="msg2 clear">
        <h1 class="iconfont fl">&#xe63c;</h1>
        <nav class="fl">
        <h4>全部老师</h4>
        <h5>共<span><?php echo ($teacher_count); ?></span>位老师</h5>
            </nav>
    </div> -->
    <!-- <div class="msg3 clear">
        <h1 class="iconfont fl">&#xe605;</h1>
        <nav class="fl">
        <h4>全部机构</h4>
        <h5>共<span><?php echo ($school_count); ?></span>家机构</h5>
            </nav>
    </div> -->
    <!-- <div class="msg4 clear">
        <h1 class="iconfont fl">&#xe618;</h1>
        <nav class="fl">
        <h4>全部课程</h4>
        <h5>共<span><?php echo ($curriculum_count); ?></span>门课程</h5>
            </nav>
    </div> -->
    <!--<div class="msg5 clear">-->
        <!--<h1 class="iconfont fl">&#xe639;</h1>-->
        <!--<nav class="fl">-->
            <!--<h4>全部订单</h4>-->
            <!--<h5>共<span><?php echo ($student_count); ?></span>份订单</h5>-->
         <!--</nav>-->

    <!--</div>-->
    <!--<div class="msg6 clear">-->
        <!--<a href="<?php echo U('');?>"><h1 class="iconfont fl">&#xe61d;</h1>-->
        <!--<nav class="fl">-->
            <!--<h4>CRM（老师管理）</h4>-->
        <!--</nav>-->
            <!--</a>-->
    <!--</div>-->
    <!--<div class="msg7 clear">-->
        <!--<h1 class="iconfont fl">&#xe6da;</h1>-->
        <!--<nav class="fl">-->
        <!--<h4>今日新增</h4>-->
        <!--<h5><span><?php echo ($newadd_teacher); ?></span>订单</h5>-->
            <!--</nav>-->
    <!--</div>-->
    <div class="msg7 clear">
    <!--<h1 class="iconfont fl">&#xe6da;</h1>-->
    <nav class="fl">
    <h4>您好<?php echo (getuserrealname($_SESSION['user_id'])); ?>,欢迎回来</h4>
    <!--<h5><span><?php echo ($newadd_teacher); ?></span>订单</h5>-->
    </nav>
    </div>



</div>
</body>
</html>