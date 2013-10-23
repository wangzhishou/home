<?php
class CoreController extends Controller {
	/**
	 * 全局保存数据
	 *
	 * @var unknown
	 */
	public $data = array ();
	
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
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		if (isset ( $_SESSION ['user'] )) {
			$this->data ['user'] = $_SESSION ['user'];
		} else {
			$this->data ['user'] = null;
		}
		$this->data ['randomTags'] = $this->getRandomTags ();
		$this->data ['menu'] = $this->getMenu ();
		// if not login, group = anonymous
		$role = (isset ( $_SESSION ['user'] ['group'] )) ? $_SESSION ['user'] ['group'] : 'anonymous';
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
}

?>