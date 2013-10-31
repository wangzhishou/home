<?php
Q::loadController ( "CoreController" );
class UserController extends CoreController {
	/**
	 * logout
	 */
	public function logout() {
		$this->session->user = null;
		$this->session->auth = null;
		setcookie ( $this->cookieName, "", time () - 3600, '/' );
		return Q::conf ()->APP_URL;
	}
	
	/**
	 * check
	 */
	public function check() {
		Q::loadHelper ( "Validator" );
		$v = new Validator ();
		if (isset ( $_POST ['email'] )) {
			$_POST ['email'] = trim ( $_POST ['email'] );
			$error = $v->testNotEmpty ( $_POST ['email'], '电子邮件地址不能为空！' );
			if ($error) {
				$this->jsonError ( $error );
				return false;
			}
			$error = $v->testEmail ( $_POST ['email'], '请输入正确的电子邮件格式！' );
			if ($error) {
				$this->jsonError ( $error );
				return false;
			}
			Q::loadModel ( 'User' );
			$user = new User ();
			$user->email = $_POST ['email'];
			$user = $this->db ()->find ( $user, array (
					'limit' => 1 
			) );
			if ($user) {
				echo $this->jsonError ( '此电子邮件已被注册!' );
				return false;
			}
		}
		if (isset ( $_POST ['password'] )) {
			$_POST ['password'] = trim ( $_POST ['password'] );
			$error = $v->testNotEmpty ( $_POST ['password'], '密码不能为空！' );
			if ($error) {
				$this->jsonError ( $error );
				return false;
			}
			$error = $v->testPassword ( $_POST ['password'], 6, 20, '密码必须在6-20位之间' );
			if ($error) {
				$this->jsonError ( $error );
				return false;
			}
		}
		$this->jsonSuccess ( '&radic;' );
		if (isset ( $_POST ['email'] ) && isset ( $_POST ['password'] )) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * register
	 */
	public function reg() {
		$data = $this->data;
		if ($this->check ()) {
			Q::loadModel ( 'User' );
			Q::loadHelper ( "TextHelper" );
			$_POST ['email'] = trim ( $_POST ['email'] );
			$_POST ['password'] = trim ( $_POST ['password'] );
			$token = TextHelper::token ();
			$u = new User ();
			$u->username = $_POST ['email'];
			$u->pwd = md5 ( $_POST ['password'] );
			$u->email = $_POST ['email'];
			$u->vip = "0";
			$u->token = $token;
			$id = $this->db ()->insert ( $u );
			if ($id) {
				$flag = $this->sendRegMail ( $_POST ['email'], $token );
				if ($flag) {
					$this->renderSuccess ( "注册成功，请到登录邮箱激活帐号" );
				} else {
					$this->renderSuccess ( "注册邮件发送失败。" );
				}
			} else {
				$this->renderSuccess ( "注册失败。" );
			}
		} else {
			$this->view ()->render ( 'reg', $data );
		}
	}
	
	/**
	 * send active mail
	 */
	private function sendRegMail($email, $token) {
		$mfilename = Q::conf ()->SITE_PATH . Q::conf ()->PROTECTED_FOLDER . "view/mail.html";
		if (file_exists ( $mfilename )) {
			Q::loadHelper ( "Mailer" );
			$bodyHtml = file_get_contents ( $mfilename );
			$bodyHtml = str_replace ( '{{user_name}}', $email, $bodyHtml );
			$bodyHtml = str_replace ( '{{site_name}}', $this->data ['siteTitle'], $bodyHtml );
			$bodyHtml = str_replace ( '{{active_url}}', "/user/active?u=$email&t=$token", $bodyHtml );
			$bodyHtml = str_replace ( '{{forget_url}}', "/user/forget", $bodyHtml );
			$m = new Mailer ();
			$m->setSubject ( $this->data ['siteTitle'] . "注册激活邮件！" );
			$m->addTo ( $email );
			$m->setBodyHtml ( $bodyHtml );
			$m->setFrom ( Q::conf ()->siteAdminEmail );
			return $m->send ();
		} else {
			return false;
		}
	}
	
	/**
	 * forget
	 */
	public function forget() {
	}
	
	/**
	 * login check
	 *
	 * @return Ambigous <string, string>
	 */
	private function loginCheck() {
		Q::loadHelper ( "Validator" );
		$v = new Validator ();
		$error = $v->testNotEmpty ( $_POST ['email'], '电子邮件地址不能为空！' );
		if ($error) {
			return $error;
		}
		$error = $v->testNotEmpty ( $_POST ['password'], '密码不能为空！' );
		if ($error) {
			return $error;
		}
		$error = $v->testEmail ( $_POST ['email'], '请输入正确的电子邮件格式！' );
		if ($error) {
			return $error;
		}
	}
	
	/**
	 * login
	 *
	 * @return string
	 */
	public function login() {
		$data = $this->data;
		$error = "";
		if (isset ( $_POST ['email'] ) && isset ( $_POST ['password'] )) {
			$_POST ['email'] = trim ( $_POST ['email'] );
			$_POST ['password'] = trim ( $_POST ['password'] );
			$error = $this->loginCheck ();
			if (empty ( $error ) && ! empty ( $_POST ['email'] ) && ! empty ( $_POST ['password'] )) {
				Q::loadModel ( 'User' );
				$user = new User ();
				$user->email = $_POST ['email'];
				$user->pwd = md5 ( $_POST ['password'] );
				$user = $this->db ()->find ( $user, array (
						'limit' => 1 
				) );
				if ($user) {
					$auth = $this->authcode ( $user->id . "\t" . $user->pwd . "\t" . time (), 'ENCODE' );
					$this->session->user = array (
							'id' => $user->id,
							'username' => $user->username,
							'email' => $user->email,
							'vip' => $user->vip,
							'group' => $user->group 
					);
					$this->session->auth = $auth;
					setcookie ( $this->cookieName, $auth, time () + $this->cookieExpiresTime, '/' );
					if (isset ( $_POST ['referrer'] ) && empty ( $_POST ['referrer'] )) {
						return $_POST ['referrer'];
					} else {
						return Q::conf ()->APP_URL;
					}
				} else {
					$error = "用户名或密码错误！";
				}
			}
		}
		$data ['error'] = $error;
		$this->render ( 'login', $data );
	}
}
?>