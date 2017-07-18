<?php
namespace Ning\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index() {
        if (session('user_id')) {
            header("location:/Admin/Index/index");
        } else {
            if(I('post.')){
                $model = M('user');
                $username = I('post.username');
                $password = I('post.password');
                $userinfo = $model -> where(array('username' => $username)) -> find();
                if($userinfo){
                    if($password != $userinfo['password']){
                        $msg['info'] = '密码错误';
                    }elseif($userinfo['status'] == 0){
                        $msg['info'] = '您没有操作权限，请联系管理员';
                    }else{
                        session('user_id',$userinfo['id']);
                        $msg['status'] = 1;
                    }
                }else{
                    $msg['info'] = '此用户不存在';
                }
                echo json_encode($msg);
            }else{
                $this -> display();
            }
        }



    }

//验证码
    public function verify($code = '') {
        $code = I('code');
        if (!$code) {
            $verify = new \Think\Verify();
            $verify->entry(2);
        } else {
            $verify = new \Think\Verify();
            $verify1 = $verify->check($code, 2);
            $verify2 = $verify1 ? 1 : 2;
            echo $verify2;
        }
    }

    #code..
    //密码修改

    public function edt() {
        $oldpwd=md5(I("post.oldpwd"));
        //获取当前的管理员
        $admin = session("adminid")? : '';
        $a_d=M("user")->where("id=$admin and password='$oldpwd'")->find();
        if(I("post.newpwd")==I("post.repwd")){
            if(!$a_d){
                $this->ajaxReturn(array('info'=>2,'msg'=>'输入的原始密码有误，请重新输入'));
            }else{
                $data['mobile']=I("post.name");
                $data['password'] = md5(I("post.newpwd"));
                $User = M("user");
                $User->where("id=$admin")->save($data);
            }
            $this->ajaxReturn(array('info'=>2,'msg'=>'密码修改成功'));
        }else{
            $this->ajaxReturn(array('info'=>2,'msg'=>'两次输入的密码不一致'));
        }
    }

    public  function  setpwd($password,$newpassword,$checkpassword){
        $password=md5($password);

        $result=M('user')->where("1=1 and password='$password'")->find();
        if($result){
            $newpassword=md5($newpassword);
            $rs=M('user')->where("1=1 and password='$password'")->setfield('password',$newpassword);
            if($rs){
                $msg['info']="密码修改成功";
                $msg['status']=1;
            }else{
                $msg['info']="密码修改失败，系统繁忙";
                $msg['status']=0;
            }

        }else{
            $msg['info']="原始密码错误";
            $msg['status']=0;
        }
        $this->ajaxReturn($msg);

    }

    //退出功能
    public function tc() {
        $admin_id = session("adminid");
        $admin = M("user");
        $data['create_time']=time();
        $data['ip']=gethostbyname($_ENV['COMPUTERNAME']);
        $admin->where("id='$admin_id'")->save($data);
        session_destroy();
        $this->redirect('/Ning/index/index');
    }

}
