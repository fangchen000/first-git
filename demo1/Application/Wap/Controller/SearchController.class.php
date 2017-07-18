<?php
namespace Home\Controller;
use Think\Controller;

class SearchController extends PublicController {
		public function index(){
			
			$keywords=I('post.keywords');
             if($keywords!=""){
				
				 $where.="title like '%$keywords%'";
				 $this->assign("keywords",$keywords);
			 }			
			//视频评论 
			$lo=M('vimeo');
			$count=$lo->where("$where")->count();
			$Page= new \Think\Page($count,8);
			$show=$Page->show();
			$vimeo=$lo->where("$where")->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign("count",$count);
			$this->assign("page",$show);
			$this->assign("vimeo",$vimeo);
			$this->display();
		}

		
		
}