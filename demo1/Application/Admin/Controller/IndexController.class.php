<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends PublicController {
    public function index(){
//            print_r($_SESSION);
       $user= M("user")->where(array('id'=>$_SESSION['user_id']))->find();
       //当天凌晨的时间戳
        $today_zero=strtotime(date('Y-m-d',time()));

	$this->display();
	
	}
	
	public function createdo(){
		
		    $upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			$upload->savePath  =     'admin/'; // 设置附件上传（子）目录
			$upload->saveName  = array('uniqid',time().'_'.mt_rand());
			// 上传文件 
			$info   =   $upload->upload();
			if(!$info) {// 上传错误提示错误信息
				$this->ajaxReturn($upload->getError());
			}else{// 上传成功入库
				/* foreach($info as $file){
					echo $file['savepath'].$file['savename'];
				} */
			
			echo $info["fileList"]["savepath"].$info["fileList"]['savename'];	
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
	//baidu编辑器
	public function ueditor(){
        $data = new \Org\Util\Ueditor();
        echo $data->output();
    }


   


  
}