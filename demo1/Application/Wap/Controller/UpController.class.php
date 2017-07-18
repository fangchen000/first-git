<?php 
namespace Home\Controller;
use Think\Controller;


class UpController extends Controller {
	
        public function index(){
		$this->display();
    }
    Public function uppic(){
    	$uu=import('Org.Net.UploadFile');
		
    	$upload = new \UploadFile();
    	$upload->autoSub = true;
    	//$upload->savename = 'excel.xls';
    	$upload->subType = 'custom';
    	//echo './upphoto/'.$_SESSION['user_id']."/";die;
    	//if ($upload->upload('./upphoto/'.$_SESSION [C('USER_AUTH_KEY')]."/")){
    	if ($upload->upload('./Upload/images/')){
    		$info = $upload->getUploadFileInfo();
    	}
    	//$upload_dir = './Temp/'.$_SESSION [C('USER_AUTH_KEY')]."/";
    	//$upload_dir = './Temp/';
    	$file_newname = $info['0']['savename'];
    	//$file_path = $upload_dir . $file_newname;
    	
    	$MAX_SIZE = 20000000;
    	if($info['0']['type'] !='image/jpeg' && $info['0']['type'] !='image/jpg' && $info['0']['type'] !='image/pjpeg' && $info['0']['type'] != 'image/png' && $info['0']['type'] != 'image/x-png'){
    		echo "2";exit;
    	}
    	if($info['0']['size']>$MAX_SIZE)
    		echo "上传的文件大小超过了规定大小";
    	
    	if($info['0']['size'] == 0)
    		echo "请选择上传的文件";	
    	switch($info['0']['error'])
    	{
    		case 0:
    			echo $file_newname;
    			break;
    		case 1:
    			echo "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";
    			break;
    		case 2:
    			echo "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
    			break;
    		case 3:
    			echo "文件只有部分被上传";
    			break;
    		case 4:
    			echo "没有文件被上传";
    			break;
    	}
    }
}