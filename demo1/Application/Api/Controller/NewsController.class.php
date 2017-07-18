<?php
namespace Api\Controller;
use Admin\Builder\AdminListBuilder;
use Think\Controller;
class NewsController extends Controller{


    public function getNews()
    {
        $request = getClientRequest();
        $type = $request['type'];
        $data = M('news')-> where(array('type' => $type)) -> select();
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