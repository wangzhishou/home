<?php
Q::loadController ( 'CoreController' );
class AdminController extends CoreController {
	public $sortField = 'createtime';
	public $orderType = 'desc';
	public static $tags;
	public static $cats;
	
	/**
	 * 编辑文章
	 */
	public function editPost() {
		Q::loadModel ( 'Post' );
		$p = new Post ();
		$p->id = intval ( $this->params ['pid'] );
		$this->data ['post'] = $p->relateTag ( array (
				'limit' => 'first',
				'asc' => 'tag.name',
				'match' => false 
		) );
		$this->data ['tags'] = array ();
		$this->data ['cats'] = array ();
		foreach ( $this->data ['post']->Tag as $t ) {
			if ($t->status == 1) {
				$this->data ['cats'] [] = $t->name;
			} else {
				$this->data ['tags'] [] = $t->name;
			}
		}
		$this->render ( 'edit_post', $this->data );
	}
	
	/**
	 * 保存编辑文章内容
	 */
	function savePostChanges() {
		$data = $this->data;
		Q::loadHelper ( 'Validator' );
		$_POST ['content'] = trim ( $_POST ['content'] );
		$validator = new Validator ();
		$validator->requireMode = Validator::REQ_MODE_NULL_ONLY;
		$validator->checkMode = Validator::CHECK_SKIP;
		$error = $validator->validate ( $_POST, 'post_edit.rules' );
		if (isset ( $error )) {
			$this->jsonError ( '<p style="color:#ff0000;">' . $error . '</p>' );
		} else {
			Q::loadModel ( 'Post' );
			Q::loadModel ( 'Tag' );
			Q::autoload ( 'DbExpression' );
			if (isset ( $this->data ['user'] )) {
				if ($this->data ['user'] ['group'] == "admin") {
					$_POST ['status'] = 1;
				}
			}
			$p = new Post ( $_POST );
			
			// delete the previous linked tags first
			Q::loadModel ( 'PostTag' );
			$pt = new PostTag ();
			$pt->post_id = $_POST ['id'];
			$pt->delete ();
			
			$a = array ();
			
			// 文章标签
			if (self::$tags != null) {
				foreach ( self::$tags as $t ) {
					$tg = new Tag ();
					$tg->name = $t;
					$a [] = $tg;
				}
			}
			
			// 文章分类
			if (self::$cats != null) {
				foreach ( self::$cats as $t ) {
					$c = new Tag ();
					$c->name = $t;
					$a [] = $c;
				}
			}
			
			if (! empty ( $a )) {
				$id = $p->relatedUpdate ( $a );
			} else {
				$id = $p->update ();
			}
			$this->jsonSuccess ( '<p style="color:#ff0000;">编辑文章成功</p>' );
		}
	}
	
	/**
	 * 发布文章
	 */
	public function createPost() {
		$this->render ( 'new_post', $this->data );
	}
	
	/**
	 * 缩略图上传
	 */
	public function thumbUp() {
		Q::loadHelper ( 'GdImage' );
		$dateStr = date ( "Ymd" );
		$bigPath = 'upload/big/' . $dateStr . '/';
		$smallPath = 'upload/small/' . $dateStr . '/';
		$data = $this->data;
		$gd = new GdImage ( $bigPath, $smallPath );
		$ext = array (
				'jpg',
				'jpeg',
				'gif',
				'png',
				'bmp' 
		);
		if ($gd->checkImageExtension ( 'thumbFile', $ext )) {
			$uploadImg = $gd->uploadImage ( 'thumbFile', 'img' . date ( 'Ymdhis' ) );
			if ($uploadImg) {
				$gd->thumbSuffix = '';
				$f = $gd->createThumb ( $uploadImg, Q::conf ()->thumbWidth, Q::conf ()->thumbHeight );
				if ($f) {
					$this->jsonSuccess ( "上传成功!", $data ["baseurl"] . $f, true );
				} else {
					$this->jsonError ( '创建缩略图失败！', '', true );
				}
			} else {
				$this->jsonError ( '上传失败！', '', true );
			}
		} else {
			$this->jsonError ( '文件不是图片文件！', '', true );
		}
	}
	/**
	 * 图片上传
	 */
	public function imageUp() {
		$data = $this->data;
		Q::loadClass ( "Uploader" );
		$config = array (
				"savePath" => "upload/big",
				"maxSize" => 1000,
				"allowFiles" => array (
						".gif",
						".png",
						".jpg",
						".jpeg",
						".bmp" 
				) 
		);
		$Path = "upload/";
		$config ["savePath"] = $Path;
		$up = new Uploader ( "upfile", $config );
		$editorId = $_GET ['editorid'];
		$info = $up->getFileInfo ();
		if (! empty ( $_REQUEST ['type'] ) && $_REQUEST ['type'] == "ajax") {
			echo $data ["baseurl"] . $info ["url"];
		} else {
			echo "<script>parent.UM.getEditor('" . $editorId . "').getWidgetCallback('image')('" . $data ["baseurl"] . $info ["url"] . "','" . $info ["state"] . "')</script>";
		}
	}
	
	/**
	 * 操作成功提示页
	 */
	public function saveSuccess() {
		$data = $this->data;
		$data ['title'] = '文章发布成功';
		$data ['content'] = '<p style="color:#ff0000;">文章发布成功！</p>';
		$data ['content'] .= '<p>点击 <a href="' . $data ['baseurl'] . 'post/create">这里</a> 继续发布文章.</p>';
		$data ['content'] .= '<p>点击 <a href="' . $data ['baseurl'] . '">这里</a> 返回网站首页.</p>';
		$data ['status'] = 'success';
		$this->render ( 'msg', $data );
	}
	
	/**
	 * save new post
	 */
	public function saveNewPost() {
		$data = $this->data;
		Q::loadHelper ( 'Validator' );
		$_POST ['content'] = trim ( $_POST ['content'] );
		$validator = new Validator ();
		$validator->requireMode = Validator::REQ_MODE_NULL_ONLY;
		$validator->checkMode = Validator::CHECK_SKIP;
		$error = $validator->validate ( $_POST, 'post_create.rules' );
		if (isset ( $error )) {
			$this->jsonError ( '<p style="color:#ff0000;">' . $error . '</p>' );
		} else {
			Q::loadModel ( 'Post' );
			Q::loadModel ( 'Tag' );
			Q::loadModel ( 'User' );
			Q::autoload ( 'DbExpression' );
			if (isset ( $this->data ['user'] )) {
				if ($this->data ['user'] ['group'] == "admin") {
					$_POST ['status'] = 1;
				}
			}
			$p = new Post ( $_POST );
			$p->createtime = new DbExpression ( 'NOW()' );
			$a = array ();
			
			// 文章标签
			if (self::$tags != Null) {
				foreach ( self::$tags as $t ) {
					$tg = new Tag ();
					$tg->name = $t;
					$a [] = $tg;
				}
			}
			
			// 文章分类
			if (self::$cats != Null) {
				foreach ( self::$cats as $t ) {
					$c = new Tag ();
					$c->name = $t;
					$a [] = $c;
				}
			}
			
			// 文章用户
			if (isset ( $_SESSION ['user'] )) {
				$u = new User ();
				$u->id = $_SESSION ['user'] ['id'];
				$a [] = $u;
			}
			
			if (! empty ( $a )) {
				$id = $p->relatedInsert ( $a );
			} else {
				$id = $p->insert ();
			}
			$this->jsonSuccess ( '<p style="color:#ff0000;">文章发布成功</p>' );
		}
	}
	
	/**
	 * 检测分类
	 *
	 * @param unknown $catStr        	
	 * @return string
	 */
	static function checkCats($catStr) {
		$catStr = trim ( $catStr );
		if (empty ( $catStr )) {
			return "分类不能为空";
		}
		$catsId = explode ( ',', $catStr );
		self::$cats = $catsId;
	}
	
	/**
	 * Validate if tags is less than or equal to 10 tags based on the String seperated by commas.
	 * Tags cannot be empty 'mytag, tag2,,tag4, , tag5' (error)
	 */
	static function checkTags($tagStr) {
		// tags can be empty(no tags)
		$tagStr = trim ( $tagStr );
		if (empty ( $tagStr )) {
			return "标签不能为空";
		}
		
		$tags = explode ( ',', $tagStr );
		
		foreach ( $tags as $k => $v ) {
			$tags [$k] = strip_tags ( trim ( $v ) );
			if (empty ( $tags [$k] )) {
				return '无效的标签!';
			}
		}
		
		if (sizeof ( $tags ) > 10) {
			return '最多输入10个 标签!';
		}
		
		self::$tags = $tags;
	}
	
	/**
	 * 判断文章是否存在
	 */
	static function checkPostExist($id) {
		Q::loadModel ( 'Post' );
		$p = new Post ();
		$p->id = $id;
		if ($p->find ( array (
				'limit' => 1,
				'select' => 'id' 
		) ) == Null) {
			return '编辑的文章不存在，请稍后重试！';
		}
	}
}
?>