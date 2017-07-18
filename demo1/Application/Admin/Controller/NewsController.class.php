<?php
namespace Admin\Controller;
use Admin\Builder\AdminListBuilder;
use Think\Controller;
class NewsController extends PublicController{

    public function index(){


        if($_POST['title']){
           $where['title|type']=array('like',"%".$_POST['title']."%");
            $this->assign("title",$_POST['title']);
        }
        $model = M('news');
        $count = $model->where($where)->count();
        $Page= new \Think\Page($count,15);
        $show=$Page->show();
        $vimeo = $model->where($where)->order('add_time desc')->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('page', $show);
        $this->assign("vimeo",$vimeo);
        $this->display();
    }


    public function addnotice(){
        if($_POST){
//            $data=array("city"=>$_POST['city'],"province"=>$_POST['province'],"title"=>$_POST['title'],"is_commend"=>$_POST['is_commend'],"img"=>$_POST['img'],"source"=>$_POST['source'],"sort"=>$_POST['sort'],"area"=>$_POST['area'],"content"=>$_POST['content']);
            if($_POST['id']==""){
                $result=M('news')->add($_POST);
            }else{
                $result=M('news')->where(array('id'=>$_POST['id']))->save($_POST);
            }
            if($result){
                $msg['info']="操作成功";
                $msg['status']=1;
            }else{
                $msg['info']="操作失败";
                $msg['status']=0;
            }
            $this->ajaxReturn($msg);
        }else{
            $id=$_GET['id'];
            $arr=M("news")->where(array('id'=>$id))->find();
            $this->assign("news",$arr);
            $this->display();
        }
    }

    //公告推荐状态单独
    public function setvimeoonceis_commend($id){
        $status=M('news')->where("id='$id'")->getField('is_commend');
        if($status==1){
            $result=M('news')->where("id='$id'")->setField('is_commend',0);
        }else{
            $result=M('news')->where("id='$id'")->setField('is_commend',1);
        }
        if($result){
            $msg['info']="修改成功";
            $msg['status']=1;
        }else{
            $msg['info']="修改失败";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }

    //批量删除公告
    public function  delviemostatus($ids){
        $map['id']=array("in",$ids);
        $result=M('news')->where($map)->delete();
        if($result){
            $msg['info']="删除成功";
            $msg['status']=1;
        }else{
            $msg['info']="系统繁忙，请稍后再试";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }
    //删除（单）
    public function setvimeodel($id){
        $status=M('news')->where("id='$id'")->delete();
        if($status){
            $msg['info']="删除成功";
            $msg['status']=1;
        }else{
            $msg['info']="修改失败";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }
    //批量推荐，批量不推荐
    public function  delviemocommend($ids,$status){
        $map['id']=array("in",$ids);
        $result=M('news')->where($map)->setField("is_commend",$status);
        if($result){
            $msg['info']="设置成功";
            $msg['status']=1;
        }else{
            $msg['info']="系统繁忙，请稍后再试";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }

    
}