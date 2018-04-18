<?php

include ('../app/core/PHPMailer.php');
function getRealSize($size)
{
	$mb = 1024;
	$gb = 1024 * $mb;
	$tb = 1024 * $gb;

	if ($size < $mb) {
		return round($size, 2) . ' MB';
	}
	else if ($size < $gb) {
		return round($size / $mb, 2) . ' GB';
	}
	else {
		return round($size / $gb, 2) . ' TB';
	}
}

function getConfVal($key)
{
	$tempval = '';
	$sqlconf = 'select t.db_value from zm_config t where t.db_config=\'' . $key . '\'';
	$configs = mysql_query($sqlconf);
	$row_c = mysql_fetch_array($configs);

	if ($row_c) {
		$tempval = $row_c['db_value'];
	}

	return $tempval;
}

function getSystemInfo($key)
{
	$tempval = '';
	$sqlconf = 'select ' . $key . ' from zm_systeminfo';
	$configs = mysql_query($sqlconf);
	$row_c = mysql_fetch_array($configs);

	if ($row_c) {
		$tempval = $row_c[$key];
	}

	return $tempval;
}

function send_mail($title, $content, $attachments, $smtp_host, $smtp_pass, $smtp_user, $receivers, $fromname = '')
{
	if (empty($smtp_host) || empty($smtp_user) || (empty($smtp_pass) | empty($receivers))) {
		return false;
	}

	$mail_address = explode(':', $smtp_host);
	$host = $mail_address[0];
	$host_prot = $mail_address[1];
	$username = $smtp_user;
	$password = $smtp_pass;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = $host;
	$mail->Port = $host_prot;
	$mail->SMTPAuth = true;
	$mail->Username = $username;
	$mail->Password = $password;
	$mail->From = $username;
	$mail->FromName = $fromname;

	if (!is_array($receivers)) {
		$mail->AddAddress($receivers, '');
	}
	else {
		foreach ($receivers as $receiver ) {
			$mail->AddAddress($receiver, '');
		}
	}

	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Encoding = 'base64';

	if (!empty($attachments)) {
		if (!is_array($attachments)) {
			$attachments = array($attachments);
		}

		foreach ($attachments as $attachment ) {
			$mail->AddAttachment($attachment);
		}
	}

	$mail->Subject = $title;
	$mail->Body = $content;

	if (!$mail->Send()) {
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		exit();
	}
	else {
		echo 'send success.';
	}

	$mail->SmtpClose();
}



?>
