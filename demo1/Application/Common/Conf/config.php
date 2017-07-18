<?php
return array(
	//'配置项'=>'配置值'
//    'URL_MODEL' => 0,
	//'DEFAULT_TIMEZONE'=>'Asia/Shanghai',
	//模块配置
	 'APP_GROUP_LIST'=>'Admin,Home,User,Ning,Api',
    'DEFAULT_GROUP'=>'Home', 
	//数据库配置
	'DB_TYPE'      =>  'MYSQL',     // 数据库类型
    'DB_HOST'      =>  '127.0.0.1',     // 服务器地址
    'DB_NAME'      =>  'Intranet',     // 数据库名
    'DB_USER'      =>  'root',     // 用户名
    'DB_PWD'       =>  '',     // 密码
    'DB_PORT'      =>  '3306',     // 端口
    'DB_PREFIX'    =>  '',     // 数据库表前缀
    'DB_DSN'       =>  '',     // 数据库连接DSN 用于PDO方式
    'DB_CHARSET'   =>  'utf8', // 数据库的编码 默认为utf8

    'alipay_config' => array(
        'partner' => '2088521492076343', //这里是你在成功申请支付宝接口后获取到的PID；
        'key' => 'dyl9xfhyatnlaaconlzy4uuh29f8mo41', //这里是你在成功申请支付宝接口后获取到的Key
        'sign_type' => strtoupper('MD5'),
        'input_charset' => strtolower('utf-8'),
        'cacert' => getcwd() . '\\cacert.pem',
        'transport' => 'http',
    ),
//以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；
    'alipay' => array(
        //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
        'seller_email' => '',
        //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
        'notify_url' => 'http://192.168.1.100/shanchuang/index.php/Home/Pay/notifyurl',
        //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
        'return_url' => 'http://192.168.1.100/shanchuang/index.php/Home/Pay/returnurl',
        //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
        'successpage' => 'Home/IndexCenter/index',
        //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
        'errorpage' => 'Home/IndexCenter/index',
    ),
	


);