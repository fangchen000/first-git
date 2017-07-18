<?php
namespace Admin\Controller;
use Admin\Builder\AdminListBuilder;
use Think\Controller;
class RewardController extends PublicController{

    public function oneGood(){

        $model = M('reward');
        $count = $model->where(array('good_id' => 2,'is_reward' => 0))->count();
        if($count == 100)
        {
            $Page= new \Think\Page($count,10);
            $show=$Page->show();
            $vimeo = $model->where(array('good_id' => 2,'is_reward' => 0))->limit($Page->firstRow.','.$Page->listRows)->select();
//            foreach ($vimeo as &$dd){
//                $dd['add_time']=date('Y-m-d H:i:s',$dd['add_time']);
//            }

            $this->assign('page', $show);
            $this->assign("vimeo",$vimeo);
            $this->display();
        }else
        {
            $this -> assign('_info','未到抽奖时间');
            $this -> display();
        }

    }


    public function twoGood(){

        $model = M('reward');
        $count = $model->where(array('good_id' => 3,'is_reward' => 0))->count();
        if($count == 100)
        {
            $Page= new \Think\Page($count,10);
            $show=$Page->show();
            $vimeo = $model->where(array('good_id' => 3,'is_reward' => 0))->limit($Page->firstRow.','.$Page->listRows)->select();
//            foreach ($vimeo as &$dd){
//                $dd['add_time']=date('Y-m-d H:i:s',$dd['add_time']);
//            }

            $this->assign('page', $show);
            $this->assign("vimeo",$vimeo);
            $this->display();
        }else
        {
            $this -> assign('_info','未到抽奖时间');
            $this -> display();
        }

    }

    public function threeGood(){

        $model = M('reward');
        $count = $model->where(array('good_id' => 4,'is_reward' => 0))->count();
        if($count == 100)
        {
            $Page= new \Think\Page($count,10);
            $show=$Page->show();
            $vimeo = $model->where(array('good_id' => 4,'is_reward' => 0))->limit($Page->firstRow.','.$Page->listRows)->select();
//            foreach ($vimeo as &$dd){
//                $dd['add_time']=date('Y-m-d H:i:s',$dd['add_time']);
//            }

            $this->assign('page', $show);
            $this->assign("vimeo",$vimeo);
            $this->display();
        }else
        {
            $this -> assign('_info','未到抽奖时间');
            $this -> display();
        }

    }


    public function fourGood(){

        $model = M('order');
        $count = $model->where(array('good_id' => 5,'is_reward' => 0))->count();
        if($count == 100)
        {
            $Page= new \Think\Page($count,10);
            $show=$Page->show();
            $vimeo = $model->where(array('good_id' => 5,'is_reward' => 0))->limit($Page->firstRow.','.$Page->listRows)->select();
//            foreach ($vimeo as &$dd){
//                $dd['add_time']=date('Y-m-d H:i:s',$dd['add_time']);
//            }

            $this->assign('page', $show);
            $this->assign("vimeo",$vimeo);
            $this->display();
        }else
        {
            $this -> assign('_info','未到抽奖时间');
            $this -> display();
        }

    }


    public function fiveGood(){

        $model = M('order');
        $count = $model->where(array('good_id' => 6,'is_reward' => 0))->count();
        if($count == 100)
        {
            $Page= new \Think\Page($count,10);
            $show=$Page->show();
            $vimeo = $model->where(array('good_id' => 6,'is_reward' => 0))->limit($Page->firstRow.','.$Page->listRows)->select();
//            foreach ($vimeo as &$dd){
//                $dd['add_time']=date('Y-m-d H:i:s',$dd['add_time']);
//            }

            $this->assign('page', $show);
            $this->assign("vimeo",$vimeo);
            $this->display();
        }else
        {
            $this -> assign('_info','未到抽奖时间');
            $this -> display();
        }

    }


    public function endReward($id)
    {
        $result = M('reward') -> where(array('good_id' => $id)) -> setField(array('is_reward' => 1));
        if ($result) {
            $msg['info'] = $result;
            $msg['status'] = 1;
        } else {
            $msg['info'] = $result;
            $msg['status'] = 0;
        }
        $this->ajaxReturn($msg);
    }

    
}