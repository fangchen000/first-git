<?php
namespace Api\Controller;
use Admin\Builder\AdminListBuilder;
use Think\Controller;
class DaikuanController extends Controller{


    public function getDaikuanList()
    {
        $loantype = I('get.loantype');
        $data = M('xsk_daikuan')-> where(array('loantype' => $loantype)) -> select();
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