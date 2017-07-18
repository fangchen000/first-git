<?php
namespace Api\Controller;
use Admin\Builder\AdminListBuilder;
use Think\Controller;
class IndexController extends Controller{


    public function getTiaoes()
    {
        $data = M('xsk_mobile_news') -> select();
        if($data)
        {
            $ret['status'] = 200;
            $ret['msg'] = '请求成功';
            $ret['data'] = $data;

        }else
        {
            $ret['status'] = 100;
            $ret['msg'] = '请求失败';
        }
        $this -> ajaxReturn($ret);
    }


    public function getTiaoeInfo()
    {
        $id = I('get.bankid');
        $data = M('xsk_mobile_news') -> where(array('id' => $id)) -> select();
        if($data)
        {
            $ret['status'] = 200;
            $ret['msg'] = '请求成功';
            $ret['data'] = $data;

        }else
        {
            $ret['status'] = 100;
            $ret['msg'] = '请求失败';
        }
        $this -> ajaxReturn($ret);
    }



    
}