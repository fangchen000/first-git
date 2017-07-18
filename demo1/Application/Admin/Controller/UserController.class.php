<?php

namespace Admin\Controller;

use Think\Controller;
use Admin\Builder\AdminListBuilder;
class UserController extends PublicController {

	//注册用户列表
	public function index(){
		if($_REQUEST['keywords']){
			$where['username']=array('like',"%".$_REQUEST['keywords']."%");
			$this->assign("keywords",$_REQUEST['keywords']);
		}
        $count = M("user")->where($where)->count();
        $Page=new \Think\Page($count,1);
        $show=$Page->show();
        $userInfo=M('user')->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('userInfo', $userInfo);
        $this->assign('page', $show);
        $this->display();
	}



//    编辑
	public function addnotice()
	{
		if ($_POST) {
			if ($_POST['id'] == "") {
				$_POST['add_time'] = time();
				$result = M('order')->add($_POST);
			} else {
				$result = M('user')->where(array('id' => $_POST['id']))->save($_POST);
			}

			if ($result) {
				$msg['info'] = "操作成功";
				$msg['status'] = 1;
			} else {
				$msg['info'] = "操作失败";
				$msg['status'] = 0;
			}
			$this->ajaxReturn($msg);
		} else {

			$id = $_GET['id'];
			$arr = M("user")->where(array('id' => $id))->find();

			$this->assign("users", $arr);
			$this->display();
		}
	}


//	删除
	public function  setvimeodel(){
		$ids=$_POST['id'];
		$result=M('user')->where(array('id'=>$ids))->delete();
		if($result){
			$msg['info']="删除成功";
			$msg['status']=1;
		}else{
			$msg['info']="系统繁忙，请稍后再试";
			$msg['status']=0;
		}
		$this->ajaxReturn($msg);
	}


 


}
