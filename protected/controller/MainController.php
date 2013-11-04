<?php
Q::loadController ( 'CoreController' );
class MainController extends CoreController {
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