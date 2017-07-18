<?php
namespace Admin\Controller;
use Admin\Builder\AdminListBuilder;
use Think\Controller;
class GoodsController extends PublicController{

    public function index(){

        $model = M('goods');
        $count = $model->count();
        $Page= new \Think\Page($count,15);
        $show=$Page->show();
        $vimeo = $model->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach ($vimeo as &$dd){
            $dd['add_time']=date('Y-m-d H:i:s',$dd['add_time']);
        }

        $this->assign('page', $show);
        $this->assign("vimeo",$vimeo);
        $this->display();
    }

    public function addnotice(){
        if($_POST){
            if($_POST['id']==""){
                $_POST['add_time']=time();
                $result=M('goods')->add($_POST);
            }else{
                $result=M('goods')->where(array('id'=>$_POST['id']))->save($_POST);
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
            $arr=M("goods")->where(array('id'=>$id))->find();
           
            $this->assign("goods",$arr);
            $this->display();
        }
    }

    //公告推荐状态单独
    public function setvimeoonceis_commend($id){
        $status=M('goods')->where("id='$id'")->getField('is_xiajia');
        if($status==1){
            $result=M('goods')->where("id='$id'")->setField('is_xiajia',0);
        }else{
            $result=M('goods')->where("id='$id'")->setField('is_xiajia',1);
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
        $result=M('goods')->where($map)->delete();
        if($result){
            $msg['info']="删除成功";
            $msg['status']=1;
        }else{
            $msg['info']="系统繁忙，请稍后再试";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }
    //批量删除公告
    public function  setvimeodel(){
$ids=$_POST['id'];
        $result=M('goods')->where(array('id'=>$ids))->delete();
        if($result){
            $msg['info']="删除成功";
            $msg['status']=1;
        }else{
            $msg['info']="系统繁忙，请稍后再试";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);
    }
    //批量上架，下架
    public function  delviemocommend($ids,$status){
        $map['id']=array("in",$ids);
        $result=M('goods')->where($map)->setField("is_xiajia",$status);
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