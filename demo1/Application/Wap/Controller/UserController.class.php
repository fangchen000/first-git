<?php
namespace Wap\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf8");
class UserController extends PublicController {	
  //验证码
    public function verify(){
		
		 $Verify = new \Think\Verify();
        $Verify->length   = 4;
        $Verify->fontSize = 60;
        $Verify->useCurve = false;
        // $Verify->bg=array(255,255,255);
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }
	//验证改好是否已被注册
	public function checkphone(){	
	   $username=I('post.username');
	   $pan=M('user')->where("username='$username'")->find();
	   if($pan){
		   $msg['info']="该帐号已被注册";
		   $msg['status']=1;
	   }else{
		   $msg['info']="该帐号可以使用";
		   $msg['status']=0;
	   }
	   echo json_encode($msg);
	}


	//验证邮箱
	public function checkemail(){	
	   $email=I('post.email');
	   
	   $pan=M('user')->where("email='$email'")->find();
	   if($pan){
		   $msg['info']="该邮箱已被注册";
		   $msg['status']=1;
	   }else{
		   $msg['info']="该邮箱可以使用";
		   $msg['status']=0;
	   }
	   echo json_encode($msg);
	}
//修改邮箱验证邮箱是否已被用
	public function checkemail1(){	
	 $id=session('USERID');
	   $email=I('post.email');
	   
	   $pan=M('user')->where("email='$email' and id!='$id'")->find();
	   if($pan){
		   $msg['info']="该邮箱已被注册";
		   $msg['status']=1;
	   }else{
		   $msg['info']="该邮箱可以使用";
		   $msg['status']=0;
	   }
	   echo json_encode($msg);
	}

	//验证邮箱
	public function checkuseremail(){	
	   $email=I('post.email');
	   $username=I('post.username');
	   $pan=M('user')->where("email='$email' and username='$username'")->find();
	   if($pan){
		   $msg['info']="用户名与邮箱匹配";
		   $msg['status']=1;
	   }else{
		   $msg['info']="用户名与邮箱不匹配";
		   $msg['status']=0;
	   }
	   echo json_encode($msg);
	}



//发送验证码到邮箱
     public function codemail() {
        if (I('post.')) {
            //$id=session('ID');
            //判断验证码时间是否过期时间的存储
            session('codetime', time());
            $email = I('post.email');
            $sub = "";
            $content = rand(1000, 9999);
            session('code', $content);
            $content="您好！您正在进行邮箱验证密码找回，本次请求的验证码为：
".$content."(为了保障您帐号的安全，请在5分钟内完成验证。)";

            $emails = sendMail($email, $sub, $content);

            if ($emails) {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }

            echo json_encode($data);
        }
    }


    //邮箱验证码的验证
    public function nextreg1() {
        $code = I('post.code');
        $savecode = session('code');
        $id = session('ID');
        //$id=1;
        $email= I('post.email');
        $user=M('user')->where("email='$email'")->find();
        $uid=$user['id'];
        session('phoneid', $uid);
        $codetime = session('codetime');
        $codeend = time();
        $flag = $codeend - $codetime;
        if ($flag <= 300) {
            if ($code) {
                if ($savecode == $code) {

                    $dats['status'] = 1;
                } else {
                    $dats['status'] = 0;
                }
            }
        } 
        echo json_encode($dats);
    }
//个人资料设置
public function set(){
	//如果新密码存在则验证就密码是否正确
	$uid=session('USERID');
	if(!$uid){
		$msg['info']="您已掉线请再次登录";
		$msg['status']=0;
	}else{
			if(I('post.old')!=null && I('post.newpwd')!=null){
			$oldpwd=md5(I('post.oldpwd'));
			
			$pwd=M('user')->where("id='$uid'")->getfield('password');
			if($pwd!=$oldpwd){
				$msg['info']="更改密码,初始密码不正确";
				$msg['status']=0;
			}else{
				$_POST['password']=md5(I('post.newpwd'));
				
				$rs=M('user')->where("id='$uid'")->save($_POST);
				if($rs){
					$msg['info']="设置成功";
					$msg['status']=1;
				}else{
					$msg['info']="系统繁忙，请稍候再试";
					$msg['status']=0;
				}
			}
		}else{
			  $rs=M('user')->where("id='$uid'")->save($_POST);
				if($rs){
					$msg['info']="设置成功";
					$msg['status']=1;
				}else{
					$msg['info']="系统繁忙，请稍候再试";
					$msg['status']=0;
				}
		}
	}
	
	$this->ajaxReturn($msg);
	
}
 public function mailjihuo() {
        if (I('post.')) {
            $id=session('USERID');
			$user=M('user')->where("id='$id'")->find();
            //判断验证码时间是否过期时间的存储
            session('codetime', time());
            $email = $user['email'];
			$conf=M('config')->where("id=1")->getField('title');
            $sub = $conf;
            $content = rand(1000, 9999);
            session('code', $content);
            $content="您好,激活邮箱请点击<br/>http://122.114.132.157/index.php/Home/user/jihuo/uid=".$user['id']."/jihuo/".$user['zheng_str']."";
			
            $emails = sendMail($email, $sub, $content);
            if ($emails) {
                $data['status'] = 1;
				$data['info']="请查看邮箱";
            } else {
                $data['status'] = 0;
				$data['info']="系统繁忙，请稍候再试";
            }

            echo json_encode($data);
        }
    }
	

//个人资料设置
public function setphoto(){
	//如果新密码存在则验证就密码是否正确
	$uid=session('USERID');
	if(!$uid){
		$msg['info']="您已掉线请再次登录";
		$msg['status']=0;
	}else{
		$result=M('user')->where("id='$uid'")->save($_POST);
		if($result){
			$msg['info']="头像修改成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍候再试";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
	}
}
//修改个人账户名
public function setusername(){
	$uid=session('USERID');
	if(!$uid){
		$msg['info']="您已掉线请再次登录";
		$msg['status']=0;
	}else{
		$username=I('post.username');
		//判断用户名是否已存在
		$rs=M('user')->where("username='$username' and id!=$uid")->find();
		if($rs){
			$msg['info']="用户名已存在，请更换用户名";
			$msg['status']=0;
		}else{
			$result=M('user')->where("id='$uid'")->setfield('username',$username);
			if($result){
			$msg['info']="用户名修改成功";
			$msg['status']=1;
			}else{
				$msg['info']="系统繁忙，请稍候再试";
				$msg['status']=0;
			}
		}
	}
	$this->ajaxReturn($msg);
	
}



//修改个人账户名
public function setuseremail(){
	$uid=session('USERID');
	if(!$uid){
		$msg['info']="您已掉线请再次登录";
		$msg['status']=0;
	}else{
		$email=I('post.email');
		//判断用户名是否已存在
		$rs=M('user')->where("email='$email' and id!=$uid")->find();
		if($rs){
			$msg['info']="用户名已存在，请更换用户名";
			$msg['status']=0;
		}else{
			$result=M('user')->where("id='$uid'")->setfield('email',$email);
			if($result){
			$msg['info']="邮箱修改成功";
			$msg['status']=1;
			//密码修改更换用户邮箱状态
			$content = rand(1000, 9999);
			$data=array("is_status"=>1,"zheng_str"=>$content);
			M('user')->where("id='$uid'")->save($data);
			}else{
				$msg['info']="系统繁忙，请稍候再试";
				$msg['status']=0;
			}
		}
	}
	$this->ajaxReturn($msg);
	
}

	//验证初始密码
	public function checkpwd(){	
	
	   $password=md5(I('post.oldpwd'));
	   $uid=session('USERID');
	if(!$uid){
		$msg['info']="您已掉线请再次登录";
		$msg['status']=0;
	}else{
		$pan=M('user')->where("id='$uid'")->getField('password');
	   if($pan==$password){
		   $msg['info']="初始密码正确";
		   $msg['status']=1;
	   }else{
		   $msg['info']="初始密码错误";
		   $msg['status']=0;
	   }	
	}
	echo json_encode($msg);
	   
	}
	//修改密码
	public function setuserpwd(){
		 $uid=session('USERID');
	if(!$uid){
		$msg['info']="您已掉线请再次登录";
		$msg['status']=0;
	}else{
		 $password=md5(I('post.oldpwd'));
		 $newpassword=md5(I('post.newpwd'));
	   $pan=M('user')->where("id='$uid'")->getField('password');
	   if($pan==$password){
		  $rs=M('user')->where("id='$uid'")->setfield("password",$newpassword);
		   if($pan==$password){
		   $msg['info']="密码修改成功";
		   $msg['status']=1;
		   }else{
			   $msg['info']="系统繁忙，请稍候再试";
			   $msg['status']=0;
		   }	
	   }else{
		   $msg['info']="初始密码错误";
		   $msg['status']=0;
	   }
      	   
   }
   $this->ajaxReturn($msg);
		
	}
	
	
	//确定邀请人是否存在
public function checkyao(){	
	   $yao_who=I('post.who_yao');
	   $pan=M('user')->where("yao_who='$yao_who'")->find();
	   if($pan){
		   $msg['info']="邀请码存在，可以注册";
		   $msg['status']=1;
	   }else{
		   $msg['info']="邀请码不存在请查证后在填写";
		   $msg['status']=0;
	   }
	   echo json_encode($msg);
	}
     //注册
	  public function register(){
		   if(I('post.')){
	         /*    $verify = I('post.verify');
				 if(!check_verify($verify)){
	            $msg['status']=0;
	            $msg['info']='验证码错误，请重新填写！';
		     }else{*/
                 $username=I('post.username');
				   $pan=M('user')->where("username='$username'")->find();
				if($pan){
					$msg['info']="对不起，您的注册的账号已被注册，请更换账号";
					$msg['status']=0;
		            }else{
		            	//判断邮箱是否存在
					  $email=I('post.email');
					   $rs=M('user')->where("email='$email'")->find();
					   if(!$rs){
					   	 //邀请码存在可以注册
					   	$password=md5(I('post.password'));
					   	$yao_who=substr(time(),4);
					   	$data=array("username"=>I('post.username'),"email"=>$email,"password"=>$password,"create_time"=>time());
					   	 //邀请人存在
							  $add_rs=M('user')->add($data);
							  
						   if($add_rs){
						   	session('USERID',$add_rs);

							  $msg['status']=1; 
							  $msg['info']="注册成功,正在跳转...";
							  //注册成功，存储session


                         //登陆成功，查询今天是否已有登录记录没有的话则增加，并设置期每日会员积分
							$star_time=strtotime(date("Y-m-d"));
							$end=time();
							$u_id=$rs['id'];
							$rs=M('user_login')->where("user_id='$add_rs' and create_time between $star_time and $end")->find();
							if(!$rs){
								$score=M('config')->where("id=1")->getfield("score");
								M('user')->where("id='$add_rs'")->setfield("score",$score);
                              $data=array("user_id"=>$add_rs,"create_time"=>time());
                              M('user_login')->add($data);
							}

						   }else{
							   $msg['status']=0;
							   $msg['info']="系统繁忙,请稍候";
							}
			            }else{

                           $msg['info']="对不起，您的注册的邮箱已被注册，请更换邮箱";
						   $msg['status']=0;
			            }

					}
                 /*}*/
		      $this->ajaxReturn($msg);
		   }else{
			   $this->display();
		   }
		   


	  }
	  //安全设置
	  
	  public function safe(){
		  $uid=session('USERID');
		  if(!$uid){
			 $this->redirect('User/login');
		  }else{
			  $this->display();
		  }
		  
	  }

	  
	  
	  
	  public function codephone() {
		 
        if (I('post.')) {
            session('phonetime', time());
            $mobile = I('post.username');
			
            $phones = postel($mobile);
        }
    }
	
	//忘记密码
	public function forgot(){
        $this->display();
    }
	//修改密码
	public function forgotPwd(){
		if(I('post.')){
			$uid=session("USERID");
			$phone=I("post.phone");
			$sel=M("user")->where("id='$uid'")->find();
			$ph=$sel['phone'];
			 if(I('code')!=session('code')){
				$ds['status']=2;
			}else{
			if($ph!=$phone){
				$ds['status']=4;
			}else{
				$pwd=I('post.pwd');
				$name=$sel['name'];
				//$pwd['password']=lx_ucenter_encrypt($pwd,$name);
				$pwd['password']=md5($pwd);
				$id=$sel['id'];
				$rs=M("user")->where("id='$id'")->save($pwd);
				if($rs){
					$ds['status']=1;
				}else{
					$ds['status']=0;
				}
			  }
			} 
		}else{
			$ds['status']=3;
		}
		echo json_encode($ds);
	}
	//忘记密码成功
	public function forgotsc(){
        $this->display();
    }
	  
	  
	  
	  //登录
	  public function login(){

		if(I('post.')){
			
						$password=md5(I('post.password'));
						$username=I('post.username');
						$rs=M('user')->where("username='$username' and password='$password' and status=1")->find();
						if($rs){
							session('USERID',$rs['id']);
							//登陆成功，记录登录时间
							/*$data=array("uid"=>$rs['id']);
							M('userlogin')->add($data);
							$uid=$rs['id'];*/
							/*M('user')->where("id='$uid'")->setInc("countlogin",1);*/

							$msg['info']="登陆成功";
							$msg['status']=1;

							//登陆成功，查询今天是否已有登录记录没有的话则增加，并设置期每日会员积分
							$star_time=strtotime(date("Y-m-d"));
							$end=time();
							$u_id=$rs['id'];
							$rs=M('user_login')->where("user_id='$u_id' and create_time between $star_time and $end")->find();
							if(!$rs){
								$score=M('config')->where("id=1")->getfield("score");
								M('user')->where("id='$u_id'")->setfield("score",$score);
                              $data=array("user_id"=>$u_id,"create_time"=>time());
                              M('user_login')->add($data);

							}

						}else{
							$msg['info']="您的账号密码不匹配，或是已被禁用，请联系管理员";
							$msg['status']=0;
						}	

			$this->ajaxReturn($msg);
		
		}else{
			$this->display();
		}
        
    }
	//退出登录
	public function logionout(){
		session('USERID',null);
		
		$this->redirect('Index/index');
	}

	
	//平台项目
	  public function index(){
		$uid=session('USERID');
		  if(!$uid){
			$this->redirect('User/login');
		  }else{
		  
			  $this->display();
		  }
    }
//用户中心
    public function center(){
    	$uid=session('USERID');
		  if(!$uid){
			 $this->redirect('User/login');
		  }else{
		  	$userinfo=M('user')->where("id='$uid'")->find();
		  	$this->assign("userinfo",$userinfo);
		  	$config=M('config')->where("id=1")->find();
		  	$this->assign("config",$config);
		  	
		
			  $this->display();
		  }
    }


    //创建频道

    public  function create_channel(){
      $uid=session('USERID');
		  if(!$uid){
			$this->redirect('User/login');
		  }else{
		  	if(I('post.')){
              $title=I('post.title');
              //查看该会员是否以创建过频道
		  		 $channel=M('channel')->where("title='$title'")->find();
		  		if($channel){
		  			$msg['info']="您已创建过该频道，请更换频道名";
		  			$msg['status']=0;
		  		}else{
		  			//image : image,title:title,content:content
					$data=array("image"=>I('post.image'),"user_id"=>$uid,"title"=>I('post.title'),"content"=>I('post.content'),"create_time"=>time());
					$result=M('channel')->add($data);
					if($result){
						$msg['info']="申请成功，等待管理员的审核";
						$msg['status']=1;
					}else{
						$msg['info']="系统繁忙，请稍候再试";
						$msg['status']=0;
					}
		  		}
              $this->ajaxReturn($msg);				
		  	}else{
		  		//获得个人的频道
		  		
			$model=M('channel');	
			$count = $model->where("user_id='$uid'")->count();
			$Page= new \Think\Page($count,15);
			$show=$Page->show();
			$channel = $model->where("user_id='$uid'")->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();	
			foreach($channel as $k=>$v){
				$channel_id=$v['id'];
				$v['v_count']=M('vimeo')->where("channel_id='$channel_id'")->count();
				$channel[$k]=$v;
			}
			
			   $this->assign('page', $show);
			     
		  		$this->assign("channel",$channel);
              $this->display();
		  	}
           
        }
    }

    //删除会员自己的频道

    public  function  deluserchannel(){
    	$uid=session('USERID');
    	$id=I('post.id');
    	if(!$uid){
           $msg['info']="您已掉线请重新登录";
           $msg['status']=0;

    	}else{
    		$rs=M('channel')->where("user_id='$uid' and id='$id'")->delete();
    		if($rs){
    			$msg['info']="频道删除成功";
    			$msg['status']=1;
    		}else{
    			$msg['info']="系统繁忙，请稍候再试";
    			$msg['status']=0;
    		}
    	}
    	$this->ajaxReturn($msg);
    }
 
//上传视频
public function dovimeo(){
	
	$uid=session("USERID");
	if(!$uid){
	$msg['info']="您已掉线请重新登录";
    $msg['status']=0;	
	}else{
		$_POST['url']=I('post.vid');
		$_POST['user_id']=$uid;
		$_POST['create_time']=time();
		$result=M('vimeo')->add($_POST);
		if($result){
			$msg['info']="视频上传成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍候再试";
			$msg['status']=0;
		}
		
	}
	$this->ajaxReturn($msg);
}

//我的标签

public function tag(){
	 $uid=session("USERID");
	 if(!$uid){
		$this->redirect('User/login');
	 }else{
         $tag=M('tag')->where("user_id='$uid' and status=1")->select();
         $this->assign("tag",$tag);
         $this->display();

	 }
}

//添加标签
 public function  settag($cat_id){
	 $uid=session("USERID");
	 if(!$uid){
		 $msg['info']="未登录不能添加";
		 $msg['status']=0;
	 }else{
		 $_POST['user_id']=$uid;
		 //判断该类是否已被添加
		 $pan=M('tag')->where("cat_id='$cat_id' and user_id='$uid'")->getfield('status');
		
		 if($pan==1){
			 //获得
			 $rs=M('tag')->where("cat_id='$cat_id'  and user_id='$uid'")->setfield("status",2);
			 if($rs){
				 $msg['info']="标签取消成功";
				 $msg['status']=1;
			 }else{
				 $msg['info']="系统繁忙，请稍候再试";
				 $msg['status']=0;
			 }
		 }elseif($pan==2){
			 $rs=M('tag')->where("cat_id='$cat_id' and user_id='$uid'")->setfield("status",1);
			 if($rs){
				 $msg['info']="标签添加成功";
				 $msg['status']=1;
			 }else{
				 $msg['info']="系统繁忙，请稍候再试";
				 $msg['status']=0;
			 }
		 }else{
			  $_POST['create_time']=time();
			 $result=M('tag')->add($_POST);
			 
			 if($result){
				 $msg['info']="标签添加成功";
				 $msg['status']=1;
			 }else{
				  $msg['info']="系统繁忙，请稍候再试";
				 $msg['status']=0;
			 }
		 }
		
	 }
	 $this->ajaxReturn($msg);
 }



	

	//基本信息
	public function base(){
		if(session('USERID')){
			$uid=session('USERID');
		$info=M("user")->where("id='$uid'")->find();
		
		$this->assign('info',$info);
        $this->display();
		}else{
			$this->redirect('User/login');
		} 

	}
	

	
	
	
	//编辑用户信息
	public function edit(){
		$uid=session('USERID');
		
			$info=D('User');
			$data=I('post.');
			$birthday=$_POST['year7']."-".$_POST['month7']."-".$_POST['day7'];
			$data=array("realname"=>$_POST['realname'],"sex"=>$_POST['sex'],"province"=>$_POST['province'],"city"=>$_POST['city'],"area_city"=>$_POST['area1'],"birthday"=>$birthday);
			$sv=$info->where("id='$uid'")->save($data);
			if($sv){
			  $dat['status']=1;	
			}else{
				$dat['status']=0;
			}
			echo json_encode($dat);
		
	}
	
	
	
	//处理图片上传
	 function uploads() {
        if (!empty($_FILES)) {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'swf', 'avi', 'flv');
            $upload->savePath = './av/';
            $upload->saveName = array('uniqid', '');
            $info = $upload->upload();

            if (!$info) {
                $data['status'] = 0;
                $this->error($upload->getError());
            } else {
                foreach ($info as $file) {
                    $imgpath = $file['savepath'];
                    $imgname = $file['savename'];
                    $path = $file['savepath'] . $file['savename'];
                }
                $data = $path;
                //图像缩略
                $image = new \Think\Image();
                $image->open(APP_PATH . "../Uploads/" . $path); // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg

                $path1 = $file['savepath'] . 't_' . $file['savename'];
                $image->thumb(120, 100)->save(APP_PATH . "../Uploads/" . $path1); //详情图片
            }
            echo $data;
        } else {
            $this->error('上传失败');
        }
    }
	//我的积分
	
public function upload() {
        if (!empty($_FILES)) {
            $upload = new \Think\Upload();
            $upload->maxSize = 10485760;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'swf', 'avi', 'flv');
            $upload->savePath = 'ping/';
            $upload->saveName = array('uniqid', '');
            $info = $upload->upload();
            if (!$info) {
                $data['status'] = 0;
                $this->error($upload->getError());
            } else {
                foreach ($info as $file) {
                    $imgpath = $file['savepath'];
                    $imgname = $file['savename'];
                    $path = $file['savepath'].$file['savename'];
                }

                $data = $path;

            }
            echo $data;
        } else {
            $this->error('上传失败');
        }
    }
	
	
	
	//图片上传
        public function created(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     'admin/'.CONTROLLER_NAME.'/'; // 设置附件上传（子）目录
		$upload->saveName  =array('uniqid',time().'_'.mt_rand());
		// 上传文件 
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
			$this->ajaxReturn($upload->getError());
		}else{// 上传成功入库
			$imgpath=$info["fileList"]["savepath"].$info["fileList"]['savename']."@";
			$this->ajaxReturn($imgpath,'eval');		
		}
	}
	
   //我的上传
	public function  myvimeo(){
  $uid=session('USERID');
		  if(!$uid){
			$this->redirect('User/login');
		  }else{
             //获得上传吧类型
		  	$cate=M('category')->where("parent_id=0")->select();
		  	$this->assign("cate",$cate);
            //获得我的频道
            $channel=M('channel')->where("user_id='$uid' and status=1")->select();
            $this->assign("channel",$channel);
			//我的视频
			$lo=M('vimeo');
			$count=$lo->where("user_id='$uid'")->count();
			$Page=new \Think\Page($count,15);
			$show=$Page->show();
			$vimeo=$lo->where("user_id='$uid'")->limit($page->firstRow.','.$Page->listRows)->select();
			$this->assign("page",$show);
			$this->assign("vimeo",$vimeo);
		    $this->display();
	     }
	}

	//我的收藏
	public  function mycollect(){
		 $uid=session('USERID');
		  if(!$uid){
			$this->redirect('User/login');
		  }else{
			  $lo=M('collect');
			$count=$lo->where("user_id='$uid'")->count();
			$Page=new \Think\Page($count,15);
			$show=$Page->show();
			$collect=$lo->where("user_id='$uid'")->limit($page->firstRow.','.$Page->listRows)->select();
			$this->assign("page",$show);
			$this->assign("collect",$collect);
		    $this->display();
		  }
		
		
	} 


	//删除我的收藏
	
public 	function delmycollect($id){
	$uid=session("USERID");
	if(!$uid){
		$msg['info']="您已掉线，请先登录";
		$msg['status']=0;
	}else{
		$rs=M('collect')->where("user_id='$uid' and v_id='$id'")->delete();
		if($rs){
			$msg['info']="我的收藏删除成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍候再试";
			$msg['status']=0;
		}
	}
	$this->ajaxReturn($msg);
	
}
//我的历史
public function history(){
	$uid=session('USERID');
	if(!$uid){
     $this->redirect("Wap/User/login");
	}else{
		$v_session=session('v_session');
		if($v_session){

           $map['id']=array('in',$v_session);
	        $lo=M('vimeo');
			$count=$lo->where($map)->count();
			$Page=new \Think\Page($count,15);
			$show=$Page->show();
			$history=$lo->where($map)->order("create_time desc")->limit($page->firstRow.','.$Page->listRows)->select();
           foreach ($history as $k => $v) {
                   $p_status=$v['id'];
                   $pan=M('collect')->where("v_id='$p_status' and user_id='$uid'")->find();
                   $v['pan']=$pan;
                   $history[$k]=$v;
                 }
               // dump($history);
			$this->assign("page",$show);
			$this->assign("history",$history);

		}


	
			
		    $this->display();
	}
	
} 
//删除我的历史


public function delhistory(){
$v_id=I('post.v_id');
$v_session=session('v_session');

foreach ($v_session as $k=>$v){
	           
            	if($v==$v_id){
            		unset($v_session[$k]);
            	}
            }
            session('v_session',$v_session);
           
            $msg['info']="操作成功";
            $msg['status']=1;
        $this->ajaxReturn($msg);
}


	//ajax 获得数据
  public function getcate($cat_id){
	  
	  $cateInfo=M('category')->where("parent_id='$cat_id'")->select();
	  if($cateInfo){
		 
		  foreach($cateInfo as $k=>$v){
			  $str.="<option value='".$v['cat_id']."'>".$v['cat_name']."</option>";
		  }  
	  }
	 
	  if($str){
		  $msg['info']=$str;
		  $msg['status']=1;
		 
	  }else{
		  $msg['info']="没有了";
		  $msg['status']=0;
	  }
	  $this->ajaxReturn($msg);
  }
  //批量删除视频
  public function  delmoremyvimeo($ids){
	  $map['id']=array('in',$ids);
        $rs=M('vimeo')->where($map)->delete();
		if($rs){
			$msg['info']="删除成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍候再试";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
	  }
	  //批量删除频道
	  
	  public function delmoremychannel($ids){
		   $map['id']=array('in',$ids);
        $rs=M('channel')->where($map)->delete();
		if($rs){
			$msg['info']="删除成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍候再试";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
		  
	  }
	  //批量删除我的标签
	  public function delmoremytag($ids){
		   $map['id']=array('in',$ids);
        $rs=M('tag')->where($map)->delete();
		if($rs){
			$msg['info']="删除成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍候再试";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
		  
	  }
	  //批量删除我的收藏
	  public function delmoremycollect($ids){
		   $map['id']=array('in',$ids);
        $rs=M('collect')->where($map)->delete();
		if($rs){
			$msg['info']="删除成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍候再试";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
		  
	  }
	  
	   //批量删除我的收藏
	  public function delmoremyhistory($ids){
		  // $map['id']=array('in',$ids);
		   $v_session=session('v_session');
		 
		  for($i=0;$i<count($ids);$i++){
			  $id=$ids[$i];
			  foreach ($v_session as $k=>$v){
            	if($v==$id){
            		unset($v_session[$k]);
            	}
		  }
		  
            }
			session('v_session',$v_session);
           $msg['info']="操作成功";
           $msg['status']=1;
        $this->ajaxReturn($msg);
		  
	  }
	  
	  
   

}