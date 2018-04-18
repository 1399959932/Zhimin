<?php

class MailerUtils
{
	static public function send_mail($title, $content, $attachments, $smtp_host, $smtp_pass, $smtp_user, $receivers, $fromname = '')
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
		$log_m = new LogModel();

		if (!$mail->Send()) {
			echo '邮件发送失败了 <p>';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			$errif = $mail->ErrorInfo;
			$log_m->writeLog($title . ',发送失败,原因:' . $errif);
			exit();
		}
		else {
			$log_m->writeLog($title . ',发送成功!');
		}

		$mail->SmtpClose();
	}

	static public function system_send_mail($title, $content, $attachments)
	{
		$smtp_host = get_info('mail_host');
		$smtp_user = get_info('admin_mail');
		$smtp_pass = get_info('mail_password');
		$receivers = get_info('mail_post');
		$fromname = get_info('site');
		self::send_mail($title, $content, $attachments, $smtp_host, $smtp_pass, $smtp_user, $receivers, $fromname);
	}
}


?>
