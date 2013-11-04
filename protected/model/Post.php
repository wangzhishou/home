<?php
Q::loadCore ( 'db/Model' );
class Post extends Model {
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $id;
	
	/**
	 *
	 * @var varchar Max length is 145.
	 */
	public $title;
	
	/**
	 *
	 * @var varchar Max length is 200.
	 */
	public $thumbnails;
	
	/**
	 *
	 * @var text
	 */
	public $content;
	
	/**
	 *
	 * @var varchar Max length is 300.
	 */
	public $summary;
	
	/**
	 *
	 * @var datetime
	 */
	public $createtime;
	
	/**
	 *
	 * @var varchar Max length is 128.
	 */
	public $sourceurl;
	
	/**
	 *
	 * @var varchar Max length is 128.
	 */
	public $price;
	
	/**
	 *
	 * @var tinyint Max length is 1.
	 */
	public $status;
	
	/**
	 *
	 * @var smallint Max length is 11. unsigned.
	 */
	public $totalcomment;
	
	/**
	 *
	 * @var smallint Max length is 11. unsigned.
	 */
	public $totaldigg;
	
	/**
	 * table
	 *
	 * @var unknown
	 */
	public $_table = 'post';
	public $_primarykey = 'id';
	public $_fields = array (
			'id',
			'title',
			'thumbnails',
			'summary',
			'content',
			'createtime',
			'sourceurl',
			'price',
			'status',
			'totalcomment',
			'totaldigg' 
	);
	
	/**
	 * construct
	 * 
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
				
				'title' => array (
						array (
								'maxlength',
								145 
						),
						array (
								'notnull' 
						) 
				),
				
				'content' => array (
						array (
								'notnull' 
						) 
				),
				
				'createtime' => array (
						array (
								'datetime' 
						),
						array (
								'optional' 
						) 
				),
				
				'status' => array (
						array (
								'integer' 
						),
						array (
								'maxlength',
								1 
						),
						array (
								'optional' 
						) 
				),
				
				'totalcomment' => array (
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
								'optional' 
						) 
				) 
		);
	}
}
?>