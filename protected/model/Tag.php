<?php
Q::loadCore ( 'db/Model' );
class Tag extends Model {
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $id;

	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $status;
	
	/**
	 *
	 * @var varchar Max length is 145.
	 */
	public $name;
	
	/**
	 *
	 * @var varchar Max length is 300.
	 */
	public $pinyin;
	public $_table = 'tag';
	public $_primarykey = 'id';
	public $_fields = array (
			'id',
			'status',
			'name',
			'pinyin' 
	);

	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::setupModel ( __CLASS__ );
	}

	/**
	 * 验证规则
	 */
	public function getVRules() {
		return array (
				'id' => array (
						array (
								'integer' 
						),
						array (
								'min',
								0 
						),
						array (
								'maxlength',
								11 
						),
						array (
								'notnull' 
						) 
				),
				'status' => array (
						array (
								'integer' 
						),
						array (
								'min',
								0 
						),
						array (
								'maxlength',
								11 
						),
						array (
								'notnull' 
						) 
				),
				
				'name' => array (
						array (
								'maxlength',
								145 
						),
						array (
								'notnull' 
						) 
				),
				
				'pinyin' => array (
						array (
								'maxlength',
								300 
						),
						array (
								'notnull' 
						) 
				) 
		);
	}
}
?>