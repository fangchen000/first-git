<?php
namespace Wap\Controller;
use Think\Controller;

class GoodsController extends PublicController {
//视频类别
		public function index(){
			
			$keywords=$_POST['keywords'];
             if($keywords!=null){
				 
				 $where.="and cat_name like '%$keywords%'";
				 $this->assign("keywords",$keywords);
			 }
			 
			$category=M('category')->where("is_recommend=1 and parent_id=0 $where")->order("sort_order asc")->select();
			foreach($category as $k=>$v){
			$cat_id=$v['cat_id'];	
			$second=M('category')->where("is_recommend=1 and parent_id='$cat_id'")->order("sort_order asc")->select();
			$v['second']=$second;
			$category[$k]=$v;
			}

			//视频推荐
			$commend=M('vimeo')->where("cat_id=0 and is_commend=1")->find();
            $this->assign("commend",$commend);
				        $this->assign("category",$category);
			$this->display();
		}
		
		public function details($id,$keywords=null){
			
			$uid=session('USERID');
			//获得当前
			$keywords=$_GET['keywords'];
             if($keywords!=null){
				 
				 $where.="and title like '%$keywords%'";
				 $this->assign("keywords",$keywords);
			 }
			$commend=M('vimeo')->where("cat_id='$id'")->find();
            $this->assign("commend",$commend);
			$category=M('category')->where("parent_id=0 and cat_id='$id'")->find();
			$second=M('category')->where("parent_id=$id and is_recommend=1")->order("sort_order asc")->select();
			foreach ($second as $key => $value) {
				$type_id=$value['cat_id'];
				$value['v_recommend']=M('vimeo')->where("type_id='$type_id' and is_commend=1")->order("sort desc")->select();
				$arr[]=$value['cat_id'];
				$second[$key]=$value;

			}
		$str=implode(",", $arr);
			$vimeo=M('vimeo')->where("type_id in ($str) and is_commend=1 $where")->order("sort desc")->select();
        $this->assign("vimeo",$vimeo);

			//判断当前是够已被收藏
			$cat=M('tag')->where("cat_id='$id' and user_id='$uid'")->find();

			$this->assign("cat",$cat);
		    $this->assign("id",$id);
			$this->assign("second",$second);
			$this->assign("category",$category);
			
			$this->display();
		}


		//二级推荐
		public function  second($id,$keywords=null){
			$keywords=$_GET['keywords'];
             if($keywords!=null){
				 
				 $where.="and title like '%$keywords%'";
				 $this->assign("keywords",$keywords);
			 }
      $parent_id=M('category')->where("cat_id='$id'")->getfield("parent_id");

      $cate=M('category')->where("cat_id='$parent_id'")->find();
   $this->assign("id",$id);
   $second=M('category')->where("parent_id='$parent_id'")->select();
   $this->assign("second",$second);
      $this->assign("cate",$cate);
      //该类下都有哪些推荐的视频
      $vimeo=M('vimeo')->where("type_id='$id' and is_commend=1 $where")->order("sort desc")->select();
      $this->assign("vimeo",$vimeo);
       $this->display();
		}

	public function  more($id){

$uid=session('USERID');
     $parent_id=M('category')->where("cat_id='$id'")->getfield("parent_id");

      
      $cate=M('category')->where("cat_id='$parent_id'")->find();
     $this->assign("id",$id);
   if($parent_id==0){
 $vimeo=M('vimeo')->order("sort desc")->select();
   }else{
 $vimeo=M('vimeo')->where("type_id='$id'")->order("sort desc")->select();
   }

   foreach($vimeo as $k=>$v){

   $v_id=$v['id'];
   $u_collect=M('collect')->where("user_id='$uid' and v_id='$v_id'")->find();
   $v['u_collect']=$u_collect;
   $vimeo[$k]=$v;
   }
   $this->assign("parent_id",$parent_id);


  


   $second=M('category')->where("parent_id='$parent_id'")->select();

   $this->assign("second",$second);
      $this->assign("cate",$cate);


  if($parent_id==0){

     	$commend=M('vimeo')->where("is_commend=1")->order("sort desc")->limit("0,6")->select();
     }else{
     	$commend=M('vimeo')->where("type_id='$id' and is_commend=1")->order("sort desc")->limit("0,6")->select();
     }
$this->assign("commend",$commend);

      //该类下都有哪些推荐的视频
     
      //dump($vimeo);
      $this->assign("vimeo",$vimeo);

       $this->display();
		}
		
		//商品加入收藏

public function shoucang(){
	
	$user_id=$_SESSION['USERID'];
	$_POST['user_id']=$user_id;
	$_POST['goods_id']=I('goods_id');
	$goods_id=I('goods_id');
if($user_id==""){
	$msg['info']="没有登录不能收藏";
	$msg['status']=0;
	$this->ajaxReturn($msg);
	exit;
}
//判断该商品是否已被收藏
$panduan=M('collection')->where("user_id='$user_id' and goods_id='$goods_id'")->find();
if($panduan){
	$msg['info']="您已收藏";
	$msg['status']=0;
	$this->ajaxReturn($msg);
	exit;
	
}

$result=M('collection')->add($_POST);

if($result){
	$msg['info']="收藏商品成功";
	$msg['status']=1;
}else{
	$msg['info']="收藏商品失败";
	$msg['status']=0;
}
$this->ajaxReturn($msg);
	
}
	

	

		
		public function  xq($id){
			//获得信息
			$prodectInfo=M('goods')->where("id='$id' and status=1")->find();
	$typeid2=$prodectInfo['typeid2'];
	$us_id=$prodectInfo['user_id'];
		//获得产品图片
		   $typeid2=$prodectInfo['typeid2'];
		     if(!$prodectInfo){
				 $this->redirect('/Home/Public/nofind');	 
			 }else{
				M('goods')->where("id='$id'")->setInc('click',1); 
			 }
		     //获得热门商品
			 
			
			$img=substr($prodectInfo['goods_photo'],0,-1);
			  $img=substr($img,21); 
			  
			$arr=explode("@图片上传成功！",$img);
		
			for($i=0;$i<count($arr);$i++){
				$arr_photo[$i]['g_photo']=$arr[$i];
			}
			$this->assign("arr_photo",$arr_photo);
			//他还提供
			$tigong=M('goods')->where("user_id='$us_id' and status=1")->order("click desc")->select();
			$this->assign("tigong",$tigong);
			 //获得热门采购
			  $hotproInfo=M('goods')->where("typeid2='$typeid2' and status=1")->order("click desc")->select();
			  foreach($hotproInfo as $k=>$v){
			$img=substr($v['goods_photo'],0,-1);
			 $img=substr($img,21);
			  
			$arr=explode("@图片上传成功！",$img);
			
			for($i=0;$i<count($arr);$i++){
				$arr_photo[$i]['g_photo']=$arr[$i];
			}
			$v['p']=$arr_photo;
			$hotproInfo[$k]=$v;
			}
			  $this->assign("hotproInfo",$hotproInfo);
			 //获得相关供应
			 $xgproInfo=M('supply')->where("typeid2='$typeid2' and status=1")->order("create_time desc")->select();
			 $this->assign("xgproInfo",$xgproInfo);
			$this->assign("prodectInfo",$prodectInfo);
			$this->display();
			
		}
		
		
		//商品加入购物车
		public function addgoods(){
			$id=I('post.goods_id');
			$num=I('post.goods_num');
			$user_id=$_SESSION['USERID'];
			
			if(!$user_id){
				$msg['info']="清先登录，在做购买";
				$msg['status']=0;
			}else{
				
				$goods=M('goods')->where("id='$id'")->find();
				//获得商品属性的单价
				$price=$goods['price'];
                $count_money=$price*$num;
				$count=$goods['count'];
				$over_num=$goods['over_count'];
				$bb=$num+$over_num;
			
				//判断该商品是否已下架
				if($goods['status']!=1){
					
					$msg['info']="该商品未上架";
					$msg['status']=0;
					
				}elseif($count!="不限"){
					if($bb>$count){
					$msg['info']="库存不足，请减少您的购买量";
					$msg['status']=0;
					
					}elseif($goods['start_num']>$num){
						$msg['info']="购买量不能小于起购量";
						$msg['status']=0;
					}else{
						$_POST['goods_price']=$price;
						$_POST['goods_num']=$num;
						$_POST['car_money']=$count_money;
						$_POST['user_id']=$user_id;
						$_POST['goods_type']=$goods['p_type'];
						$_POST['create_time']=time();				
						$_POST['goods_id']=$id;
						$_POST['goods_name']=$goods['goods_name'];
						//判断该产品是否已被购买过，以购买过则增加数量，没有购买过则增加商品
						
						$pan=M('car')->where("user_id='$user_id' and goods_id='$id' and status=0")->find();
					
						if($pan){
							$car_id=$pan['id'];
							$result=M('car')->where("id='$car_id'")->setInc('goods_num',$num);
						}else{
							$result=M('car')->add(I('post.'));
						}
						
						
							if($result){
								$msg['info']="加入购物车";
								$msg['status']=1;
								$msg['order']=$result;
								
							}else{
								$msg['info']="加入购物车失败";
								$msg['status']=0;
							}
					
			            }
				
				}else{
					if($goods['start_num']>$num){
						$msg['info']="购买量不能小于起购量";
						$msg['status']=0;
					}else{
						$_POST['goods_price']=$price;
						$_POST['goods_num']=$num;
						$_POST['car_money']=$count_money;
						$_POST['user_id']=$user_id;
						$_POST['goods_type']=$goods['p_type'];
						$_POST['create_time']=time();				
						$_POST['goods_id']=$id;
						$_POST['goods_name']=$goods['goods_name'];
						$result=M('car')->add(I('post.'));
							if($result){
								$msg['info']="加入购物车";
								$msg['status']=1;
								$msg['order']=$result;
								
							}else{
								$msg['info']="加入购物车失败";
								$msg['status']=0;
							}
					
			            }
					
				}
			
			}	
			$this->ajaxReturn($msg);
		}
		  public function tijiao($data){
			   $uid=$_SESSION['USERID'];
			if(!$uid){
				$this->redirect('/Home/Userlr/login');
			}
			
			
			  
			 
			 /*  $ordernum="WYDZ".time().GetfourStr(4); */
              $user_id=$_SESSION['USERID'];
			  
			 for($i=0;$i<count($data);$i++){
				 $arr=explode(":",$data[$i]); 
				 $id=$arr[0];
				
				 $goods_num=$arr[1];
				 //校验数据
				 $carInfo=M('car')->where("id='$id' and user_id='$uid'")->find();
				 $goods_id=$carInfo['goods_id'];
				 $goodsInfo=M('goods')->where("id='$goods_id'")->find();
				 
				 if($carInfo){
				//获得该商品的商品剩余量  
				  $pan_count=$carInfo['over_count']+$goods_num;
				  $goods_count=$goodsInfo['count'];
				  if($goods_count=="不限"){
					  $dat['info']="可以修改";
					  $dat['status']=1;
				  }else{
						  if($goods_count>=$pan_count){
						  $dat['info']="可以修改";
						  $dat['status']=1;
					  }else{
						   $dat['info']="请检查购物车数量已经超出库存量";
						   $dat['status']=0;
						   $this->ajaxReturn($dat);
						   $rs=1;
						   exit;   
					  }
					  
				  }
				  
			  }else{
				  $dat['不是自己的数据不要进行恶意操作'];
				  $dat['status']=0;
				     $rs=2;
				  $this->ajaxReturn($dat);
				 
				  exit;
				  
			  }
			 }
			  if(!$rs){
				  for($i=0;$i<count($data);$i++){
						 $arr=explode(":",$data[$i]); 
						 $id=$arr[0];
						 $goods_num=$arr[1];
						 //校验数据
						 $goods=M('car')->where("id='$id' and user_id='$uid'")->find();
						  $_POST['goods_num']=$goods_num;
						  $_POST['car_money']=$goods['goods_price']*$goods_num;
						  M('car')->where("id='$id'")->save($_POST);
						   $c_id.=$id.'-';
				   }
				   
              $c_id=base64_encode(rtrim($c_id,'-'));
			 $dat['info']="购物车修改成功";
			 $dat['status']=1;
			 $dat['goods_id']=$c_id;
            $this->ajaxReturn($dat); 
				   
			  }else{
				  
			  }
				
			 
			 
			
			
					
			  
		  }
		  
		  public  function order(){
			  $uid=$_SESSION['USERID'];			
			if(!$uid){
				$this->redirect('/Home/Userlr/login');
			}
			$car_id=explode('-',base64_decode(I('get.id')));
			
			$id=base64_decode(I('get.id'));
			
		    $where['id']=array('in',$car_id);
			//dump($car_id);
			$orderInfo=M("car")->where($where)->select();
			//商品数量
			$count=M('car')->where($where)->count();
			//订单总额
			foreach($orderInfo as $k=>$v){	
				$count_price+=$v['car_money'];
			}
		//获得自己的收货地址
		    $first=M('useraddress')->where("user_id='$uid' and first_address=1")->select();
		    $adduserInfo=M('useraddress')->where("user_id='$uid'")->select(); 
              $this->assign("id",$id);				  
			  $this->assign("adduserInfo",$adduserInfo);
			  $this->assign("first",$first);
			  $this->assign("order_num",$order_num);
			  $this->assign("count",$count);
			  $this->assign("count_price",$count_price);
			  $this->assign("orderInfo",$orderInfo);
			  $this->display();
		  }
		
		//购物车选商品
		public function car(){
			//获得我的商品
			$uid=$_SESSION['USERID'];
			
			
			if(!$uid){
				$this->redirect('/Home/Userlr/login');
			}
			
			
			$goodsInfo=M('car')->where("user_id='$uid'")->select();
			//获得购物车的总价
			foreach($goodsInfo as $v){
				$count_price+=$v['car_money'];
			}

			$this->assign("count_price",$count_price);
			$this->assign("goodsInfo",$goodsInfo);
			$this->display();
		}
		
		//删除购物车
		public function delgoods(){
			$id=I('post.id');
			$result=M('car')->where("id='$id'")->delete();
			if($result){
				$msg['info']="删除成功";
				$msg['status']=1;
			}else{
				$msg['info']="删除失败";
				$msg['status']=0;
			}
			$this->ajaxReturn($msg);
		}
		//下订单
		public function doorder($num,$p_id,$order_type){
			  $who_order=$_SESSION['USERID'];
			  $supply=M('supply')->where("id='$p_id'")->find();
			  $order_who=$supply['user_id'];
			  
			  $order_title=$supply['typeid2'];
			  $g_id=$p_id;
			  $order_type=$order_type;
			  $add_time=time();
			  $number=$num;
			  $order_num="FHSP".time().GetfourStr(4);
			 // $data=array("who_order"=>$who_order,"order_who"=>$order_who,"order_title"=>$order_title,"g_id"=>$g_id,"order_type"=>"吨","add_time"=>$add_time,"number"=>$number,"order_num"=>$order_num,"price"=>$supply['price']);
              			 
			 if(!$who_order){
				  $msg['info']="没有登录不能下订单";
				  $msg['status']=0;
				  
			  }else{
				  $result=M('supply_order')->add($data);
				 if($result){
					$msg['info']="订单成功";
					$msg['status']=1;
				}else{
					$msg['info']="订单失败";
					$msg['status']=0;
				}
			  }
			  
			$this->ajaxReturn($msg);
		}
		
		public  function  editaddress(){	
			$address=$_POST['address'];
			$addressInfo=M('useraddress')->where("id='$address'")->find();	
			$data=array("address_pro"=>$addressInfo['province'],"address_city"=>$addressInfo['city'],"address_area"=>$addressInfo['distract'],
			"address_xq"=>$addressInfo['desc'],"address_user"=>$addressInfo['username'],"phone"=>$addressInfo['user_phone'],"address_id"=>$addressInfo
			);
			
			$order_num=$_POST['order_num'];
			$order_num1=explode("-",$order_num);
			for($i=0;$i<count($order_num1);$i++){
				$id=$order_num1[$i];
				M('order')->where("id='$id'")->save($data);
			}
		
			$msg['info']="订单确认成功";
			$msg['status']=1;
			$msg['goods_id']=$order_num;
            $this->ajaxReturn($msg);
       
		}
		public  function  jiesuan(){
			$order_sn=I('get.id');
			$order_info=M('oreder_info')->where("order_sn='$order_sn'")->find();
			$this->assign("order_info",$order_info);
		 $this->display();
			
		}
		
		
}