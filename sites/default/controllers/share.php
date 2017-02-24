<?php
class Share_Controller extends Bl_Controller
{
	public function init()
	{
	}
	
	public function callbackAction($serviceName = null) {
		$ret = array(
			'success' => false
		);
		if ($this->isPost()) {
			$post = $_POST;
			if (isset($post['pid'])) {
				if (!isset($_SESSION['user'])) {
					$_SESSION['user'] = new stdClass();
				}
				if (!isset($_SESSION['user']->shared)) {
					$_SESSION['user']->shared = true;
				} else {
					$_SESSION['user']->shared = true;
				}
				ProductsStatistic_Model::getInstance()->updateItem($post['pid'], ProductsStatistic_Model::TYPE_SHARE);
				$ret['success'] = true;
			}
		}
		echo json_encode($ret);
	}
	
	public function emailAction() {
		$result = array('success' => false);
		if ($this->isPost()) {
			while(true) {
				if (empty($_POST['recipients'])) {
					$result['msg'] = "recipient can not be empty.";
					break;
				}
				$recipients = $_POST['recipients'];
				if(!filter_var_array($recipients, FILTER_VALIDATE_EMAIL)) {
					$result['msg'] = "illegal recipient's address";
					break;
				}
				if (empty($_POST['from'])) {
					$result['msg'] = "from user can not be empty.";
					break;
				}
				if (!filter_var($_POST['from'], FILTER_VALIDATE_EMAIL)) {
					$result['msg'] = "from user's address";
					break;
				}
				if (empty($_POST['subject'])) {
					$result['msg'] = "subject can not be empty";
					break;
				}
				if (empty($_POST['link'])) {
					$result['msg'] = "subject can not be empty";
					break;
				}
				if (empty($_POST['image'])) {
					$result['msg'] = "image can not be empty";
					break;
				}
				$content = empty($_POST['body']) ? '' : $_POST['body'];
				$content = preg_replace('/(http:\/\/\S+\.html)/i', '<a href="$1">$1</a>', $content);
				$body = $this->generateMailBody($_POST['image'], $_POST['subject'], $_POST['link'], $content);
				$mailSettings = $this->getMailSettings();
				if ($this->sendMail($mailSettings, 
						$_POST['from'],
						$recipients, 
						$_POST['subject'], 
						$body, 
						true)){
					$result['success'] = true;
				} else {
					$result['msg'] = 'failed to send email';
				}
				break;
			}
		} else {
			$result['msg'] = 'Illegal operation';
		}
		echo json_encode($result);
	}
	
	function generateMailBody($image, $subject, $link, $content) {
		return sprintf('<div><p>%s</p><p><a href="%s"><img src="%s" /></a></p></div>', nl2br($content), $link, $image);
	}
	
	function getMailSettings() {
		global $db;
	
		$ret = $db->query('select `value` from settings where `key` = "stmp"');
		if ($ret) {
			$settings = $ret->one();
			$emailSettings = unserialize($settings);
			return $emailSettings;
		} else {
			return false;
		}
	}
	
	function sendMail($set, $from, $to, $subject, $content, $ishtml) {
		require_once LIBPATH . '/class.phpmailer.php';
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = "utf-8";
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = $set['stmpserver'];
		$mail->Port = $set['stmpport'];
		$mail->Username = $set['stmpuser'];
		$mail->Password = $set['stmppasswd'];
		
		$mail->SetFrom($from);
		$mail->AddReplyTo($from);
		$mail->Subject = $subject;
		if ($ishtml == 'html') {
			$mail->MsgHTML($content);
		} else {
			$mail->Body = $content;
		}
		$mail->ClearAddresses();
		$mail->ClearBCCs();
		if (is_array($to)) {
			foreach ($to as $address) {
				$mail->AddBCC($address);
			}
		}
		if(!$mail->Send()) {
			return false;
		} else {
			return true;
		}
	}
}