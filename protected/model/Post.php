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
			'totalcomment' 
	);
	public function __construct($data = null) {
		parent::__construct ( $data );
		parent::setupModel ( __CLASS__ );
	}
	public function getArchiveSummary() {
		$archive_list = $this->find ( array (
				'select' => 'createtime',
				'desc' => 'createtime',
				'asArray' => true 
		) );
		foreach ( $archive_list as $a ) {
			$a = explode ( '-', $a ['createtime'] );
			if ($a [0] == '0000')
				continue;
			
			if (! isset ( $year_month [$a [0]] ))
				$year_month [$a [0]] = array ();
			
			if (! in_array ( $a [1], array_keys ( $year_month [$a [0]] ) ))
				$year_month [$a [0]] [$a [1]] = 1;
			else {
				$year_month [$a [0]] [$a [1]] = $year_month [$a [0]] [$a [1]] + 1;
			}
		}
		return $year_month;
	}
	
	/**
	 * Count total of posts in a given Year and Month
	 */
	public function countArchive($year, $month) {
		$startdate = "$year-$month-01";
		
		$opt ['where'] = 'createtime  BETWEEN ? AND DATE_ADD(?, INTERVAL 1 MONTH)';
		$opt ['param'] = array (
				$startdate,
				$startdate 
		);
		
		return $this->count ( $opt );
	}
	
	/**
	 * Get the list of Post in a given Year and Month plus pagination limit.
	 */
	public function getArchiveList($year, $month, $limit) {
		$startdate = "$year-$month-01";
		
		$opt ['where'] = 'post.createtime  BETWEEN ? AND DATE_ADD(?, INTERVAL 1 MONTH)';
		$opt ['param'] = array (
				$startdate,
				$startdate 
		);
		$opt ['limit'] = $limit;
		$opt ['desc'] = 'post.createtime';
		$opt ['asc'] = 'tag.name';
		$opt ['match'] = false; // Post with no tags should be displayed too
		                        
		// order by createtime Desc and date posted need to be in that month
		                        // return $this->limit($limit, null, 'createtime', $opt); //without tags
		return $this->relateTag ( $opt );
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