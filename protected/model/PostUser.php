<?php
Q::loadCore ( 'db/Model' );
class PostUser extends Model {
	
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
	public $_table = 'post_user';
	public $_primarykey = 'post_id';
	public $_fields = array (
			'user_id',
			'post_id' 
	);
}
?>