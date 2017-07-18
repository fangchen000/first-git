<?php

namespace Admin\Controller;

use Think\Controller;

class PublicController extends Controller {
    function __construct() {
        parent::__construct();
        // session('HTQX',null);
        if (!session('user_id')) {
          header("Content-type:text/html; charset=utf-8");
            $this->redirect('/Ning/index/index');
        }
    }
   
    public function error1() {
        layout(false);
        $this->display();
    }

    public function _empty() {
        $this->redirect('Public/error1');
    }
   

}
