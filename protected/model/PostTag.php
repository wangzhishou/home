<?php
Q::loadCore ( 'db/Model' );
class PostTag extends Model {
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $tag_id;
	
	/**
	 *
	 * @var int Max length is 11. unsigned.
	 */
	public $post_id;
	public $_table = 'post_tag';
	public $_primarykey = 'post_id';
	public $_fields = array (
			'tag_id',
			'post_id' 
	);
	public function getVRules() {
		return array (
				'tag_id' => array (
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
				
				'post_id' => array (
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
				) 
		);
	}
}
?>