<?php
namespace Wap\Controller;
use Think\Controller;
class IndexController extends PublicController {
    public function index(){ 
     $uid=session('USERID');
     if($uid){
		
      $this->redirect("User/center");
     }else{
		
     //原创经典视频
           $vimeo=M('vimeo')->where("is_commend=1 and score=0")->order("sort desc")->select();
           $this->assign("vimeo",$vimeo);   
           //经典社区视频
           $jingdian_vimeo=M('vimeo')->where("is_commend=1 and score>0")->order("sort desc")->select(); 
           $this->assign("jingdian_vimeo",$jingdian_vimeo);  
           $this->display();
    }
          
	}

      //主题的分类页面
    public function ztlist(){
        $this->display();
    }  
}