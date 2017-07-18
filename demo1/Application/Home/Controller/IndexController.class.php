<?php
namespace Home\Controller;
//use Admin\Builder\AdminListBuilder;
use Think\Controller;
class IndexController extends Controller{

    public function getTopNews()
    {
        $data = M('xsk_link_news')-> select();
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


    public function getLinkNews()
    {
        $type = $_POST['type'];
        echo $type;
        $data = M('xsk_link_news') -> where(array('type' => $type)) -> select();
        echo M() -> _sql();

        die();
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

    public function getNews()
    {
        $type = I('post.type');
        $data = M('xsk_link_news')-> where(array('type' => $type)) -> select();
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

    public function getNewsDetail()
    {
        $id = I('post.newsId');
        $data = M('xsk_link_news')-> where(array('id' => $id)) -> select();
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