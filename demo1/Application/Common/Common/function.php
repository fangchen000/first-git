<?php
date_default_timezone_set("Asia/Shanghai");

function onlyName(){
return str_replace('.','',get_client_ip()).md5(microtime(true).mt_rand(0,9));
}

function getClientRequest(){



    $data = file_get_contents('php://input');

    $request = json_decode($data,true);

    return $request;

}


//邮箱函数
//邮箱函数
function sendMail($to, $subject, $content) {

    vendor('PHPMailer.class#phpmailer');

    $mail = new PHPMailer(true);

    // 装配邮件服务器
    $mail->IsSMTP();

    $mail->Host = C('MAIL_HOST');
    // $mail->SMTPAuth = C('MAIL_SMTPAUTH');
    $mail->SMTPAuth = true;
    $mail->Username = C('MAIL_USERNAME');
    $mail->Password = C('MAIL_PASSWORD');
    // $mail->SMTPSecure = C('MAIL_SECURE');
    $mail->CharSet = C('MAIL_CHARSET');

    // 装配邮件头信息
    $mail->From = C('MAIL_USERNAME');
    $mail->AddAddress($to);
    $mail->FromName = "视频网站";
    $mail->IsHTML(C('MAIL_ISHTML'));
    // 装配邮件正文信息
    $mail->Subject = $subject;
    $mail->Body = $content;
    // 发送邮件

    if (!$mail->Send()) {
        return FALSE;
    } else {
        return TRUE;
    }
}
function CheckInputFunc($CnName, $name, $CheckType, $default = NULL, $LengMin = 0, $LengMax = 0) {
    $res ['ok'] = true;
    $res ['error'] = '';
    $res ['data'] = NULL;
    if (strpos($name, '.')) { // 指定参数来源
        list ( $method, $name ) = explode('.', $name, 2);
    } else { // 默认为自动判断
        $method = 'param';
    }
    switch (strtolower($method)) {
        case 'get' :
            $input = & $_GET;
            break;
        case 'post' :
            $input = & $_POST;
            break;
        case 'put' :
            parse_str(file_get_contents('php://input'), $input);
            break;
        case 'param' :
            switch ($_SERVER ['REQUEST_METHOD']) {
                case 'POST' :
                    $input = $_POST;
                    break;
                case 'PUT' :
                    parse_str(file_get_contents('php://input'), $input);
                    break;
                default :
                    $input = $_GET;
            }
            break;
        case 'path' :
            $input = array();
            if (!empty($_SERVER ['PATH_INFO'])) {
                $depr = C('URL_PATHINFO_DEPR');
                $input = explode($depr, trim($_SERVER ['PATH_INFO'], $depr));
            }
            break;
        case 'request' :
            $input = & $_REQUEST;
            break;
        case 'session' :
            $input = & $_SESSION;
            break;
        case 'cookie' :
            $input = & $_COOKIE;
            break;
        case 'server' :
            $input = & $_SERVER;
            break;
        case 'globals' :
            $input = & $GLOBALS;
            break;
        case 'data' :
            $input = & $datas;
            break;
        case 'file' :
            $input = & $_FILES;
            break;
        default :
            return NULL;
    }
    if (empty($name)) { // 获取全部变量
        $res ['ok'] = false;
        $res ['error'] = '方法传入参数错误！';
        return $res;
    } elseif (isset($input [$name])) { // 取值操作
        $data = $input [$name];
    } else { // 变量默认值
        $data = isset($default) ? $default : NULL;
    }

    if ($LengMin != 0) {
        if ($data == '' || $data == NULL) {
            $res ['ok'] = false;
            $res ['error'] = "请填写【 $CnName 】！";
            return $res;
        }
        if (mb_strlen($data, 'utf8') < $LengMin) {
            $res ['ok'] = false;
            $res ['error'] = "【 $CnName 】太短,请重输！";
            return $res;
        }
    } else {
        if ($data == '' || $data == NULL) {
            $res ['ok'] = true;
            $res ['data'] = $data;
            return $res;
        }
    }
    if ($LengMax != 0) {
        if (mb_strlen($data, 'utf8') > $LengMax) {
            $res ['ok'] = false;
            $res ['error'] = "【 $CnName 】太长,请重输！";
            return $res;
        }
    }

    $CKT = new CheckInput();
    $CKT->CnName = $CnName;
    $CKT->CheckType = $CheckType;
    $CKT->data = $data;
    $CKT->LengMin = $LengMin;

    return $CKT->check();
}

class CheckInput {

    var $CnName; // 中文名
    var $CheckType; // 过滤类型
    var $data; // 要过滤的变量
    var $res; // 反回的数组
    var $LengMin;
    var $postfilter = "<[^>]*?=[^>]*?&#[^>]*?>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b[^>]*?>|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    var $htcontentfilter = "<[^>]*?=[^>]*?&#[^>]*?>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b[^>]*?>|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.+?\\*\\/|<\\s*scriiipt\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

    function __construct() {
        
    }

    function check() {
        switch ($this->CheckType) {
            case 'intval' :
                $this->_intval();
                break;
            case 'date' :
                $this->_date();
                break;
            case 'time' :
                $this->_time();
                break;
            case 'datetime' :
                $this->_datetime();
                break;
            case 'password' :
                $this->_password();
                break;
            case 'string' :
                $this->_string();
                break;
            case 'enstr' :
                $this->_enstr();
                break;
            case 'numstr' :
                $this->_numstr();
                break;
            case 'ennumstr' :
                $this->_ennumstr();
                break;
            case 'cnennumstr' :
                $this->_cnennumstr();
                break;
            case 'htcontent' :
                $this->_htcontent();
                break;
            case 'float' :
                $this->_float();
                break;
            case 'bool' :
                $this->_bool();
                break;
            case 'email' :
                $this->_email();
                break;
            case 'saveimage' :
                $this->_saveimage();
                break;
            case 'uploadFile' :
                $this->_uploadFile();
                break;
            case 'shenfenzheng':
                $this->_shenfenzheng();
                break;
            default :
                // 处理特殊值 如 float(11,2)
                if ((strpos($this->CheckType, 'float')) !== false) {
                    $this->_floatex();
                } elseif (false) {
                    
                } else {
                    $this->res ['ok'] = false;
                    $this->res ['error'] = '函数过滤方法填写错误';
                }
        }
        return $this->res;
    }

    private function _saveimage() {
        if (C('CheckInputsaveimage') == NULL) {
            // echo '===================';
            $upload = new \Think\Upload (); // 实例化上传类
            $upload->autoSub = true; // 是否使用子目录保存上传文件
            $upload->subType = 'date'; // 子目录创建方式，默认为hash，可以设置为hash或者date
            $upload->dateFormat = 'd'; // 子目录方式为date的时候指定日期格式
            $upload->maxSize = 1887437; // 设置附件上传大小
            $upload->exts = array(
                'jpg',
                'gif',
                'png',
                'jpeg'
            ); // 设置附件上传类型
            $upload->rootPath = 'uploads'; // 设置附件上传根目录
            $upload->savePath = '/images/' . date('Y-m', time()) . '/'; // 设置附件上传目录
            $upload->replace = true;
            // $upload->mimes = array('image/jpeg','image/jpg','image/gif','image/png'); //允许上传的文件类型（留空为不限制）
            // $upload->callback=true;
            $info = $upload->upload();
            if (!$info) { // 上传错误提示错误信息
                $error = $upload->getError();
                if (strpos($error, '没有文件被上传') !== false) {
                    // echo '没有文件上传';
                } else {
                    $this->res ['ok'] = false;
                    $this->res ['error'] = '【 ' . $this->CnName . ' 】' . $error;
                    return 0;
                }
            }
            C('CheckInputsaveimage', $info);
        } else {
            $info = C('CheckInputsaveimage');
        }

        // dump($info);
        // dump($this->data);

        $savefile = $info [$this->data] ["savepath"] . $info [$this->data] ["savename"];

        if ($savefile == '' || $savefile == null) {
            $savefile = '';
            if ($this->LengMin > 0) {
                $this->res ['ok'] = false;
                $this->res ['error'] = '【 ' . $this->CnName . ' 】必须上传,请重输！';
                return 0;
            }
        } else {
            // $savefile='/uploads'.$savefile;
            $savefile = 'uploads' . $savefile;
        }

        $this->res ['ok'] = true;
        $this->res ['data'] = $savefile;

        // die();
        // 保存表单数据 包括附件数据
        // return $savePath.$info[0]['savename']; // 保存上传的照片根据需要自行组装
    }

    /*
     * 上传文件($_File)
     */

    private function _uploadFile() {
        $upload = new \Think\Upload (); // 实例化上传类
        $upload->autoSub = true; // 是否使用子目录保存上传文件
        $upload->subType = 'date'; // 子目录创建方式，默认为hash，可以设置为hash或者date
        $upload->dateFormat = 'd'; // 子目录方式为date的时候指定日期格式
        $upload->maxSize = 1887437; // 设置附件上传大小
        $upload->exts = array(
            'jpg',
            'gif',
            'png',
            'jpeg'
        ); // 设置附件上传类型
        $upload->rootPath = 'uploads'; // 设置附件上传根目录
        $upload->savePath = '/images/' . date('Y-m', time()) . '/'; // 设置附件上传目录
        $upload->replace = true;
        $info = $upload->upload();
        if (!$info) { // 上传错误提示错误信息
            $error = $upload->getError();
            if (strpos($error, '没有文件被上传') !== false) {
                // echo '没有文件上传';
            } else {
                $this->res ['ok'] = false;
                $this->res ['error'] = '【 ' . $this->CnName . ' 】' . $error;
                return 0;
            }
        }

        $savefile = $info [key($info)] ["savepath"] . $info [key($info)] ["savename"];

        if ($savefile == '' || $savefile == null) {
            $savefile = '';
            if ($this->LengMin > 0) {
                $this->res ['ok'] = false;
                $this->res ['error'] = '【 ' . $this->CnName . ' 】必须上传,请重输！';
                return 0;
            }
        } else {
            $savefile = 'uploads' . $savefile;
        }

        $this->res ['ok'] = true;
        $this->res ['data'] = $savefile;
    }

    private function _htcontent() {
        // if (preg_match("/".$this->htcontentfilter."/is",$this->data)==1){
        // $this->res['ok']=false;
        // $this->res['error']='【 '.$this->CnName.' 】包含非法字符,请重输！';
        // return 0;
        // }
        $this->res ['ok'] = true;
        $this->res ['data'] = ($this->data);
    }

    private function _cnennumstr() {
        if (preg_match("/" . $this->postfilter . "/is", $this->data) == 1) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】包含非法字符,请重输！';
            return 0;
        }
        // if(!preg_match("/^[0-9a-zA-Z_]{1,}$/",$this->data)){
        // if(!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$this->data)){
        if (!preg_match("/^[\x80-\xff_a-zA-Z0-9]+$/", $this->data)) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】不能包含特殊字符,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = ($this->data);
    }

    private function _string() {
        if (preg_match("/" . $this->postfilter . "/is", $this->data) == 1) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】包含非法字符,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = ($this->data);
    }

    private function _ennumstr() {
        if (preg_match("/" . $this->postfilter . "/is", $this->data) == 1) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】包含非法字符,请重输！';
            return 0;
        }
        if (!preg_match("/^[0-9a-zA-Z_]{1,}$/", $this->data)) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】只能输入数字,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _numstr() {
        if (!preg_match("/^[-]{0,1}[0-9]{1,}$/", $this->data)) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】只能输入整数,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _enstr() {
        if (preg_match("/" . $this->htcontentfilter . "/is", $this->data) == 1) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】包含非法字符,请重输！';
            return 0;
        }
        if (!preg_match("/^[a-zA-Z]{1,}$/", $this->data)) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】只能输入英文字母,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _email() {
        if (preg_match("/" . $this->postfilter . "/is", $this->data) == 1) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】包含非法字符,请重输！';
            return 0;
        }
        if (!preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/", $this->data)) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _floatex() {
        $pa = '/float\((.*),(.*)\)/';
        preg_match_all($pa, $this->CheckType, $ma);
        // dump($ma[1][0]);
        // dump($ma[2][0]);
        if (!preg_match("/^[-]{0,1}\d{0," . $ma [1] [0] . "}\.{0,1}(\d{0," . $ma [2] [0] . "})?$/", $this->data)) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】只能输入整数或小数,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _float() {
        try {
            $str = (double) ($this->data);
        } catch (Exception $e) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】只能输入整数或小数,请重输！';
            return 0;
        }
        if ((string) ($str) != $this->data) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】只能输入整数或小数,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _bool() {
        if ($this->data == 0) {
            $this->res ['data'] = 0;
        } else {
            $this->res ['data'] = 1;
        }
        $this->res ['ok'] = true;
    }

    private function _password() {
        $this->res ['ok'] = true;
        $this->res ['data'] = substr(md5($this->data), 0, 28);
    }

    private function _intval() {
        if (!preg_match("/^[-]{0,1}[0-9]{1,}$/", $this->data)) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】只能输入整数,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
        /*
         * if( strval($this->data) == strval(intval($this->data)) ){ $this->res['ok']=true; $this->res['data']=$this->data; }else{ $this->res['ok']=false; $this->res['error']='【 '.$this->CnName.' 】只能输入数字,请重输！'; }
         */
    }

    private function _date() {
        if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $this->data)) {
            if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $this->data)) {
                $this->res ['ok'] = false;
                $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
                return 0;
            }
        }
        if (strtotime($this->data) === false) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _time() {
        if (!preg_match('/^[0-2]{0,1}[0-9]{1}[:]{1}[0-5]{0,1}[0-9]{1}[:]{1}[0-5]{0,1}[0-9]{1}$/', $this->data)) {
            if (!preg_match('/^[0-2]{0,1}[0-9]{1}[:]{1}[0-5]{0,1}[0-9]{1}$/', $this->data)) {
                $this->res ['ok'] = false;
                $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
                return 0;
            }
        }
        if (strtotime($str_tmp) === false) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _datetime() {
        if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/', $this->data)) {
            if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}$/', $this->data)) {
                $this->res ['ok'] = false;
                $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
                return 0;
            }
        }
        if (strtotime($this->data) === false) {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
            return 0;
        }
        $this->res ['ok'] = true;
        $this->res ['data'] = $this->data;
    }

    private function _shenfenzheng() {
        if (ck_shengfenzheng($this->data)) {
            $this->res ['ok'] = true;
            $this->res ['data'] = $this->data;
        } else {
            $this->res ['ok'] = false;
            $this->res ['error'] = '【 ' . $this->CnName . ' 】格式错误,请重输！';
            return 0;
        }
    }

}

/**
 * 加密解密函数
 * $operation DECODE ENCODE
 * 
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

    $ckey_length = 4;

    //$key = md5($key ? $key : UC_KEY);
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * 添加规则
 */
function rulAutoAdd($str, $pid, $des = '') {
    if (empty($str) || empty($pid)) {
        $return['message'] = "参数不能为空!";
        $return['status'] = false;
        return $return;
    }
    //查找规则标识是否存在	
    $name = M()->table('__AUTH_RULE__')->where(array('name' => $str))->cache('ruleAutoAdd' . $str, 300)->field('name')->count();
    if ($name) {
        $return['message'] = "规则标识已经存在!";
        $return['status'] = false;
        return $return;
    }
    //添加规则
    $id = M()->table('__AUTH_RULE__')->add(array('name' => $str, 'pid' => $pid, 'title' => $des));
    if ($id) {
        $return['message'] = "规则标识添加成功!";
        $return['status'] = true;
        S('ruleAutoAdd' . $str, null); //删除缓存,防止出错
    } else {
        $return['message'] = "规则标识添加失败!";
        $return['status'] = false;
    }
    return $return;
}

/**
 * 权限验证
 * @param rule string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
 * @param uid  int           认证用户的id
 * @param string mode        执行check的模式
 * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
 * @return boolean           通过验证返回true;失败返回false
 * @return author            灵秀科技		2853102650
 */
function authCheck($rule, $uid, $type = 1, $mode = 'url', $relation = 'or') {
    //超级管理员跳过验证
    $auth = new \Think\Auth();
    //获取当前uid所在的角色组id
    $groups = $auth->getGroups($uid);
    session('gid', $groups[0]['group_id']); //角色组id
    session('gname', $groups[0]['title']); //角色组名称
    //设置的是一个用户对应一个角色组,所以直接取值.如果是对应多个角色组的话,需另外处理
    if (in_array($groups[0]['group_id'], C('ADMINISTRATOR'))) {
        return true;
    } else if (in_array($rule, C('NO_AUTH_RULES'))) {
        return true;
    } else {
        return $auth->check($rule, $uid, $type, $mode, $relation) ? true : false;
    }
}

/* 分页方法 */

function Page($rows, $page_size, $page) {
    $page_count = ceil($rows / $page_size);
    $rows1 = array();
    if ($page >= $page_count)
        $page = $page_count;
    if ($page <= 1 || $page == '')
        $page = 1;
    $select_limit = $page_size;
    $w_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?";
    $select_from = ($page - 1) * $page_size;
    $rows1['page_l'] = $select_from;
    $rows1['page_r'] = $select_limit;
    $pre_page = ($page == 1) ? 1 : $page - 1;
    $next_page = ($page == $page_count) ? $page_count : $page + 1;

    $pagenav .= "<a href='" . $w_url . "&page=1' class='active'>首页</a> ";
    $pagenav .= "<a href='" . $w_url . "&page=" . $pre_page . "'>前一页</a> ";
    $pagenav .= "<a href='" . $w_url . "&page=" . $next_page . "'>后一页</a> ";
    $pagenav .= "<a href='" . $w_url . "&page=" . $page_count . "'>末页</a>";
    $pagenav .= "<span>第 " . $page . "/" . $page_count . " 页 共 " . $rows . " 条 </span>";
    $pagenav.="<span>跳到&nbsp;&nbsp;<select name='topage' size='1' onchange='window.location=\"" . $w_url . "&page=\"+this.value'>\n </span>";
    for ($i = 1; $i <= $page_count; $i++) {
        if ($i == $page)
            $pagenav.="<option value='$i' selected>$i</option>\n";
        else
            $pagenav.="<option value='$i'>$i</option>\n";
    }
    $pagenav.='</select>';
    $rows1['page'] = $pagenav;
    return $rows1;
}

//在线交易订单支付处理函数
//函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
//返回值：如果订单已经成功支付，返回true，否则返回false；
function checkorderstatus($ordid) {
    $Ord = M('Order');
    $ordstatus = $Ord->where("order_sn='{$ordid}'")->getField('order_status');
    if ($ordstatus == 1) {//配货中
        return true;
    } else {
        return false;
    }
}



//处理订单函数
//更新订单状态，写入订单支付后返回的数据
function orderhandle($parameter) {
    $ordid = $parameter['out_trade_no'];
    $data['pay_id'] = $parameter['trade_no'];
    $data['pay_status'] = 1;
    //$data['payment_notify_id']     =$parameter['notify_id'];
    $data['pay_time'] = $parameter['notify_time'];
    $data['pay_method'] = 0; //支付宝支付
    //$data['payment_buyer_email']   =$parameter['buyer_email'];
    $data['order_status'] = 1;
    $Ord = M('Order');
    $Ord->where("order_sn='{$ordid}'")->save($data);

}

/* -----------------------------------
  2013.8.13更正
  下面这个函数，其实不需要，大家可以把他删掉，
  具体看我下面的修正补充部分的说明
  ------------------------------------ */

//获取一个随机且唯一的订单号；
function getordcode() {
    $Ord = M('Orderlist');
    $numbers = range(10, 99);
    shuffle($numbers);
    $code = array_slice($numbers, 0, 4);
    $ordcode = $code[0] . $code[1] . $code[2] . $code[3];
    $oldcode = $Ord->where("ordcode='" . $ordcode . "'")->getField('ordcode');
    if ($oldcode) {
        getordcode();
    } else {
        return $ordcode;
    }
}

//发送邮件函数
/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题 
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean 
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null) {
    //$config = C('THINK_EMAIL');
    vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
    $mail = new PHPMailer(); //PHPMailer对象
    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();  // 设定使用SMTP服务
    $mail->SMTPDebug = 0;                     // 关闭SMTP调试功能 // 1 = errors and messages  // 2 = messages only

    $mail->SMTPAuth = true;                  // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl';                 // 使用安全协议
    $mail->Host = C('SMTP_SERVER');  // SMTP 服务器
    $mail->Port = C('SMTP_PORT');  // SMTP服务器的端口号
    $mail->Username = C('SMTP_USER');  // SMTP服务器账号
    $mail->Password = C('SMTP_PASSWORD');  // SMTP服务器密码
    $mail->SetFrom(C('SMTP_USERMAIL'), C('SMTP_USER'));
    //邮件的回复地址
    $replyEmail = $config['REPLY_EMAIL'] ? $config['REPLY_EMAIL'] : C('SMTP_USERMAIL');
    $replyName = $config['REPLY_NAME'] ? $config['REPLY_NAME'] : C('SMTP_USER');
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}


//缩略图
function img_thumb($savepath, $savename, $path, $width, $height) {
    $image = new \Think\Image();
    $image->open(APP_PATH . "../Uploads/" . $path); // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
    $path1 = $savepath . 's_' . $savename;
    $image->thumb($width, $height)->save(APP_PATH . "../Uploads/" . $path1); //详情图片
    return $path1;
}

//验证码
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

//将阿拉伯数字转化为汉子
function num2char($num,$mode=true){

    $char = array('零','一','二','三','四','五','六','七','八','九');

    //$char = array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖);

    $dw = array('','十','百','千','','万','亿','兆');

    //$dw = array('','拾','佰','仟','','萬','億','兆');

    $dec = '点';  //$dec = '點';

    $retval = '';

    if($mode){

        preg_match_all('/^0*(\d*)\.?(\d*)/',$num, $ar);

    }else{

        preg_match_all('/(\d*)\.?(\d*)/',$num, $ar);

    }

    /* if($ar[2][0] != ''){

        $retval = $dec . ch_num($ar[2][0],false); //如果有小数，先递归处理小数

    } */

    if($ar[1][0] != ''){

        $str = strrev($ar[1][0]);

        for($i=0;$i<strlen($str);$i++) {

            $out[$i] = $char[$str[$i]];

            if($mode){

                $out[$i] .= $str[$i] != '0'? $dw[$i%4] : '';

                if($str[$i]+$str[$i-1] == 0){

                    $out[$i] = '';

                }

                if($i%4 == 0){

                    $out[$i] .= $dw[4+floor($i/4)];

                }

            }

        }

        $retval = join('',array_reverse($out)) . $retval;

    }

    return $retval;

}
//获得一个时间的星期几并用汉子表示
function xingqi($date){
    $aa=date("w",$date);
    if($aa==1){
        $bb="日";
    }elseif($aa==2){
        $bb="一";
    }elseif($aa==3){
        $bb="二";
    }elseif($aa==4){
        $bb="三";
    }elseif($aa==5){
        $bb="四";
    }elseif($aa==6){
        $bb="五";
    }elseif($aa==7){
        $bb="六";
    }
    return $bb;
    
}
 function postel($mobile){
    $flag = 0; 
    $params='';//要post的数据 
    $verify = rand(123456, 999999);//获取随机验证码
    session('phonetime', time());
    session('pverify',$verify);       

    //以下信息自己填以下
    // $mobile='$mobile';//手机号
    // dump($mobile);exit;
    $argv = array( 
        'name'=>'240122780',     //必填参数。用户账号
        'pwd'=>'8531464C2BE1CB757E97B7796B45',     //必填参数。（web平台：基本资料中的接口密码）
        'content'=>'欢迎注册虚拟交易网站账号您的验证码为：'.$verify.'有效期为5分钟，请尽快输入完成验证，为保证账号安全，请勿泄露此代码。',   //必填参数。发送内容（1-500 个汉字）UTF-8编码
        'mobile'=>$mobile,   //必填参数。手机号码。多个以英文逗号隔开
        'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
        'sign'=>'熟人商城',    //必填参数。用户签名。
        'type'=>'pt',  //必填参数。固定值 pt
        'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
    ); 
    //print_r($argv);exit;
    //构造要post的字符串 
    //echo $argv['content'];
    foreach ($argv as $key=>$value) { 
        if ($flag!=0) { 
            $params .= "&"; 
            $flag = 1; 
        } 
        $params.= $key."="; $params.= urlencode($value);// urlencode($value); 
        $flag = 1; 
    } 
    $url = "http://sms.1xinxi.cn/asmx/smsservice.aspx?".$params; //提交的url地址
    $con= substr(file_get_contents($url), 0, 1);  //获取信息发送后的状态
    
    if($con == '0'){
        $data['status'] = 1;
        } else {
        $data['status'] = 0;
        }
    echo json_encode($data);

}


//读取SEO规则
function get_seo_meta($vars,$seo)
{

    //获取还没有经过变量替换的META信息
    $meta = D('Common/SeoRule')->getMetaOfCurrentPage($seo);

    //替换META中的变量
    foreach ($meta as $key => &$value) {
        $value = seo_replace_variables($value, $vars);
    }
    unset($value);

    //返回被替换的META信息
    return $meta;
}

function seo_replace_variables($string, $vars)
{
    //如果输入的文字是空的，那就直接返回空的字符串好了。
    if (!$string) {
        return '';
    }

    //调用ThinkPHP中的解析引擎解析变量
    $view = new Think\View();
    $view->assign($vars);
    $result = $view->fetch('', $string);

    //返回替换变量后的结果
    return $result;
}
function clean_all_cache()
{
    $dirname = './Application/Runtime/';

//清文件缓存
    $dirs = array($dirname);
//清理缓存
    foreach ($dirs as $value) {
        rmdirr($value);
    }
    @mkdir($dirname, 0777, true);
}
function rmdirr($dirname)
{
    if (!file_exists($dirname)) {
        return false;
    }
    if (is_file($dirname) || is_link($dirname)) {
        return unlink($dirname);
    }
    $dir = dir($dirname);
    if ($dir) {
        while (false !== $entry = $dir->read()) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
        }
    }
    $dir->close();
    return rmdir($dirname);
}



function time_tran($the_time) {  
    $now_time = date("Y-m-d H:i:s", time());  
    //echo $now_time;   
    $now_time = strtotime($now_time);  
   $show_time = strtotime($the_time);  
   $dur = $now_time - $show_time;  
    if ($dur < 0) {  
        return $the_time;  
    } else {  
        if ($dur < 60) {  
            return $dur . '秒前';  
        } else {  
            if ($dur < 3600) {  
                return floor($dur / 60) . '分钟前';  
            } else {  
                if ($dur < 86400) {  
                    return floor($dur / 3600) . '小时前';  
                } else {  
                    if ($dur < 259200) {//3天内   
                        return floor($dur / 86400) . '天前';  
                    } else {  
                       return $the_time;  
                    }  
                }  
            }  
        }  
    }  
}

function GetfourStr($len) 
{ 
  $chars_array = array( 
    "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
    "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", 
    "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", 
    "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", 
    "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", 
    "S", "T", "U", "V", "W", "X", "Y", "Z", 
  ); 
  $charsLen = count($chars_array) - 1; 
  
  $outputstr = ""; 
  for ($i=0; $i<$len; $i++) 
  { 
    $outputstr .= $chars_array[mt_rand(0, $charsLen)]; 
  } 
  return $outputstr; 
} 


 //获城市名称
function get_cityname($id){
    $type_name=M('province')->where("code='$id'")->getfield('name');

    return $type_name;
} //获得分类名称
function getprotypename($id){
    $type_name=M('category')->where("cat_id='$id'")->getfield('cat_name');
    if($type_name==""){
        $type_name="顶级分类";
    }
    return $type_name;
}
//获得学校名称
function get_school($id){
    $type_name=M('school')->where("user_id='$id'")->getfield('school_name');
    if($type_name==""){
        $type_name="择校号平台";
    }
    return $type_name;
}

//获得学校名称
function get_mobile($id){
    $type_name=M('school')->where("user_id='$id'")->getfield('contact_mobile');
    if($type_name==""){
        $type_name="择校号平台";
    }
    return $type_name;
}
function getprotypenameall($id){
    $type_name=M('categoryall')->where("cat_id='$id'")->getfield('cat_name');
    if($type_name==""){
        $type_name="顶级分类";
    }
    return $type_name;
}

function getprotypenamekecheng($id){
    $type_name=M('catekecheng')->where("cat_id='$id'")->getfield('cat_name');
    if($type_name==""){
        $type_name="顶级分类";
    }
    return $type_name;
}




//获得会员真实姓名
 function getuserrealname($id){
	$realname=M('user')->where("id='$id'")->getfield('username');
	return $realname;
}

function getgoodname($id){
    $goodname = M('goods') -> where("id='$id'")->getfield('goods_name');
    return $goodname;
}




//获得最后一次登录
function  getendlogin($id){
    $realname=M('userlogin')->where("uid='$id'")->select();
if(!$realname){
    $str="未曾登录";

}else{
    $str=$realname[0]['create_time'];
}
    return $str;
}



//截取学校地址
function getschool_address($title){
    $des=mb_substr( $title, 0, 11, 'utf-8');
    return $des;
}


function getqq($array){
    return $array;
}

