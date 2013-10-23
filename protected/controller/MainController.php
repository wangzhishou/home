<?php
/**
 * MainController
 * Feel free to delete the methods and replace them with your own code.
 *
 * @author darkredz
 */
class MainController extends Controller {
	/**
	 * temp var
	 *
	 * @var unknown
	 */
	private $data = array ();
	
	/**
	 * start check
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
		$this->data ['baseurl'] = Q::conf ()->APP_URL;
		$this->data ['siteTitle'] = Q::conf ()->siteTitle;
		$this->data ['head'] = '';
		$this->data ['randomTags'] = self::getRandomTags ();
		$this->data ['menu'] = self::getMenu ();
		// if not login, group = anonymous
		$role = (isset ( $_SESSION ['user'] ['group'] )) ? $_SESSION ['user'] ['group'] : 'anonymous';
		$rs = "";
		$rs == $this->acl ()->process ( $role, $resource, $action );
		if (! empty ( $rs )) {
			return $rs;
		}
	}
	
	/**
	 * index
	 */
	public function home() {
		Q::loadHelper ( 'Pager' );
		Q::loadModel ( 'Post' );
		$p = new Post ();
		$p->status = 1;
		$pager = new Pager ( Q::conf ()->APP_URL . 'page', $p->count (), 20, 10 );
		if (isset ( $this->params ['pindex'] )) {
			$pager->paginate ( intval ( $this->params ['pindex'] ) );
		} else {
			$pager->paginate ( 1 );
		}
		$this->data ['posts'] = $p->relateTag ( array (
				'limit' => $pager->limit,
				'desc' => 'post.createtime',
				'asc' => 'tag.name',
				'match' => false 
		) );
		$this->data ['pager'] = $pager->output;
		$data = $this->data;
		$this->view ()->render ( 'index', $data );
	}
	
	/**
	 * 清楚缓存
	 */
	public function clearCache() {
		Q::cache ( 'front' )->flushAll ();
		Q::cache ()->flushAll ();
		$this->data ['randomTags'] = self::getRandomTags ();
		$this->data ['menu'] = self::getMenu ();
		$this->data ['title'] = '操作成功';
		$this->data ['status'] = 'success';
		$this->data ['content'] = '<p>清楚缓存成功!</p>';
		$this->data ['content'] .= '<p>点击  <a href="javascript:history.back();">这里</a> 跳转到上一页.</p>';
		$this->render ( 'msg', $this->data );
	}
	
	/**
	 * Prepare sidebar data, random tags and archive list
	 */
	static public function getRandomTags() {
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
	static public function getMenu() {
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
	 * Check if the request is an AJAX request usually sent with JS library such as JQuery/YUI/MooTools
	 *
	 * @return bool
	 */
	static public function isAjaxBoolean() {
		return (isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest');
	}
	
	/**
	 * jsonError
	 */
	static public function jsonError($msg, $dt = "", $flag = false) {
		$json = array (
				'status' => 1,
				'msg' => $msg,
				'data' => $dt 
		);
		if (self::isAjaxBoolean () || $flag) {
			echo json_encode ( $json );
		}
	}
	
	/**
	 * jsonSuccess
	 */
	static public function jsonSuccess($msg, $dt = "", $flag = false) {
		$json = array (
				'status' => 0,
				'data' => $dt,
				'msg' => $msg 
		);
		if (self::isAjaxBoolean () || $flag) {
			echo json_encode ( $json );
		}
	}
	
	/**
	 * This shows the same content as home(), but with pagination
	 * Show error if Page index is invalid (negative)
	 */
	function page() {
		if (isset ( $this->params ['pindex'] ) && $this->params ['pindex'] > 0) {
			$this->home ();
		} else {
			return 404;
		}
	}
}
?>