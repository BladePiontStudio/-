<?php
//服务器配置
$mail->CharSet   = "UTF-8";                     //设定邮件编码
$mail->SMTPDebug = 0;                        // 调试模式输出
$mail->isSMTP();                             // 使用SMTP
$mail->Host       = '';           // SMTP服务器
$mail->SMTPAuth   = true;                      // 允许 SMTP 认证
$mail->Username   = '';     // SMTP 用户名  即邮箱的用户名
$mail->Password   = '';               // SMTP 密码  部分邮箱是授权码(例如163邮箱)
$mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
$mail->Port       = 25;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

$mail->setFrom('admin@bsvcoin.club', '管理员');  //发件人
$mail->addAddress('', '');  // 收件人
$mail->addReplyTo('admin@bsvcoin.club', ''); //回复的时候回复给哪个邮箱 建议和发件人一致
//Content
$mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
$mail->Subject = '测试邮件';
$mail->Body    = '欢迎使用10分钟邮箱，祝您使用愉快！'; //内容
$mail->AltBody = '欢迎使用10分钟邮箱，祝您使用愉快！';
$mail->send();