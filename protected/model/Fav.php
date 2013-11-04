<?php
Q::loadCore ( 'db/Model' );
class Fav extends Model {
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $id;
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $uid;
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $pid;
	
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
	public $_table = 'fav';
	public $_primarykey = 'id';
	public $_fields = array (
			'id',
			'uid',
			'pid',
			'createtime' 
	);
	public function __construct($data = null) {
		parent::__construct ( $data );
		parent::setupModel ( __CLASS__ );
	}
	
	/**
	 * 验证规则
	 * 
	 * @return multitype:multitype:multitype:string
	 */
	public function getVRules() {
		return array (
				'pid' => array (
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
				'uid' => array (
						array (
								'integer',
								'用户id必须为整数！' 
						),
						array (
								'notempty',
								'操作用户不能为空！' 
						),
						array (
								'custom',
								'BlogController::checkUserExist' 
						) 
				) 
		);
	}
}
?>