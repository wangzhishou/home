<?php
class CoreController extends Controller {
	/**
	 * 全局保存数据
	 *
	 * @var unknown
	 */
	public $data = array ();
	
	/**
	 * cookie名称
	 */
	public $cookieName = "auth";
	public $cookieExpiresTime = 86400;
	
	/**
	 * 保存登录状态
	 */
	public $session;
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		$this->data ['baseurl'] = Q::conf ()->APP_URL;
		$this->data ['siteTitle'] = Q::conf ()->siteTitle;
		$this->data ['head'] = '';
		$this->session = Q::session ( "website" );
	}
	
	/**
	 * 前置执行
	 *
	 * @see Controller::beforeRun()
	 */
	public function beforeRun($resource, $action) {
		$user = $this->session->get ( 'user' );
		$auth = $this->session->get ( 'auth' );
		if ($user) {
			$this->data ['user'] = $user;
			if ($auth) {
				setcookie ( $this->cookieName, $auth, time () + $this->cookieExpiresTime, '/' );
			}
		} else {
			$auth = $_COOKIE [$this->cookieName];
			if ($auth) {
				$auth = $this->clean ( explode ( "\t", $this->authcode ( $auth, 'DECODE' ) ), 1 );
				if ($auth && count ( $auth ) > 0) {
					Q::loadModel ( 'User' );
					$user = new User ();
					$user->id = intval ( $auth [0] );
					$user->pwd = $auth [1];
					$user = $this->db ()->find ( $user, array (
							'limit' => 1 
					) );
					if ($user) {
						$auth = $this->authcode ( $user->id . "\t" . $user->pwd, 'ENCODE' );
						$this->session->user = array (
								'id' => $user->id,
								'username' => $user->username,
								'email' => $user->email,
								'vip' => $user->vip,
								'group' => $user->group 
						);
						$this->session->auth = $auth;
						setcookie ( $this->cookieName, $auth, time () + $this->cookieExpiresTime, '/' );
					} else {
						$this->data ['user'] = null;
					}
				}
			} else {
				$this->data ['user'] = null;
			}
		}
		$this->data ['randomTags'] = $this->getRandomTags ();
		$this->data ['menu'] = $this->getMenu ();
		// if not login, group = anonymous
		$role = (isset ( $user ['group'] )) ? $user ['group'] : 'anonymous';
		$rs = "";
		$rs == $this->acl ()->process ( $role, $resource, $action );
		if (! empty ( $rs )) {
			return $rs;
		}
	}
	
	/**
	 * Prepare sidebar data, random tags and archive list
	 */
	public function getRandomTags() {
		$cacheTagOK = Q::cache ( 'front' )->testPart ( 'randomTag', 300 );
		if (! $cacheTagOK) {
			Q::loadModel ( 'Tag' );
			$tags = new Tag ();
			$tags->status = 0;
			$data = $tags->limit ( 10, null, null, array (
					'custom' => 'ORDER BY RAND()' 
			) );
		} else {
			$data = array ();
		}
		return $data;
	}
	
	/**
	 * Prepare topMenu data
	 */
	public function getMenu() {
		Q::loadModel ( 'Tag' );
		$cacheOK = Q::cache ( "php" )->get ( 'menu' );
		if (! $cacheOK) {
			$cats = new Tag ();
			$cats->status = 1;
			$data = $cats->find ( array (
					'limit' => 10 
			) );
			if ($data) {
				Q::cache ( "php" )->set ( 'menu', $data, 300000 );
			} else {
				$data = array ();
			}
		} else {
			$data = $cacheOK;
		}
		return $data;
	}
	
	/**
	 * jsonError
	 */
	public function jsonError($msg, $dt = "", $flag = false) {
		$json = array (
				'status' => 1,
				'msg' => $msg,
				'data' => $dt 
		);
		if ($this->isAjax () || $flag) {
			echo json_encode ( $json );
		}
	}
	
	/**
	 * jsonSuccess
	 */
	public function jsonSuccess($msg, $dt = "", $flag = false) {
		$json = array (
				'status' => 0,
				'data' => $dt,
				'msg' => $msg 
		);
		if ($this->isAjax () || $flag) {
			echo json_encode ( $json );
		}
	}
	
	/**
	 * 渲染成功页面
	 */
	public function renderSuccess($msg = "", $title = "") {
		Q::loadHelper ( "TextHelper" );
		$data ['content'] = $msg;
		$data ['title'] = $title;
		$data ['status'] = 'success';
		$this->view ()->render ( 'msg', $this->data );
	}
	
	/**
	 * 渲染失败页面
	 */
	public function renderFail($msg = "", $title = "") {
		$data ['content'] = $msg;
		$data ['title'] = $title;
		$data ['status'] = 'error';
		$this->view ()->render ( 'msg', $this->data );
	}
	
	/*
	 * 转义
	 */
	public function clean($var, $strip = true) {
		if (is_array ( $var )) {
			foreach ( $var as $key => $value ) {
				$var [$key] = trim ( $this->clean ( $value, $strip ) );
			}
			return $var;
		} elseif (is_numeric ( $var )) {
			return $var;
		} else {
			return addslashes ( $strip ? stripslashes ( $var ) : $var );
		}
	}
	
	/*
	 * 字符串加解密
	 */
	public function authcode($string, $operation, $code = 'Q') {
		$key = md5 ( $code );
		$key_length = strlen ( $key );
		$string = $operation == 'DECODE' ? base64_decode ( $string ) : substr ( md5 ( $string . $key ), 0, 8 ) . $string;
		$string_length = strlen ( $string );
		$rndkey = $box = array ();
		$result = '';
		for($i = 0; $i <= 255; $i ++) {
			$rndkey [$i] = ord ( $key [$i % $key_length] );
			$box [$i] = $i;
		}
		for($j = $i = 0; $i < 256; $i ++) {
			$j = ($j + $box [$i] + $rndkey [$i]) % 256;
			$tmp = $box [$i];
			$box [$i] = $box [$j];
			$box [$j] = $tmp;
		}
		for($a = $j = $i = 0; $i < $string_length; $i ++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box [$a]) % 256;
			$tmp = $box [$a];
			$box [$a] = $box [$j];
			$box [$j] = $tmp;
			$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
		}
		if ($operation == 'DECODE') {
			if (substr ( $result, 0, 8 ) == substr ( md5 ( substr ( $result, 8 ) . $key ), 0, 8 )) {
				return substr ( $result, 8 );
			} else {
				return '';
			}
		} else {
			return str_replace ( '=', '', base64_encode ( $result ) );
		}
	}
}

?>