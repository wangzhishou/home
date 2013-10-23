<?php
Q::loadCore ( 'db/Model' );
class Comment extends Model {
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $id;
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $user_id;
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $post_id;
	
	/**
	 *
	 * @var varchar Max length is 45.
	 */
	public $content;
	
	/**
	 *
	 * @var datetime
	 */
	public $createtime;
	
	/**
	 *
	 * @var tinyint Max length is 1. unsigned.
	 */
	public $status;
	public $_table = 'comment';
	public $_primarykey = 'id';
	public $_fields = array (
			'id',
			'user_id',
			'post_id',
			'content',
			'createtime',
			'status' 
	);
	public function __construct($data = null) {
		parent::__construct ( $data );
		parent::setupModel ( __CLASS__ );
	}
	public function getVRules() {
		return array (
				'post_id' => array (
						array (
								'integer',
								'文章id必须为整数！' 
						),
						array (
								'notempty',
								'文章id不能为空！' 
						),
						array (
								'custom',
								'BlogController::checkPostExist' 
						) 
				),
				
				'user_id' => array (
						array (
								'integer',
								'用户id必须为整数!' 
						),
						array (
								'notempty',
								'用户id不能为空！' 
						),
						array (
								'custom',
								'BlogController::checkUserExist' 
						) 
				),
				
				'content' => array (
						array (
								'maxlength',
								2000,
								'最多能输入汉字1000个！' 
						),
						array (
								'notempty',
								'评论内容不能为空！' 
						),
						array (
								'notnull' 
						) 
				) 
		);
	}
}
?>