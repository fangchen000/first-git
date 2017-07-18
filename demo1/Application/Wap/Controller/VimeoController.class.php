<?php
namespace Wap\Controller;
use Think\Controller;

class VimeoController extends PublicController {
		public function index($id){
			$vimeo=M('vimeo')->where("id='$id'")->find();
			$this->assign("vimeo",$vimeo);
			//判断视频今天是否已被浏览
			$star_time=strtotime(date("Y-m-d"));
			$end_time=time();
			$user_id=session("USERID");
			$pan=M('user_history')->where("user_id='$user_id' and v_id='$id' and create_time between '$star_time' and '$end_time'")->find();
			if($pan){
				$this->assign("pan",$pan);
			}
			//浏览一次点击次数增加一
			M('vimeo')->where("id='$id'")->setInc("click",1);
			$cat_id=$vimeo['type_id'];
			
			$fathercate=M('category')->where("cat_id='$cat_id'")->find();
			$this->assign("fathercate",$fathercate);
			//判断该视频是否被收藏
			$uid=session('USERID');
			$collect=M('collect')->where("v_id='$id' and user_id='$uid'")->find();
			//dump($collect);
			$this->assign("collect",$collect);
			$arr=session('v_session');
			if(!in_array($id,$arr)){
			  $arr[]=$id;
             session('v_session',$arr);			  
			}
			//dump(session('v_session'));
			//相关推荐
			$recommend=M('vimeo')->where("type_id='$cat_id' and is_commend=1")->order("create_time desc")->limit("0,5")->select();
			$this->assign("recommend",$recommend);
			//视频评论 
			$lo=M('ping');
			$count=$lo->where("v_id='$id' and status=1")->count();
			$Page=new \Think\Page($count,15);
			$show=$Page->show();
			$ping=$lo->where("v_id='$id' and status=1")->limit($Page->firstRow.','.$Page->listRows)->select();
			
			$this->assign("count",$count);
			$this->assign("page",$show);
			$this->assign("vimeo",$vimeo);
			$this->assign("ping",$ping);
			$this->display();
		}

		//视频切换
		public function qie(){ 

          //判断用户是否登录
			$uid=session('USERID');
			if(!$uid){
              $msg['info']="会员没有登录,不能浏览高级视频";
              $msg['status']=0;
			}else{
				$v_id=I('post.v_id');
                   //判断该会员积分是否可以浏览该视频
				$user_score=M('user')->where("id='$uid'")->getfield('score');
				$vimeo_score=M('vimeo')->where("id='$v_id'")->getfield('score');
				if($vimeo_score>$user_score){
					$msg['info']="您的积分不足，请更换视频观看";
					$msg['status']=0;
				}else{
                    $data=array("user_id"=>$uid,"v_id"=>$v_id,"create_time"=>time(),"score"=>$vimeo_score);
                   $rs=M('user_history')->add($data);
                   if($rs){
                   	$msg['info']="可以浏览";
                   	$msg['status']=1;
                   	//视频浏览会员积分减少
                   	M('user')->where("id='$uid'")->setDec('score',$vimeo_score);
                   }else{
                   	$msg['info']="系统繁忙，请稍后操作";
                   	$msg['status']=0;
                   }

				}

			}

			$this->ajaxReturn($msg);

		}
		
			//加入收藏
	
	public function addcollect($v_id){
		$_POST['v_id']=$v_id;
		$_POST['user_id']=session('USERID');
		$uid=session('USERID');
		$_POST['create_time']=time();
		$r=M('collect')->where("v_id='$v_id' and user_id='$uid'")->find();
		$uid=session("USERID");
		if($uid){
			if($r){
			$msg['info']="您已收藏过该视频，收藏失败";
		}else{
			$result=M('collect')->add($_POST);
			if($result){
				
			    $rs=M('vimeo')->where("id='$v_id'")->find();
                 $data=array("like"=>$rs['like']+1);
               		M('vimeo')->where("id='$v_id'")->save($data);		 
			
				$msg['info']="收藏成功";
				$msg['status']=1;
			}else{
				$msg['info']="系统繁忙，请稍后操作";
				$msg['status']=0;
			}
		}
		}else{
			$msg['info']="请先登录";
			$msg['status']=0;
			
		}
		
		$this->ajaxReturn($msg);
		
	}
		public function detail($id){
			
			//获得信息
			$goodsInfo=M('goods')->where("id='$id' and is_delete=0")->find();
			
			$cat_id=$goodsInfo['cat_id'];
			$type_id=$goodsInfo['type_id'];
		     if(!$goodsInfo){
				 $this->redirect('/Home/Public/nofind');	 
			 }else{
				M('goods')->where("id='$id'")->setInc('click',1); 
			 }
		     //获得热门商品
			$img=substr($goodsInfo['goods_photo'],0,-1);
			  $img=substr($img,21); 
			  
			$arr=explode("@图片上传成功！",$img);
			for($i=0;$i<count($arr);$i++){
				$arr_photo[$i]['g_photo']=$arr[$i];
			}
			$this->assign("type_id",$type_id);
			$this->assign("arr_photo",$arr_photo);
			$this->assign("goodsInfo",$goodsInfo);
			
			$this->display();
		}
		
		//添加评论
		
		public function addping(){
			$uid=session('USERID');
			if(!$uid){
				$msg['info']="没有登录，不能评论哦...";
				$msg['status']=0;
			}else{
				
				$_POST['user_id']=$uid;
				$_POST['create_time']=time();
				
				
				$result=M('ping')->add($_POST);
				
				if($result){
					$v_id=I('post.v_id');
					M('vimeo')->where("id='$v_id'")->setInc("ping",1);
				$msg['info']="评论成功,等待审核...";
				$msg['status']=1;
				}else{
					$msg['info']="系统繁忙，请稍后操作";
					$msg['status']=0;
				}	
			}
			$this->ajaxReturn($msg);
			
		}
		
		public  function dovimeo(){
			$uid=session('USERID');
			if(!$uid){
				$msg['info']="没有登录，不能上传视频";
				$msg['status']=0;
			}else{
			$_POST['url']=$_POST['vid'];
			$_POST['create_time']=time();
			$_POST['user_id']=$uid;
			$result=M('vimeo')->add($_POST);
				if($result){
					$msg['info']="视频添加成功";
					$msg['status']=1;
				}else{
					$msg['info']="系统繁忙，请稍后操作";
					$msg['status']=0;
				}
			}
			$this->ajaxReturn($msg);
		}
		public function  vimeolist($id){
			$uid=session('USERID');
			if(!$uid){
				$this->redirect("/Home/Index/index");
			}else{
			$model=M('vimeo');	
			$count = $model->where("user_id='$uid' and channel_id='$id'")->count();
			$Page= new \Think\Page($count,15);
			$show=$Page->show();
			$vimeo = $model->where("user_id='$uid' and channel_id='$id'")->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();	
			$this->assign('page', $show);
			$this->assign("vimeo",$vimeo);
			
			$this->assign("id",$id);
			$this->display();
			}
			
		}
		
		//所有频道
		public function  all_channel(){
			$model=M('channel');	
			
			$allchannel = $model->where("status=1")->order('create_time desc')->select();	
			foreach($allchannel as $k=>$v){
				$channel_id=$v['id'];
				$v['v_count']=M('vimeo')->where("status=1 and channel_id='$channel_id'")->count();
				$allchannel[$k]=$v;
			}
			$this->assign("allchannel",$allchannel);
			$this->display();
		}
		//频道视频
		public function channel($id){
			$vimeo=M('vimeo')->where("channel_id='$id' and status=1")->select();
			$uid=session('USERID');
			foreach($vimeo as $k=>$v){
				$v_id=$v['id'];
				$pan=M('collect')->where("user_id='$uid' and v_id='$v_id'")->find();
				if($pan){
					$v['collect_user']=1;
				}else{
					$v['collect_user']=0;
				}
				$vimeo[$k]=$v;
			}
			$this->assign("vimeo",$vimeo);
			$this->assign("id",$id);
			
			$this->display();
		}
		


		
		
}