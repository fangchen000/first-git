<?php

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



?>