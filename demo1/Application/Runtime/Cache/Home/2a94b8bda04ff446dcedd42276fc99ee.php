<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>创业商城</title>
		<link rel="stylesheet" href="/demo1/Public/Home/css/public.css" />
		<link rel="stylesheet" href="/demo1/Public/Home/css/index.css" />
		<script src="/demo1/Public/Home/js/jquery-1.7.2.min.js"></script>
		<script src="/demo1/Public/Home/layer/layer.js"></script>
		<style>
			.buy-hide{z-index: 99995959999;display: none;position: fixed;top: 0;left: 0;width: 100vw;height: 100vw;}
			.buy{height: auto;top: 30vh;position: relative;z-index: 2;}
			.buy-off{ width: 100vw;height: 100vh;position: absolute;top: 0;left: 0;z-index: 1;background: rgba(0,0,0,.5);}
			#off{position: absolute;top: 0;right: 0;display: block;width: 30px;height: 30px;font-size: 16px;text-align: center;line-height: 30px;cursor: pointer;background: #333;color: #fff;}
			.buy-dizi{width: 90%;margin: 0px auto;padding: 20px 0; }
			.buy-dizi input{width: 100%;background: #ececec;color:#333;/*border-radius: 6px;*/height: 36px;line-height: 36px;padding: 0 6px;font-size: 16px;}
			.buy-dizi p{color:#999;font-size: 12px;margin: 2px 0;}
			.buy-yes{display: inline-block;margin: 0 auto;width: 100px !important;height: 30px;line-height: 30px;font-size: 16px;color:#fff !important;background:#FB5320 !important;text-align: center;}
			.buy-no{cursor: pointer;display: inline-block;margin-right: 30px;width: 100px;height: 36px;line-height: 36px;font-size: 16px;color:#fff;background: #999;text-align: center;}
			.no-yes{margin: 20px auto;text-align: center;}
		</style>
	</head>
	<body>
		<nav class="maxwidth tr">
			<div class="middle clear">
				<div class="nav-left fl clear">
					<?php if($_SESSION["uid"] == ''): ?><p class="fl">【登录】</p>
						<p class="fl">【注册】</p>
						<div class="hide denglu">
							<span  class="iconfont tr">&#xe6a7;</span>
							<label>账号：<input type="text"  id="dl_mobile" required placeholder="请输入您的账号" autofocus autocomplete="default"></label>
							<label>密码：<input type="password" id="dl_pwd"  required placeholder="请输入您的密码" autofocus autocomplete="on"></label>
							<input type="submit" value="登&nbsp;&nbsp;&nbsp;录" class="submit" id="dl"/>
						</div>

						<div class="hide zhuce">
							<span class="iconfont tr">&#xe6a7;</span>
							<label>账号：<input type="text" id="zc_mobile"  required placeholder="请输入您的手机号" autofocus autocomplete="default"></label>
							<label>密码：<input type="password" id="zc_pwd"  required placeholder="6-16位数字字母组合" autofocus autocomplete="on"></label>
							<label>确认密码：<input type="password" id="zc_pwd1" required placeholder="确认您的密码" autofocus autocomplete="on"></label>
							<input type="submit" value="注&nbsp;&nbsp;&nbsp;册"  class="submit" id="zc" />
						</div>
						<?php else: ?>
						<p class="fl"><i class="iconfont" style="color:#22d3b6;font-size:30px">&#xe60d;</i>【欢迎您】</p>
						<p class="fl">【<?php echo (getuserrealname($_SESSION['uid'])); ?>】</p>
						<a href="<?php echo U('Index/logout');?>" class="fl">
							<p class="fl">【退出】</p>
						</a><?php endif; ?>

				</div>
				<script>
					$(function(){
						$("#dl").click(function(){
							var mobile=$("#dl_mobile").val();
							var pwd=$("#dl_pwd").val();

							if (mobile=="") {layer.msg("输入手机号");return false};
							if (pwd=="") {layer.msg("密码不能为空");return false};

							$.post("<?php echo U('Index/Login');?>",{mobile:mobile,password:pwd},function(sb){
//                                alert(sb);die;
								if (sb.status==200) {
									layer.msg(sb.info,{icon:6});
									setTimeout(function () {
										window.location.href="<?php echo U('Index/index');?>";
									}, 1500);

								}else{
									layer.msg(sb.info,{icon:2,time:2000});return false;
								}

							})

						})



					})

					$(function(){
						$("#zc").click(function(){
							var mobile=$("#zc_mobile").val();
							var password=$("#zc_pwd").val();
							var pwd=$("#zc_pwd1").val();
							if (mobile=="") {layer.msg("输入手机号");return false};
							if (password=="") {layer.msg("密码不能为空");return false};
							if (pwd=="") {layer.msg("确认密码不能为空");return false};
							if (password!=pwd) {layer.msg("密码不一致");return false};
                            return false;

							$.post("<?php echo U('Index/zhuce');?>",{mobile:mobile,password:password},function(sb){
//                                alert(sb);die;
								if (sb.status==200) {
									layer.msg(sb.info,{icon:6});
									setTimeout(function () {
										window.location.href="<?php echo U('Index/index');?>";
									}, 1500);

								}else{
									layer.msg(sb.info,{icon:2,time:2000});return false;
								}

							})

						})



					})
				</script>
				<script>
				$(function(){
					$("#zc").click(function(){
						var mobile=$("#zc_mobile").val();
						var pwd=$("#zc_pwd").val();
						var pwd1=$("#zc_pwd1").val();
						if(!/^1[3|4|5|7|8]\d{9}$/.test(mobile)){
							layer.msg("手机号不符合要求",{icon:2,time:2000});
							return false;
						}
						if (pwd=="") {layer.msg("密码不能为空");return false};
						if(!pwd.match(/^[0-9A-Za-z]{6,16}$/)){
							layer.msg("密码不符合规则！",{icon:2,time:2000});
							$('select[name="pwd"]').focus();
							return false;};
						if (pwd1=="") {layer.msg("确认密码不能为空",{icon:2,time:3000});return false};
						if (pwd!=pwd1) {layer.msg("确认密码与密码不相同！",{icon:2,time:2000});return false};
						$.post("<?php echo U('Index/zhuce');?>",{mobile:mobile,password:pwd},function(sb){
							if (sb.status==200) {
								layer.msg(sb.info,{icon:6});
								setTimeout(function () {
									window.location.href="<?php echo U('Index/index');?>";
								}, 1500);
							}else{
								layer.msg(sb.info,{icon:2,time:2000});return false;
							}
						})
					})
				})
			</script>
				<div class="nav-right fr clear">
					<a href="#shopping"><p class="fl">创业商城</p></a>
					<a href="#information"><p class="fl">资助直播</p></a>
					<a href="#live"><p class="fl">创业资讯</p></a>
					<a href="#my"><p class="fl">个人中心</p></a>
					<span class="tr"></span>
				</div>
			</div>
			<h1></h1>
		</nav>
		<!--<?php echo ($_info); ?>-->
		<div class="down-wrap maxwidth">
			<div class="down middle">
				<h1>创业商城</h1>
				<h2>这里有份资助属于你</h2>
				<div class="down-msg clear"> 
					<div class="down-iphone fl">
						<h6>已在苹果应用商店上线</h6>
						<img src="/demo1/Public/Home/images/erweima.jpg" alt="" />
						<a href="#"><div class="banner-msg"><i class="iconfont">&#xe65a;</i><p>下载苹果版本</p></div></a>
					</div>
					<div class="down-and fl">
						<h6>已在安卓应用商店上线</h6>
						<img src="/demo1/Public/Home/images/erweima.jpg" alt="" />
						<a href="#"><div class="banner-msg"><i class="iconfont">&#xe617;</i><p>下载安卓版本</p></div></a>
					</div>
				</div>
			</div>
		</div>
		
		<a id="shopping"></a>
		<div class="shopping-wrap maxwidth">
			<div class="shopping middle">
				<div class="shopping-msg">
					<div class="shop-msg-top clear">
						<div class="shop-main fl">
							<h1><i class="iconfont">&#xe686;</i>商品秒杀</h1>
							<h2>Commodity spike</h2>
							<p></p>
						</div>
						<div class="shop-main fl shop-main1 shop-active">
							<h1>千元创业区</h1>
							<h2>10元/50元/100元</h2>
						</div>
						<div class="shop-main fl shop-main1">
							<h1>万元创业区</h1>
							<h2>500元/1000元</h2>
						</div>
					</div>
					<div class="shop-msg-main" style="display: block;">
						<?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gs): $mod = ($i % 2 );++$i;?><div class="shop-submain clear">
								<div class="shop-sub-left fl">
									<img src="/demo1<?php echo ($gs["img"]); ?>" alt="" />
								</div>
								<div class="shop-sub-right fl clear">
									<div class="shop-sub-right1 fl">
										<h3><?php echo ($gs["goods_name"]); ?></h3>
										<h4>本轮已售:<span><?php echo ($gs["history"]); ?></span>个</h4>
										<h5>本轮剩余产品<span  data-sy><?php echo ($gs["surplus"]); ?></span>个</h5>
									</div>
									<div class="shop-sub-right2 fl">
										<h1>￥<span class="money"><?php echo ($gs["price"]); ?></span></h1>

											<label class="clear">
												<span class="date_jiang">-</span>
												<input type="text" value="0" placeholder="" class="commodity"/>
												<span class="date_jia">+</span>
											</label>
											<div>
												<input type="hidden" class="ids" value="<?php echo ($gs["id"]); ?>">
												<input type="submit" value="购买" class="sub1 buy-sub" idd="<?php echo ($gs["id"]); ?>"/>
											</div>

									</div>
									<div class="shop-sub-right3 fl">
										<h1><i class="iconfont">&#xe6cc;</i>品质保证</h1>
										<h1><i class="iconfont">&#xe63c;</i>支付宝支付</h1>
									</div>
								</div>

							</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="shop-msg-main">
						<?php if(is_array($goods1)): $i = 0; $__LIST__ = $goods1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gs1): $mod = ($i % 2 );++$i;?><div class="shop-submain clear">
								<div class="shop-sub-left fl">
									<img src="/demo1<?php echo ($gs1["img"]); ?>" alt="" />
								</div>
								<div class="shop-sub-right fl clear">
									<div class="shop-sub-right1 fl">
										<h3><?php echo ($gs1["goods_name"]); ?></h3>
										<h4>本轮已售:<span><?php echo ($gs1["history"]); ?></span>个</h4>
										<h5>本轮剩余产品<span data-sy><?php echo ($gs1["surplus"]); ?></span>个</h5>
									</div>
									<div class="shop-sub-right2 fl">
										<h1>￥<span class="money"><?php echo ($gs1["price"]); ?></span></h1>

											<label class="clear">
												<span class="date_jiang">-</span>
												<input type="text" value="0" placeholder="" class="commodity"/>
												<span class="date_jia">+</span>
											</label>
											<div>
												<input type="hidden" class="ids" value="<?php echo ($gs1["id"]); ?>">
												<input type="submit" value="购买" id=""  class="sub1 buy-sub" idd="<?php echo ($gs1["id"]); ?>"/>
											</div>
									</div>
									<div class="shop-sub-right3 fl">
										<h1><i class="iconfont">&#xe6cc;</i>品质保证</h1>
										<h1><i class="iconfont">&#xe63c;</i>支付宝支付</h1>
									</div>
								</div>
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
			
				</div>

			</div>
		</div>
		<!--以上是商品-->
		<a id="information"></a>
		<div class="information-wrap maxwidth">
			<div class="information middle">
				<iframe src="http://c2.web.yystatic.com/r/rc/yycomscene/main/1/35/main.swf?type=yycomscene&topSid=51157026&subSid=51157026&newtuna=1&referer=" width="1200" height="500"></iframe>
			</div>
		</div>

		<a id="live"></a>
		<div class="live-wrap maxwidth">
			<div class="live middle clear">
				<?php if(is_array($news_s)): $i = 0; $__LIST__ = $news_s;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><div class="live-msg tr fl">
						<div>
							<img src="/demo1<?php echo ($s["img"]); ?>" alt="" />
						</div>
						<h1><?php echo ($s["title"]); ?></h1>
						<p><?php echo ($s["content"]); ?></p>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>

				<div class="clearfix"></div>
				<div class="live-bottom clear">
					<?php if(is_array($news_x)): $i = 0; $__LIST__ = $news_x;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$x): $mod = ($i % 2 );++$i;?><div class="live-bottom-msg tr8 fl clear">
							<div class="fl msg-left">
								<img src="/demo1<?php echo ($x["img"]); ?>" alt="" />
							</div>
							<div class="fl msg-right">
								<h1><?php echo ($x["title"]); ?></h1>
								<p><?php echo ($x["content"]); ?></p>
							</div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>

				</div>
			</div>

		</div>

		<a id="my"></a>
		<div class="my-wrap maxwidth">
			<div class="my middle">
				<div class="middle" style="position: relative;">
				<div class="my-bai">
					<div class="my-bai-msg">
						<h1>我购买的</h1>
						<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["order_number"]); ?>
							<?php echo ($vo["g_name"]); ?><br><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="my-bai-msg">
						<h1>我的兑换码</h1>
						<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p><?php echo ($vo["order_number"]); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="my-bai-msg">
						<h1>我的中奖记录</h1>
					</div>
				</div>
				<div class="my-lan">
					<h1>商城规则</h1>
					<div class="my-lan-msg">
						<dl>
							<dt>资助细则</dt>
							<dd>
								每个被购买商品均给予购买者一个抽奖码(如购买N个,则按照N个的资助几率进行抽奖.).当所购买产品秒杀结束时,会在视频直播间开始直播抽奖.
								所有抽奖公开.
							</dd>
						</dl>
						<dl>
							<dt>千元创业区</dt>
							<dd>千元创业区内商品,单价*数量累计到达<mark>1000</mark>元,及本轮秒杀结束并开启下一轮秒杀.秒杀结束以后会在视频直播通道进行直播抽奖.

							</dd>
						</dl>
						<dl>
							<dt>万元创业区</dt>
							<dd>万元创业区内商品,单价*数量累计到达<mark>10000</mark>元,及本轮秒杀结束并开启下一轮秒杀.秒杀结束以后会在视频直播通道进行直播抽奖.

							</dd>
						</dl>
					</div>
				</div>
				</div>
			</div>
		</div>


      <form action="<?php echo U('Pay/index');?>" method="post">
		<div class="buy-hide">
			<div class="buy-off"></div>
			<div class="buy middle" style="	position: relative;background: #fff;">
				<div class="shop-submain clear" >
					<div class="shop-sub-left fl">
						<!--<img src="images/shop1.jpg" alt="" />-->
					</div>
					<div class="shop-sub-right fl clear" >
						<div class="shop-sub-right1 fl">
							<input type="hidden" name="id" value="" id="shopId">
							<input type="hidden" name="" value="<?php echo ($_SESSION['uid']); ?>" id="sess">
							<h3>暴力熊钥匙扣 编织钥匙链 男士创意女士款超人蝙蝠侠汽车腰挂挂件</h3>
							<h4>本轮已售:<span>6</span>个</h4>
							<h5>单价￥<span id="money">100.00</span>元</h5>
						</div>
						<div class="shop-sub-right2 fl">
							<h1>总价:￥<span id="all-money">100.00</span></h1>
							<!--<form action="" method="post">-->
								<label class="clear">
									<span class="buy_jiang">-</span>
									<input type="text" name="num" value="0" placeholder="" class="buy-inp"/>
									<span class="buy_jia">+</span>
								</label>
								<div>
									<input type="button" value="请确认数量" />
								</div>
							<!--</form>-->
						</div>
						<div class="shop-sub-right3 fl">
							<h1><i class="iconfont">&#xe6cc;</i>品质保证</h1>
							<h1><i class="iconfont">&#xe63c;</i>支付宝支付</h1>

						</div>
						<span id="off" class="iconfont">&#xe6a7;</span>
					</div>
				</div>
				<div class="buy-dizi">
					<p>&nbsp;收货人</p>
					<input type="text" placeholder="请输入收货人姓名" name="consignee" id="consignee"/>
					<p>&nbsp;XXX省-XXX市-XXX区-XXX街道-XXX小区</p>
					<input type="text" placeholder="请输入您的地址" name="addr" id="dizhi"/>
					<div class="clear no-yes" >
						<h6  class="buy-no">取消</h6>
						<input type="submit" class="buy-yes" value="确认购买">
						<!--<a href="#"><h6 class="buy-yes ">购买</h6></a>-->
					</div>
				</div>
			</div>
		</div>
	  </form>

		<script>
			var $height = $('.down-wrap').height()
			var $new = 0
			var sT1 = $(document).scrollTop()
			$(window).scroll(function () {
				var sT2 = $(document).scrollTop()
				if (sT2 < 108) {
					$('nav').css('top', '-60px');
					if (sT2 > sT1) {
						$('nav').css('top', 0);
					}
					sT1 = sT2;
				}
			})
			//头部内容
			$(window).scroll(function () {
				var sT3 = $(document).scrollTop()
				if (sT3 > 108) {
					$('nav').css('top', '0px');
				}
				if(sT3 >= $height){
					$('.nav-right span').css('left','0')
					$new  = 0
				}
				if(sT3 >= ($height*2)){
					$('.nav-right span').css('left','150px')
					$new  = 1
				}
				if(sT3 >= ($height*3)){
					$('.nav-right span').css('left',150*2+'px')
					$new  = 2
				}
				if(sT3 >= ($height*4)){
					$('.nav-right span').css('left',150*3+'px')
					$new  = 3
				}
			})

			// - - - - - - - - - - - - - - - - - -滚动条事件
			$(function(){

				$('.nav-right p').each(function(i){
					$(this).hover(function(){
						$('.nav-right span').css('left',150*i+'px')
					},function(){
						$('.nav-right span').css('left',150*$new+'px')
					})

				})
				/*顶部蓝色块*/
				var n = 0
				$('.date_jiang').each(function(i){
					$(this).click(function(){
						n = $('.commodity').eq(i).val()
						$('.commodity').eq(i).val(n-1)
						if(n<=0){
							$('.commodity').eq(i).val(0)
						}
						return false;
					})
				})
				$('.buy_jiang').each(function(i){
					$(this).click(function(){
						n = $('.buy-inp').eq(i).val()
						$('.buy-inp').eq(i).val(n-1)
						if(n<=0){
							$('.buy-inp').eq(i).val(0)
						}
						if((n-1)>0){
							$('#all-money').html((n-1)*$money)
						}else{
							$('#all-money').html((0)*$money)
						}

						return false;
					})
				})

				$('.date_jia').each(function(i){
					$(this).click(function(){
						n = $('.commodity').eq(i).val()
						$('.commodity').eq(i).val(parseInt(n)+1)
						if(n>100){
							$('.commodity').eq(i).val(100)
						}
						return false;
					})
				})
				$('.buy_jia').each(function(i){
					$(this).click(function(){
						n = $('.buy-inp').eq(i).val()
						$('.buy-inp').eq(i).val(parseInt(n)+1)
						if(n>100){
							$('.buy-inp').eq(i).val(100)
						}
						$('#all-money').html((n-0+1)*$money)
						return false;
					})
				})

				$('.commodity').each(function(i){
					$(this).blur(function(){
						n = $('.commodity').eq(i).val()
						if(n<=0){
							$('.commodity').eq(i).val(0)
						}
						return false;
					})
				})


				$('.buy-sub').each(function(i){
					$(this).click(function(){
						$('#money').html($('.money').eq(i).html())
						$('.shop-sub-left').eq(5).html($('.shop-sub-left').eq(i).html())
						$('.shop-sub-right1 h3').eq(5).html($('.shop-sub-right1 h3').eq(i).html())
						$('#shopId').val($('.ids').eq(i).val())
						$('.shop-sub-right1 h4 span').eq(5).html($('.shop-sub-right1 h4 span').eq(i).html())
						$money = $('#money').html()
						n = $('.commodity').eq(i).val()
						$('.buy-hide').css('display','block')
						$('.buy-inp').val(n)
						$('#all-money').html(n*$money)

						return false;
					})
				})
				$('.buy-off').click(function(){
					$('.buy-hide').css('display','none')
				})
				$('#off').click(function(){
					$('.buy-hide').css('display','none')
				})
				$('.buy-no').click(function(){
					$('.buy-hide').css('display','none')
				})
				$('.buy-yes').click(function(){
					var tr1  =$('.buy-inp').val()
					var tr2  =$('#dizhi').val()
					var tr3  =$('#consignee').val()
					var sess = $('#sess').val();
                    if(sess=='')
					{
						alert('请先登录');
						return false;
					}
					if(tr1==0){
						alert('请选择购买数量')
						return false
					}
					if(tr2 == ''){
						alert('请输入收货地址')
						return false
					}
					if(tr3 == ''){
						alert('请输入收货人姓名')
						return false
					}

				})



				$('.shop-main1').each(function(i){
					$(this).hover(function(){
						$('.shop-main1').attr('class','shop-main fl shop-main1')
						$('.shop-main1').eq(i).attr('class','shop-main fl shop-main1 shop-active')
						$('.shop-msg-main').css('display','none')
						$('.shop-msg-main').eq(i).css('display','block')
					},function(){})
				})



//				$('.sub1').each(function (i) {
//					$(this).click(function () {
//						var user_id=$_SESSION['uid'];
//						var buy_num = $('.commodity').eq(i).val();
//						var sy_num = $('span[data-sy]').eq(i).html();
//						var idd = $('.sub1').eq(i).attr('idd');
//						if(user_id==""){
//							layer.msg("登录后购买",{icon:2,time:2000});return false;
//						}
//						if(buy_num<=0){
//							layer.msg("选择购买数量",{icon:2,time:2000});return false;
//						}
//						if(buy_num>sy_num){
//							layer.msg("库存不足",{icon:2,time:2000});return false;
//						}
//					$.post("<?php echo U('Index/buy');?>",{user_id:user_id,buy_num:buy_num,id:idd},function(sb){
//
//					})
//					})
//				})

				$('.nav-left p').each(function(i){
					$(this).click(function(){

						$('.hide').css('display','none')
						$('.hide').eq(i).css('display','block')


					})
				})

				$('.hide span').click(function(){
					$('.hide').css('display','none')
				})

			})

			/*所有运行事件*/



		</script>
	</body>
</html>