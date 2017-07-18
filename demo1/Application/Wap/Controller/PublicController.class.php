<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Wap\Controller;

use Think\Controller;

class PublicController extends Controller {

    function __construct() {
        parent::__construct();
      //会员信息
	  $us_d=session('USERID');
	  $us_id=M('user')->where("id='$us_d'")->find();
	  $this->assign("us_id",$us_id);
		//底部文章
  //获得系统参数
	 $conf=M('config')->where("id=1")->find();
     $this->assign('conf',$conf); 
	 //获得收藏
	 $mycollectcount=M('collect')->where("user_id='$us_d'")->count();
	 $this->assign("mycollectcount",$mycollectcount);
	 //我的标签数量
	 $mytagcount=M('tag')->where("user_id='$us_d' and status=1")->count();
	 $this->assign("mytagcount",$mytagcount);
	 //历史浏览
	$historycount=count(session("v_session"));

	$this->assign("historycount",$historycount);

	//获得底部信息
	$helpcate=M('helpcate')->where("is_show=1")->order("sort desc")->select();
	foreach ($helpcate as $k => $v) {
		$cat_id=$v['cat_id'];
		$helpartic=M('help')->where("is_show=1 and cat_id='$cat_id'")->order("sort desc")->select();
		$v['helpartic']=$helpartic;
	    $helpcate[$k]=$v;
	}
	$this->assign("helpcate",$helpcate);
	 
	}
	
}