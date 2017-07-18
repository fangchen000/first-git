<?php

namespace Admin\Controller;

use Think\Controller;

class AdController extends PublicController {
//广告位添加修改
    public function position(){
        if($_POST){
            $data['cad_name']=$_POST['cad_name'];
            $data['size_name']=$_POST['size_name'];
            if($_POST['id']==""){
                $result=M("adposition")->add($data);
            }else{
                $result=M("adposition")->where(array('id'=>$_POST['id']))->save($data);

            }
            if($result){
                $ret['status'] = 1;

                $ret['msg'] = '操作成功';
            }else{
                $ret['status'] = 0;
                $ret['msg'] = '操作失败';
            }


            $this->ajaxReturn($ret);
        }else{
            $id=$_GET['id'];
            $result=M("adposition")->where(array('id'=>$id))->find();
            $this->assign("brandInfo",$result);
            $this->display();
        }

    }
//广告位列表
    public function adsindex() {
        if($_POST['cad_name']){
            $where['cad_name']=array('like',"%".$_POST['cad_name']."%");
            $this->assign("cad_name",$_POST['cad_name']);
        }
        $page = I('page')? : 1;
        $count = M("adposition")->where($where)->count();
        $rpage = Page($count, 15, $page);
        $rpage1 = $rpage['page_l'];
        $rpage2 = $rpage['page_r'];
        $position = M('adposition')->where($where)->limit("$rpage1,$rpage2")->select();

        $this->assign('link', $rpage['page']);
        $this->assign('position', $position);
        $this->display();
    }


    //广告分类删除
    public function ad_delete() {
        $id = $_POST['id'];
        $result = M('adposition')->where("id='$id'")->delete();
        if ($result) {
            $msg['status'] = 1;
            $msg['info'] = "删除成功";
        } else {
            $msg['status'] = 0;
            $msg['info'] = "删除失败";
        }
        $this->ajaxReturn($msg);
        //echo json_encode($msg);
    }

    //广告位置页面
    public function adposition() {
        $page = I('page')? : 1;
        $count = M("adposition")->count();
        $rpage = Page($count, 15, $page);
        $rpage1 = $rpage['page_l'];
        $rpage2 = $rpage['page_r'];
        $position = M('adposition')->limit("$rpage1,$rpage2")->select();

        $this->assign('link', $rpage['page']);
        $this->assign('position', $position);
        $this->display();
    }

    //广告位置添加
    public function adposadd() {

        $result = M('adposition')->add($_POST);
        if ($result) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $this->ajaxReturn($data);

    }

    //广告位置修改
    public function updateadpos() {
        $id = $_POST['id'];
        $result = M('adposition')->where("id='$id'")->save($_POST);
        if ($result) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $this->ajaxReturn($data);
        //echo json_encode($data);
    }





    public function kjkjkj(){
        if(I('post.')){
            $nid=I('post.nid');
            $page = I('page')? : 1;
            $count = M("ads")->where("nid='$nid'")->count();
            $rpage = Page($count, 10, $page);
            $rpage1 = $rpage['page_l'];
            $rpage2 = $rpage['page_r'];

            $result = M('ads')->where("nid='$nid'")->limit("$rpage1,$rpage2")->select();
            $date = array();
            foreach ($result as $v) {
                $nid = $v['nid'];
                $pos = M('nav')->where("id='$nid'")->find();
                $v['posname'] = $pos['title'];
                $date[] = $v;
            }

        }else{
            $page = I('page')? : 1;
            $count = M("ads")->count();
            $rpage = Page($count, 15, $page);
            $rpage1 = $rpage['page_l'];
            $rpage2 = $rpage['page_r'];

            $result = M('ads')->limit("$rpage1,$rpage2")->select();
            $date = array();
            foreach ($result as $v) {
                $nid = $v['nid'];
                $pos = M('nav')->where("id='$nid'")->find();
                $v['posname'] = $pos['title'];
                $date[] = $v;
            }
        }
        $this->assign('result', $date);
        $this->assign('link', $rpage['page']);
        $nav=M('nav')->order('id asc')->select();
        $this->assign('nav',$nav);
    }

    //广告详情添加,修改yyyyyy
    public function adsadd() {
        $nav=M('adposition')->select();
        $this->assign('nav',$nav);




        if (I('post.')) {

                if($_POST['id']==""){
                    $data['ptime']=time();
                    $result=M('ads')->add($_POST);
                }else{
                    $result=M('ads')->where(array('id'=>$_POST['id']))->save($_POST);
                }

            if($result){
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
            $this->ajaxReturn($data);
        } else {
            if($_GET['zn']){
                $zn=$_GET['zn'];
                $this->assign('zn',$zn);
            }
            $id=$_GET['id'];
            $arr=M("ads")->where(array('id'=>$id))->find();
//            $arr['s']=explode("-",$arr['area']);
//            $arr['province']=$arr['s'][0];
//            $arr['city']=$arr['s'][1];
            //var_dump($arr);
            $this->assign("vimeo",$arr);
            $this->display();
        }
    }

    //广告详情修改
    public function adsupdate() {
        if (I('post.')) {
            $id=I('post.id');
            $date=I('post.');
            // dump($date);exit;
            $result=M('ads')->where("id='$id'")->save($date);
            if($result){
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        //echo json_encode($data);
            $this->ajaxReturn($data);
          
            
        } else {
            $id = $_GET['id'];
            $date = M('ads')->where("id='$id'")->find();
            $nid = $date['nid'];
            $pos = M('nav')->where("id='$nid'")->find();
            $date['posname'] = $pos['title'];
            $this->assign('date', $date);
            $nav = M('nav')->select();
            $this->assign('nav', $nav);
            $this->display();
        }
    }

    //广告详情删除
    public function adsdelete() {
        $id = $_GET['id'];
        $result = M('ads')->where("id='$id'")->delete();
        if ($result) {
            $this->success('删除成功',U("Ad/adsindex"),2);
        } else {
            $this->error('删除失败');
        }
    }


    //主页图片广告添加
    public function zyads(){
        if(I('post.')){
            $data=I('post.');
            $result=M('zyads')->add($data);
            if($result){
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
            $this->ajaxReturn($data);
        //echo json_encode($data);
                    
                    }else{
                        $this->display();
                }
    }


    //主页广告图片列表
    public function zylist(){

        if($_POST['title']){
            $where['title']=array('like',"%".$_POST['title']."%");
            $this->assign("title",$_POST['title']);
        }
        if($_POST['province']!=0){
            $where['province']=array('eq',$_POST['province']);
            $this->assign("province",$_POST['province']);
        }

        if($_POST['city']!=0){
            $where['city']=array('eq',$_POST['city']);
            $this->assign("city",$_POST['city']);
        }

        $page = I('page')? : 1;
        $count = M("ads")->where($where)->count();
        $rpage = Page($count, 10, $page);
        $rpage1 = $rpage['page_l'];
        $rpage2 = $rpage['page_r'];
        $zyads = M('ads')->where($where)->limit("$rpage1,$rpage2")->select();
        $this->assign('result',$zyads);
        $this->assign('page',$rpage['page']);

        $this->display();

    }
    //批量操作广告位审核通过
    public  function setordertatus($ids,$status){
        $map['id']=array("in",$ids);
        $result=M('ads')->where($map)->setField("status",$status);
        if($result){
            $msg['info']="设置成功";
            $msg['status']=1;
        }else{
            $msg['info']="系统繁忙，请稍后再试";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }
    //批量删除广告位

    public  function deluserchannel($ids){
        $map['id']=array("in",$ids);
        $result=M('ads')->where($map)->delete();
        if($result){
            $msg['info']="删除成功";
            $msg['status']=1;
        }else{
            $msg['info']="系统繁忙，请稍后再试";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }
    //单独删除频道

    public  function delchannel($ids){
        $result=M('ads')->where("id='$ids'")->delete();
        if($result){
            $msg['info']="删除成功";
            $msg['status']=1;
        }else{
            $msg['info']="系统繁忙，请稍后再试";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }

    //广告位搜索
    public  function  userchannel(){

        $model = M('ads');
        if($_POST['title']!=null){
            $title=$_POST['title'];
            $where.="and title like '%$title%'";
            $this->assign("title",$title);
        }

        if($_POST['status']!=0){
            $status=I('post.status');
            $where.="and status='$status'";
            $this->assign("status",$status);
        }
        $count = $model->where("1=1 $where")->count();
        $Page= new \Think\Page($count,15);
        $show=$Page->show();
        $channel = $model->where("1=1 $where")->order('ptime desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('page', $show);
        $this->assign("channel",$channel);
        $this->display();

    }

    //主页广告图片编辑
    public function upzyads(){
        if(I('post.')){
            $id=I('post.id');
            $data=I('post.');
            $data['ptime']=time();

            $result=M('zyads')->where("id='$id'")->save($data);
            if($result){
                 $data['status'] = 1;
        } else {
                 $data['status'] = 0;
        }
       // echo json_encode($data);
            $this->ajaxReturn($data);
        }else{
            $id=I('get.id');
            $zyads=M('zyads')->where("id='$id'")->find();
            $this->assign('zyads',$zyads);
            $this->display();
        }

    }

    //主页广告图片删除
    public function zyadsdel(){
        $id=I('get.id');
        $result=M('zyads')->where("id='$id'")->delete();
        if($result){
            $this->redirect('Ad/zylist');
        }else{
            $this->error('删除失败！');
        }
    }

     //上传图片处理
    public function upload() {
        if ($_FILES['upload']['error'] === 0) {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'swf', 'avi', 'flv');
            $upload->savePath = './zyads/';
            $upload->saveName = array('uniqid', '');
            $info = $upload->upload();
            if (!$info) {
                $this->error($upload->getError());
            } else {
                foreach ($info as $file) {
                    $imgpath = $file['savepath'];
                    $imgname = $file['savename'];
                    $path = $file['savepath'] . $file['savename'];
                }
                $this->ajaxReturn(array('info' => 1, 'path' => $path));
                //echo json_encode(array('info' => 1, 'path' => $path));
            }
        } else {
            $this->error('上传失败');
        }
    }
	//店铺新闻
	public  function shopnews(){
		 
	$count = M("shopnews")->count();
     $Page=new \Think\Page($count,10);
	 $show=$Page->show();
	$newsInfo=M('shopnews')->limit($Page->firstRow.','.$Page->listRows)->order("create_time desc")->select();
	  foreach($newsInfo as $k=>$v){
			$img=substr($v['litpic'],0,-1);
			 $img=substr($img,21);
			  
			$arr=explode("@图片上传成功！",$img);
			
			for($i=0;$i<count($arr);$i++){
				$arr_photo[$i]['g_photo']=$arr[$i];
			}
			$v['o']=$arr_photo;
			$newsInfo[$k]=$v;
			}
	$this->assign('count',$count);
	$this->assign("newsInfo",$newsInfo);
	 $this->assign('page',$show);
	$this->display();
	}
	
	public function  editor(){
		$id=I('get.id');
		$newsInfo=M('shopnews')->where("id='$id'")->find();
		$litpic=explode("@图片上传成功！",substr(substr($newsInfo['litpic'],0,-1),21));
		$this->assign("litpic",$litpic);
		$this->assign("newsInfo",$newsInfo);
		$this->display();
		
	}

}
