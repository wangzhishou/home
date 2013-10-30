<?php
Q::loadCore ( 'db/Model' );
class Info extends Model {
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
	 * @var varchar Max length is 200.
	 */
	public $title;
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $price;
	
	/**
	 *
	 * @var varchar Max length is 60.
	 */
	public $business;
	
	/**
	 *
	 * @var varchar Max length is 200.
	 */
	public $sourceurl;
	
	/**
	 *
	 * @var varchar Max length is 2000.
	 */
	public $description;
	
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
			'uid',
			'title',
			'price',
			'business',
			'sourceurl',
			'description',
			'createtime' 
	);
	
	/**
	 * 构造函数
	 * @param string $data
	 */
	public function __construct($data = null) {
		parent::__construct ( $data );
		parent::setupModel ( __CLASS__ );
	}
	
	/**
	 * 验证规则
	 * @return 
	 */
	public function getVRules() {
		return array (
				'title' => array (
						array (
								'notempty',
								'文章标题不能为空！' 
						),
						array (
								'maxlength',
								300,
								'最多能输入汉字100个！' 
						) 
				),
				
				'price' => array (
						array (
								'integer',
								'价格必须为整数，单位元' 
						),
						array (
								'notempty',
								'价格不能为空！' 
						) 
				),
				
				'business' => array (
						array (
								'maxlength',
								60,
								'商家最多能输入20个汉字' 
						),
						array (
								'notempty',
								'商家不能为空！' 
						),
						array (
								'notnull' 
						) 
				),
				
				'sourceurl' => array (
						array (
								'maxlength',
								600,
								'购买链接不能超过600个字符' 
						),
						array (
								'notempty',
								'购买链接不能为空！' 
						),
						array (
								'notnull' 
						) 
				),
				
				'description' => array (
						array (
								'maxlength',
								2100,
								'描述不能超过700个汉字' 
						),
						array (
								'notempty',
								'描述不能为空！' 
						),
						array (
								'notnull' 
						) 
				) 
		);
	}
}
?>