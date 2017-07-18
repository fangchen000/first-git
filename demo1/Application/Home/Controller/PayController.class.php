<?php

namespace Home\Controller;
//namespace Vendor\Alipay;
use Think\Controller;

/**
* 直购支付类
*/
class PayController extends Controller
{
	
	function __construct(){
        parent::__construct();
	}
	/** ===========================  支付宝支付 =================================== */
	/**
	 * @desc 支付宝支付
	 * @auth : simayubo
	 */
    public function index()
    {
        //    根据传过来的数据，从数据库中查询商品相关信息
        $data = I('post.');
        $goods = M('goods');
        $res = $goods -> where(array('id' => $data['id'])) -> find();
        $res['num'] = $data['num'];
        $res['address'] = $data['addr'];
        $res['order_num'] = time().rand(100000,999999);//订单号
        $res['total'] = $res['price'] * $data['num'];
        $res['consignee'] = $data['consignee'];

//        在数据库中增加订单信息
        $order = M('order');
        $orders['user_id'] = $_SESSION['uid'];
        $orders['good_id'] = $res['id'];
        $orders['order_number'] = $res['order_num'];
        $orders['g_name'] = $res['goods_name'];
        $orders['buy_num'] = $res['num'];
        $orders['total'] = $res['total'];
        $orders['status'] = 0;
        $orders['add_time'] = time();
        $orders['address'] = $res['address'];
        $orders['consignee'] = $res['consignee'];
//        执行添加
        $order -> add($orders);

        $this -> assign('res',$res);
        $this -> display();
    }
	public function alipay(){

//        引入支付接口相关文件
		vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');


        $alipay_config = C('alipay_config');

        /*         * ************************请求参数************************* */
        $payment_type = "1"; //支付类型 //必填，不能修改
        $notify_url = C('alipay.notify_url'); //服务器异步通知页面路径
        $return_url = C('alipay.return_url'); //页面跳转同步通知页面路径C('alipay.return_url')
        $seller_email = C('alipay.seller_email'); //卖家支付宝帐户必填
        $out_trade_no = $_POST['out_trade_no']; //商户订单号 通过支付页面的表单进行传递，注意要唯一！
        $subject = $_POST['subject'];  //订单名称 //必填 通过支付页面的表单进行传递
//        $total_fee = Convert.ToDouble($res['price']) * $data['num'];   //付款金额  //必填 通过支付页面的表单进行传递
        $total_fee = $_POST['total_fee'];   //付款金额  //必填 通过支付页面的表单进行传递
        $body = $_POST['body'];  //订单描述 通过支付页面的表单进行传递
//        $show_url = $_POST['ordshow_url'];  //商品展示地址 通过支付页面的表单进行传递
        $anti_phishing_key = ""; //防钓鱼时间戳 //若要使用请调用类文件submit中的query_timestamp函数
        $exter_invoke_ip = get_client_ip(); //客户端的IP地址 
        /*         * ********************************************************* */

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "seller_id"  => trim($alipay_config['partner']),
            "payment_type" => $payment_type,
            "notify_url" => $notify_url,
            "return_url" => $return_url,
            "seller_email" => $seller_email,
            "out_trade_no" => $out_trade_no,
            "subject" => $subject,
            "total_fee" => $total_fee,
            "body" => $body,
//            "show_url" => $show_url,
            "anti_phishing_key" => $anti_phishing_key,
            "exter_invoke_ip" => $exter_invoke_ip,
            "_input_charset" => trim(strtolower($alipay_config['input_charset']))
        );
//        die();
        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "post", "确认");
        echo $html_text;
	}
	/**
	 * @desc 支付宝支付回调地址
	 * @auth : simayubo
	 */
	public function notifyurl(){
		vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');

        $alipay_config = C('alipay_config');
        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        if ($verify_result) {
            //验证成功
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            $out_trade_no = $_POST['out_trade_no'];      //商户订单号
            $trade_no = $_POST['trade_no'];          //支付宝交易号
            $trade_status = $_POST['trade_status'];      //交易状态
            $total_fee = $_POST['total_fee'];         //交易金额
            $notify_id = $_POST['notify_id'];         //通知校验ID。
            $notify_time = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
            $buyer_email = $_POST['buyer_email'];       //买家支付宝帐号；
            $parameter = array(
                "out_trade_no" => $out_trade_no, //商户订单编号；
                "trade_no" => $trade_no, //支付宝交易号；
                "total_fee" => $total_fee, //交易金额；
                "trade_status" => $trade_status, //交易状态
                "notify_id" => $notify_id, //通知校验ID。
                "notify_time" => $notify_time, //通知的发送时间。
                "buyer_email" => $buyer_email, //买家支付宝帐号；
            );
            if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                //
            } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
//                      修改订单表的订单状态为已付款
                       $order = M('order');
                       $order ->where("order_number = $out_trade_no") -> setfield('status',1);

        //                添加抽奖表，生成对应的抽奖单号
                        $res = $order -> where(array('order_number' => $out_trade_no)) -> find();
                        for($i=1;$i<=$res['buy_num'];$i++)
                        {
                            $reward = M('reward');
                            $rewards['user_id'] = $res['user_id'];
                            $rewards['good_id'] = $res['good_id'];
                            $rewards['order_num'] = $res['order_number'];
                            $rewards['reward_num'] = time().rand(100000,999999);
                            $rewards['is_reward'] = 0;
                //            执行添加
                            $reward -> add($rewards);
                        }

//                     修改商品表的库存量
                       $goods = M('goods');
                       $num2 = $reward -> where(array('good_id' => 2,'is_reward' => 0)) -> count();
                       $num3 = $reward -> where(array('good_id' => 3,'is_reward' => 0)) -> count();
                       $num4 = $reward -> where(array('good_id' => 4,'is_reward' => 0)) -> count();
                       $num5 = $reward -> where(array('good_id' => 5,'is_reward' => 0)) -> count();
                       $num6 = $reward -> where(array('good_id' => 6,'is_reward' => 0)) -> count();
                       $goods -> where("id = 2") -> setfield('history',$num2);
                       $goods -> where("id = 3") -> setfield('history',$num3);
                       $goods -> where("id = 4") -> setfield('history',$num4);
                       $goods -> where("id = 5") -> setfield('history',$num5);
                       $goods -> where("id = 6") -> setfield('history',$num6);
            }
            echo "success";        //请不要修改或删除
        } else {
            //验证失败
            echo "fail";
        }
	}

	/** ===========================  微信支付 =================================== */

    public function wxpay($order_sn) {
        if (empty(session('user_info'))) {
            $this->redirect('User/Index/login');
        }

        vendor('WxPayPubHelper.WxPayPubHelper');
        $orderInfo = M('Order')->where(array('order_sn'=>$order_sn))->find();

        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();
        $unifiedOrder->setParameter("body", "抽奖单号：".$orderInfo['order_sn']); //商品描述
        $timeStamp = time();
        $out_trade_no = $orderInfo['order_sn'];
        $unifiedOrder->setParameter("out_trade_no", $out_trade_no); //商户订单号
        $totalfee = $orderInfo['pay_fee'] * 100;
        $unifiedOrder->setParameter("total_fee", $totalfee); //总金额
        $unifiedOrder->setParameter("notify_url", C('WxPayConf_pub.zg_notify_url')); //通知地址
        $unifiedOrder->setParameter("trade_type", "NATIVE"); //交易类型
        //获取统一支付接口结果
        $unifiedOrderResult = $unifiedOrder->getResult();
        //商户根据实际情况设置相应的处理流程
        if ($unifiedOrderResult["return_code"] == "FAIL") {
            //商户自行增加处理流程
            $this->error($unifiedOrderResult['return_msg']);
            //echo "通信出错：" . $unifiedOrderResult['return_msg'] . "<br>";
        } elseif ($unifiedOrderResult["result_code"] == "FAIL") {
            //商户自行增加处理流程
            $this->error($unifiedOrderResult['err_code_des']);
            //echo "错误代码：" . $unifiedOrderResult['err_code'] . "<br>";
            //echo "错误代码描述：" . $unifiedOrderResult['err_code_des'] . "<br>";
        } elseif ($unifiedOrderResult["code_url"] != NULL) {
            $code_url = $unifiedOrderResult["code_url"];
        }

        $this->assign('unifiedOrderResult', json_encode($unifiedOrderResult));
        $this->assign('orderInfo', $orderInfo);
        $this->display("wxpay");
        //$this->ajaxReturn($unifiedOrderResult);
    }
    /**
     * @desc 微信支付回调地址
     * @auth : simayubo
     */
    public function wxpay_notify() {
        vendor('WxPayPubHelper.WxPayPubHelper');
        //使用通用通知接口
        $notify = new \Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if ($notify->checkSign() == FALSE) {
            $notify->setReturnParameter("return_code", "FAIL"); //返回状态码
            $notify->setReturnParameter("return_msg", "签名失败"); //返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS"); //设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;
        if ($notify->checkSign() == TRUE) {
            if ($notify->data["return_code"] == "FAIL") {
            } elseif ($notify->data["result_code"] == "FAIL") {
            } else {
                $out_trade_no = $notify->data['out_trade_no'];
                if(!$this->checkOrder($out_trade_no)){
                    $this->pay_success($out_trade_no,2);
                }
            }
        }
    }
    /** ===========================  京东支付 =================================== */
    function AutoReceive(){
        $key=C("jd_config.key");
        $v_oid     =trim($_POST['v_oid']);
        $v_pmode   =trim($_POST['v_pmode']);
        $v_pstatus =trim($_POST['v_pstatus']);
        $v_pstring =trim($_POST['v_pstring']);
        $v_amount  =trim($_POST['v_amount']);
        $v_moneytype  =trim($_POST['v_moneytype']);
        $remark1   =trim($_POST['remark1' ]);
        $remark2   =trim($_POST['remark2' ]);
        $v_md5str  =trim($_POST['v_md5str' ]);
        $md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
        if ($v_md5str==$md5string)
        {

            if($v_pstatus=="20")
            {
                //支付成功
                //商户系统的逻辑处理（例如判断金额，判断支付状态(20成功,30失败),更新订单状态等等）......
                if(!$this->checkOrder($v_oid)){
                    $this->pay_success($v_oid,4);
                }
            }
            echo "ok";

        }else{
            echo "error";
        }
    }
    function receive(){
        $key=C("jd_config.key");
        $v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号
        $v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）
        $v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
        $v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）；
        $v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
        $v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种
        $remark1   =trim($_POST['remark1' ]);      //备注字段1
        $remark2   =trim($_POST['remark2' ]);     //备注字段2
        $v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值
        $md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

        /**
         * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
         */


        if ($v_md5str==$md5string)
        {
            if($v_pstatus=="20")
            {
                //支付成功，可进行逻辑处理！
                //商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......
                if(!$this->checkOrder($v_oid)){
                    $this->pay_success($v_oid,4);
                }
            }else{
                echo "支付失败";
            }


        }else{
            echo "<br>校验失败,数据可疑";
        }
    }

	/**
	 * @desc 支付成功后处理订单
	 * @auth : simayubo
	 * @param [type] $order_sn
	 */
	private function pay_success($order_sn,$type){
		$res = M('Order')->where(array('order_sn' => $order_sn))->save(array('status'=>1,'pay_status'=>1,'pay_time'=>time(),'pay_method'=>$type));
        /** 增加商品销量 */
        $order_id = M('Order')->where(array('order_sn'=>$order_sn))->getField("id");
        $goods_num = M('OrderItem')->field(array('goods_id','num'))->where(array('order_id'=>$order_id))->select();
        $goodsModel = M('Goods');
        foreach ($goods_num as $key => $value) {
            $goodsModel->where(array('id'=>$value['goods_id']))->setInc('sell_num', $value['num']);
        }
		return $res;
	}
	/**
	 * @desc 验证订单是否支付成功
	 * @auth : simayubo
	 * @param [type] $order_sn
	 */
	private function checkOrder($order_sn){
		$res = M('Order')->field(array('status'))->where(array('order_sn' => $order_sn))->find();
		if ($res['status'] == 1) {
			return true;
		}else{
			return false;
		}
	}
    /**
     * @desc 验证订单状态
     * @auth : simayubo
     */
    public function checkOrderStatus($order_sn){
        // $order_sn = I('post.order_sn');
        $info = M('Order')->field(array('pay_status'))->where(array('order_sn'=>$order_sn))->find();
        if ($info['pay_status'] == 1) {
            $this->ajaxReturn(array('status'=>1, 'remark'=>'已支付'));
        }else{
            $this->ajaxReturn(array('status'=>-1, 'remark'=>'未支付'));
        }
    }
}