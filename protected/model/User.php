<?php
Q::loadCore ( 'db/Model' );
class User extends Model {
	
	/**
	 *
	 * @var smallint Max length is 5. unsigned.
	 */
	public $id;
	
	/**
	 *
	 * @var varchar Max length is 64.
	 */
	public $username;
	
	/**
	 *
	 * @var varchar Max length is 64.
	 */
	public $email;
	
	/**
	 *
	 * @var varchar Max length is 64.
	 */
	public $pwd;
	
	/**
	 *
	 * @var varchar Max length is 32.
	 */
	public $group;
	
	/**
	 *
	 * @var tinyint Max length is 4.
	 */
	public $vip;
	
	/**
	 *
	 * @var varchar Max length is 64.
	 */
	public $token;
	
	/**
	 *
	 * @var table name
	 */
	public $_table = 'user';
	public $_primarykey = 'id';
	public $_fields = array (
			'id',
			'username',
			'email',
			'pwd',
			'group',
			'vip',
			'token' 
	);
	public function __construct($data = null) {
		parent::__construct ( $data );
		parent::setupModel ( __CLASS__ );
	}
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
				) 
		);
	}
}
?>