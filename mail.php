<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$body = '<h1>book your first visit today</h1>';
	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Your name</strong> '.$_POST['name'].';</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>Your e-mail:</strong> '.$_POST['email'].';</p>';
	}
	if(trim(!empty($_POST['subject']))){
		$body.='<p><strong>Subject</strong> '.$_POST['subject'].';</p>';
	}
	if(trim(!empty($_POST['message']))){
		$body.='<p><strong>Message</strong> '.$_POST['message'].';</p>';
	}

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.ti....b.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'info@vm....shag.ru'; // Логин на почте
    $mail->Password   = '........'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('info@sample.ru', 'sample.ru'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('sample@mail.ru');  
    //$mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

    // Прикрипление файлов к письму
/* if (!empty($file['name'][0])) {
    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
        $filename = $file['name'][$ct];
        if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
            $rfile[] = "Файл $filename прикреплён";
        } else {
            $rfile[] = "Не удалось прикрепить файл $filename";
        }
    }   
} */
// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = 'Message';
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);