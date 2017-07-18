<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends PublicController {
	
	public function buy(){
		$uid=session('USERID');
		if($uid){
			$num=I('post.num');
			$price=I('post.price');
			$money=I('post.price')*I('post.num');
			$user_money=M('user')->where("id='$uid'")->getField('money');

			if($user_money<$money){
				$msg['info']="您的金币不足，请减少购买量";
				$msg['status']=0;
			}else{
				$password=md5(I('post.password'));
				$rs=M('user')->where("id='$uid' and zf_password='$password'")->find();
				if($rs){
					$r=M('sale')->where("left_score>'$num' and sale_price='$price'")->order("add_time asc")->find();
					if($r){
						//找到可以成交的数据则可以交易
						$time=time()*1000+8*3600*1000;
						$data=array("user_id"=>$uid,"buy_price"=>$price,"buy_score"=>$num,"add_time"=>$time);
						$r=M('buy')->add($data);
						
						if($rs){
							M('user')->where("id='$uid'")->setDec("money",$money);
					        M('user')->where("id='$uid'")->setInc("score",$num);
						    $msg['info']="购买成功";
						    $msg['status']=1;
						}else{
							$msg['info']="系统繁忙，请重新购买";
							$msg['status']=0;
						}
						
					}else{
						$msg['info']="没有您要求的产品";
						$msg['status']=0;
					}
					
					
					
				}else{
					$msg['info']="支付密码错误";
					$msg['status']=0;
				}
				
			}
		}else{
			$msg['info']="没有登录，不能购买";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
	}
	public  function sale(){
		$uid=session('USERID');
		if($uid){
			
			$sale_num=I('post.sale_num');
			$user_score=M('user')->where("id='$uid'")->getField('score');
			if($user_score<$sale_num){
				$msg['info']="您的数量不足，请减少卖出量";
				$msg['status']=0;
			}else{
				$password=md5(I('post.sale_password'));
				$rs=M('user')->where("id='$uid' and zf_password='$password'")->find();
				if($rs){
					$_POST['user_id']=$uid;
                    $_POST['add_time']=time()*1000;
					$_POST['sale_score']=I('post.sale_num');
					$_POST['left_score']=I('post.sale_num');
					$result=M('sale')->add($_POST);
					if($result){
						$msg['info']="卖出成功，等待买家前来购买";
						$msg['status']=1;
					}else{
						$msg['info']="卖出失败，请重新卖出";
						$msg['status']=0;
					}
				}else{
					$msg['info']="支付密码错误";
					$msg['status']=0;
				}
				
			}
		}else{
			$msg['info']="没有登录，不能购买";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
	}
} 