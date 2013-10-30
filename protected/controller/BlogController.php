<?php
Q::loadController ( "CoreController" );
class BlogController extends CoreController {
	/**
	 * temp var
	 *
	 * @var unknown
	 */
	public $sortField = 'createtime';
	public $orderType = 'desc';
	
	/**
	 * 根据分类获取文章
	 */
	public function getCat() {
		Q::loadHelper ( 'Pager' );
		Q::loadModel ( 'Post' );
		Q::loadModel ( 'Tag' );
		
		$this->data ['pinyin'] = $this->params ['pinyin'];
		$catId = $this->getCurrentId ();
		
		$p = new Post ();
		$p->status = 1;
		
		$tag = new Tag ();
		$tag->id = $catId;
		
		$totalPosts = $tag->relatePost ( array (
				'select' => 'COUNT(tag.id) AS total',
				'asArray' => true 
		) );
		$totalPosts = $totalPosts [0] ['total'];
		
		if ($totalPosts < 1) {
			return 404;
		}
		
		$pager = new Pager ( Q::conf ()->APP_URL . "cat/$tag->pinyin/page", $totalPosts, 4, 10 );
		if (isset ( $this->params ['pindex'] )) {
			$pager->paginate ( intval ( $this->params ['pindex'] ) );
		} else {
			$pager->paginate ( 1 );
		}
		$this->data ['posts'] = $p->relateTag ( array (
				'limit' => $pager->limit,
				'desc' => 'post.createtime',
				'where' => 'tag.id=' . $catId,
				'match' => false 
		) );
		
		$this->data ['pager'] = $pager->output;
		$this->getRandomTags ();
		$this->render ( 'cat', $this->data );
	}
	
	/**
	 * 根据拼音获取当前文章的id
	 *
	 * @param unknown $py        	
	 */
	private function getCurrentId() {
		foreach ( $this->data ['menu'] as $v ) {
			if ($v->pinyin == $this->data ['pinyin']) {
				return $v->id;
			}
		}
	}
	
	/**
	 * Show single blog post page
	 */
	public function getArticle() {
		Q::loadModel ( 'Post' );
		$p = new Post ();
		$p->id = $this->params ['postId'];
		$p->status = 1;
		$this->data ['post'] = $p->relateTag ( array (
				'limit' => 'first',
				'asc' => 'tag.name',
				'match' => false 
		) );
		if ($this->data ['post'] == null) {
			return 404;
		}
		if ($this->data ['post']->totalcomment > 0) {
			Q::loadModel ( 'Comment' );
			$c = new Comment ();
			$c->post_id = $this->data ['post']->id;
			$c->status = 1;
			$this->data ['comments'] = $c->relateUser ( array (
					'asc' => 'createtime' 
			) );
		}
		$this->data ['title'] = $this->data ['post']->title;
		$this->data ['description'] = $this->data ['post']->summary;
		if (isset ( $this->data ['post']->Tag )) {
			$tagObject = $this->data ['post']->Tag;
			foreach ( $tagObject as $k1 => $v1 ) :
				$a [] = $v1->name;
			endforeach
			;
			$this->data ['keywords'] = implode ( ', ', $a );
		}
		$this->getRandomTags ();
		$this->render ( 'content', $this->data );
	}
	
	/**
	 * 获取标签
	 */
	public function getTag() {
		Q::loadHelper ( 'Pager' );
		Q::loadModel ( 'Post' );
		Q::loadModel ( 'Tag' );
		
		$p = new Post ();
		$p->status = 1;
		
		$tag = new Tag ();
		$tag->name = trim ( urldecode ( $this->params ['name'] ) );
		
		$totalPosts = $tag->relatePost ( array (
				'select' => 'COUNT(tag.id) AS total',
				'asArray' => true 
		) );
		$totalPosts = $totalPosts [0] ['total'];
		
		if ($totalPosts < 1) {
			return 404;
		}
		
		$pager = new Pager ( Q::conf ()->APP_URL . "tag/$tag->name/page", $totalPosts, 4, 10 );
		if (isset ( $this->params ['pindex'] )) {
			$pager->paginate ( intval ( $this->params ['pindex'] ) );
		} else {
			$pager->paginate ( 1 );
		}
		$this->data ['posts'] = $p->relateTag ( array (
				'limit' => $pager->limit,
				'desc' => 'post.createtime',
				'where' => 'tag.name=?',
				'param' => array (
						$tag->name 
				),
				'match' => false 
		) );
		
		$this->data ['pager'] = $pager->output;
		$this->getRandomTags ();
		$this->render ( 'list', $this->data );
	}
	
	/**
	 * 发表一篇文章计数增加
	 */
	public function newComment() {
		foreach ( $_POST as $k => $v ) {
			$_POST [$k] = trim ( strip_tags ( $v ) );
		}
		Q::loadModel ( 'Comment' );
		$c = new Comment ( $_POST );
		$error = $c->validate ( 'skip' );
		if (isset ( $error )) {
			$this->data ['status'] = 'error';
			$this->data ['title'] = '文章发布错误，错误原因：';
			$this->data ['content'] = '<p style="color:#ff0000;">' . $error . '</p>';
			$this->data ['content'] .= '<p>点击 <a href="javascript:history.back();">返回</a> 文章.</p>';
			$this->render ( 'msg', $this->data );
		} else {
			Q::autoload ( 'DbExpression' );
			$c->createtime = new DbExpression ( 'NOW()' );
			$c->status = 1;
			if (isset ( $this->data ['user'] )) {
				if ($this->data ['user'] ['group'] == "admin") {
					$c->status = 1;
				}
			}
			$c->insert ();
			Q::loadModel ( 'Post' );
			$p = new Post ();
			$p->id = $_POST ['post_id'];
			$p->status = 1;
			$p = $this->db ()->find ( $p, array (
					'limit' => 1 
			) );
			$p->totalcomment = $p->totalcomment + 1;
			$this->db ()->update ( $p );
			$this->data ['status'] = 'success';
			$this->data ['title'] = '文章发布成功';
			$this->data ['content'] = '<p>点击 <a href="javascript:history.back();">返回</a> 文章.</p>';
			$this->render ( 'msg', $this->data );
		}
	}
	
	/**
	 * 验证一下文章id是否存在，并发布
	 */
	static function checkPostExist($id) {
		Q::loadModel ( 'Post' );
		$p = new Post ();
		$p->id = $id;
		$p->status = 1;
		if ($p->find ( array (
				'limit' => 1,
				'select' => 'id' 
		) ) == null) {
			return '文章id不存在！';
		}
	}
	
	/**
	 * 验证一下用户id是否存在，并发布
	 */
	static function checkUserExist($id) {
		Q::loadModel ( 'User' );
		$u = new User ();
		$u->id = $id;
		if ($u->find ( array (
				'limit' => 1,
				'select' => 'id',
				'where' => 'vip > 0' 
		) ) == null) {
			return '对不起，此用户不存在或权限不够！';
		}
	}
}
?>