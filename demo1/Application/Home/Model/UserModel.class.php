<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model {
	 public function checklogin($data){
		 $name=$data['username'];
		 //$pwd=lx_ucenter_encrypt($data['password'],$name);
		 $pwd=md5($data['password']);
		 //return $pwd;
		 $usertb=M('user');
		 $email = "/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/";
            $tel = "/^13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8}$/";
            if (preg_match($email, $name)) {
				
                $selectinfo = $usertb->where("email='$name'")->find();
            }else {
                 $selectinfo = $usertb->where("username='$name'")->find();
				if(!$selectinfo){
					if(preg_match($tel, $name)){
                     $selectinfo = $usertb->where("phone='$name'")->find();
				     }
				 
				}
				
            }
			

			
		  if($selectinfo){
			  if($selectinfo['password']==$pwd){
				  //更新用户表
				
				  session('USERID',$selectinfo['id']);
				  session('USERNAME',$selectinfo['username']);
				  session('is_login',1);
				  $da=1; //登录成功
				  
			  }else{
				  $da=2;//密码错误
			  }
		  }else{
			  $da=3;//用户名不存在
		  }
		  return $da;
	 }
	 //用户订单的数量的查询
	 public function status_order($st,$status,$userid){
		// return $st=$status;
		$num=M("order_info")->where("$st=$status and user_id='$userid' and is_show=0")->count();
		return $num;
	}
	//用户信息的更改
	function edit_info($tbname,$condition,$data){
		$tbname=M($tbname);
		$rs=$tbname->where($where)->save($data);
		return $rs;
	} 
	//用户地址信息的读取
	function addr_info($tbname,$status,$limit_start,$limit_end,$uid){
		$tb=M($tbname);
		if($status==null){
		
			$addr_info=$tb->order('id desc')->where("uid='$uid'")->limit($limit_start,$limit_end)->select();
		}else{
			$addr_info=$tb->where("status='$status' and uid='$uid'")->limit($limit_start,$limit_end)->order('id desc')->select();
		}
		return $addr_info;
	}
	//对用户操作是否属于自己的内容
	public function check_self($tbname,$uid,$id){
		$tbname=M($tbname);
		$sel=$tbname->where("id='$id'")->getField('uid');
		if($sel==$uid){
			return true;
		}else{
			return false;
		}
	}
}