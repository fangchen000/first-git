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
var CONTROLLER="<?php echo ' /demo1/index.php/Admin/News/addnotice' ?>" 

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



     <link rel="stylesheet" href="/demo1/Public/mp/control/css/zyUpload.css" type="text/css">
<script type="text/javascript" src="/demo1/Public/Home/js/ajaxupload.js"></script>
<script type="text/javascript" src="/demo1/Public/layer/layer.js"></script>
<script type="text/javascript" src="/demo1/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/demo1/Public/ueditor/ueditor.all.min.js"></script>
<script>
    $(function () {
        var ue = UE.getEditor('content');
    })
</script>




<section class="rt_wrap content mCustomScrollbar">
      <h2><strong style="color:grey;">新闻管理</strong></h2>
      <ul class="ulColumn2">
	   <form onsubmit="return false;">
       <li>
        <span class="item_name" style="width:120px;">新闻名称：</span>
        <input type="text" class="textbox textbox_295" placeholder="新闻名称" id="title" value="<?php echo ($news["title"]); ?>"/>
       </li>
	   <li>
           <li>
               <span class="item_name" style="width:120px;">新闻类型：</span>
           <select name='type' id="type" class="form-control">
               <option
               <?php if($news['type'] == 'bankajishu'): ?>selected="selected"<?php endif; ?>
               value="bankajishu">办卡技术</option>
               <option
               <?php if($news['type'] == 'faren'): ?>selected="selected"<?php endif; ?>
               value="faren">法人</option>
               <option
               <?php if($news['type'] == 'kaopuwangdai'): ?>selected="selected"<?php endif; ?>
               value="kaopuwangdai">靠谱网贷</option>
               <option
               <?php if($news['type'] == 'pos'): ?>selected="selected"<?php endif; ?>
               value="pos">pos机</option>
               <option
               <?php if($news['type'] == 'qiyedaikuan'): ?>selected="selected"<?php endif; ?>
               value="qiyedaikuan">企业贷款</option>
               <option
               <?php if($news['type'] == 'fenqi'): ?>selected="selected"<?php endif; ?>
               value="fenqi">分期</option>
               <option
               <?php if($news['type'] == 'tie'): ?>selected="selected"<?php endif; ?>
               value="tie">提额技术</option>
               <option
               <?php if($news['type'] == 'vipcoreresourse'): ?>selected="selected"<?php endif; ?>
               value="vipcoreresourse">核心资料</option>
               <option
               <?php if($news['type'] == 'wangdaijishu'): ?>selected="selected"<?php endif; ?>
               value="wangdaijishu">网贷技术</option>
               <option
               <?php if($news['type'] == 'wangluodaikuan'): ?>selected="selected"<?php endif; ?>
               value="wangluodaikuan">网络贷款</option>
               <option
               <?php if($news['type'] == 'xinyongkadaikuan'): ?>selected="selected"<?php endif; ?>
               value="xinyongkadaikuan">信用卡贷款</option>
               <option
               <?php if($news['type'] == 'yangkajishu'): ?>selected="selected"<?php endif; ?>
               value="yangkajishu">养卡技术</option>
               <option
               <?php if($news['type'] == 'yijianbanka'): ?>selected="selected"<?php endif; ?>
               value="yijianbanka">一键办卡</option>
               <option
               <?php if($news['type'] == 'yijiantie'): ?>selected="selected"<?php endif; ?>
               value="yijiantie">一键提额</option>
               <option
               <?php if($news['type'] == 'yinhangdaikuan'): ?>selected="selected"<?php endif; ?>
               value="yinhangdaikuan">银行贷款</option>
           </select>
           </li>
           <li>
        <span class="item_name" style="width:120px;">新闻封面：</span>
         <b style="position:relative;"><img class="vb" id="newbikephoto" src="<?php echo ($news["img"]); ?>" style="width: 130px;height: 100px;">
		</b>
		<input type="button" class="btn btn-primary" id="upload_button"  value="上传图片"/>
       </li>


        <li>
        <span class="item_name" style="width:120px;">新闻描述：</span>
        <input type="text"  class="textbox textbox_295" placeholder="新闻描述" id="describe" value="<?php echo ($news["describe"]); ?>"/>
       </li>

       <li>
           <span class="item_name" style="width:120px;">新闻链接：</span>
           <input type="text"  class="textbox textbox_295" placeholder="新闻链接" id="link_url" value="<?php echo ($news["link_url"]); ?>"/>
       </li>

	  <li>
        <span class="item_name" style="width:120px;">新闻详情：</span>
          <textarea id="content" class="textarea" name="content" style="width:700px;height:200px;"><?php echo ($news["content"]); ?></textarea>
       </li>

       <li style="margin-bottom:100px;">
        <input type="submit" class="link_btn" id="but"/>
       </li>
       </form>
      </ul>
     </section>

	 <input type="hidden" id="idd" value="<?php echo ($news["id"]); ?>"/>

<script>
    $(function(){
        $("#but").click(function(){
            var id=$("#idd").val();
            var title=$("#title").val();
            var type=$("#type").val();
            var type=$("#link_url").val();
            var img=$("#newbikephoto").attr("src");
            var content = UE.getEditor('content').getContent();
            var describe=$("#describe").val();
            if(title==""){
                toastr.error("新闻名称不能为空",'操作失败',toastr.options);
                return false;
            }else if(img==""){
                toastr.error("新闻封面不能为空",'操作失败',toastr.options);
                return false;
            }

            $.post("<?php echo U('News/addnotice');?>",{id:id,title:title,type:type,img:img,link_url:link_url,content:content,describe:describe},function(sb){
                if (sb.status==1) {
                    layer.msg('操作成功',{icon:6});
                    setTimeout(function () {
                        window.location.href="<?php echo U('News/index');?>";
                    }, 1500);
                }else{
                    layer.msg("操作失败",{icon:2,time:2000});return false;
                }
            });
        });
    })
</script>
<script type="text/javascript">
$(function(){
	var button = $('#upload_button'), interval;
//	var button1 = $('#upload_button1'), interval;
	var confirmdiv = $('#uploadphotoconfirm');

    var fileType = "pic",fileNum = "one";
    new AjaxUpload(button,{
        action: "<?php echo U('Admin/Up/uppic');?>",
        name: 'userfile',
        onSubmit : function(file, ext){
            if(fileType == "pic")
            {
                if (ext && /^(jpg|png|jpeg|gif|JPG)$/.test(ext)){
                    this.setData({
                        'info': '文件类型为图片'
                    });
                } else {
                     confirmdiv.text('文件格式错误，请上传格式为.png .jpg .jpeg 的图片');
                    return false;
                }
            }

           confirmdiv.text('文件上传中');

            if(fileNum == 'one')
                this.disable();

            interval = window.setInterval(function(){
                var text = confirmdiv.text();
                if (text.length < 14){
                    confirmdiv.text(text + '.');
                } else {
                    confirmdiv.text('文件上传中');
                }
            }, 200);
        },
        onComplete: function(file, response){

			if(response != "success"){
				if(response =='2'){
					confirmdiv.text("文件格式错误，请上传格式为.png .jpg .jpeg 的图片");
				}else{
					if(response.length>20){
						confirmdiv.text("文件上传失败请重新上传"+response);
					}else{
						confirmdiv.text("上传完成");

					 	$("#newbikephotoName").val("/demo1/Upload/images/"+response);
						$("#newbikephoto").attr("src","/demo1/Upload/images/"+response);
					}
				}

			}

            window.clearInterval(interval);

            this.enable();

            if(response == "success")
            confirmdiv.text('上传成功');
        }
    });



});



</script>