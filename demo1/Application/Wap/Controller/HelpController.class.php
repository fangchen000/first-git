<?php
namespace Home\Controller;
use Think\Controller;

class HelpController extends PublicController {
    public function index(){
    	
    	//获得文章
		$id=I('get.id');
		$arcInfo=M('article')->where("article_id=$id")->find();
		if(!$arcInfo){
			 $this->redirect('Home/Public/nofind');
        
		}else{
			$this->assign("arcInfo",$arcInfo);
		}
		$this->assign("id",$id);
		$this->display();
	}

  

   
}