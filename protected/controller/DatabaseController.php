<?php
Q::loadController ( 'CoreController' );
class DatabaseController extends CoreController {
	/**
	 * start check
	 *
	 * @see Controller::beforeRun()
	 */
	public function beforeRun($resource, $action) {
		if (! isset ( $_SESSION )) {
			session_start ();
		}
		if (isset ( $_SESSION ['user'] )) {
			$this->data ['user'] = $_SESSION ['user'];
		} else {
			$this->data ['user'] = null;
		}
		$this->data ['baseurl'] = Q::conf ()->APP_URL;
		$this->data ['siteTitle'] = Q::conf ()->siteTitle;
		$this->data ['head'] = '';
		$role = (isset ( $_SESSION ['user'] ['group'] )) ? $_SESSION ['user'] ['group'] : 'anonymous';
		$rs = $this->acl ()->process ( $role, $resource, $action );
		if (isset ( $rs )) {
			return $rs;
		}
	}
	public function updateDatabase() {
		echo '<h1>Update Database to Head</h1>' . PHP_EOL;
		
		/* DB Updater Code will go here later */
		
		echo '<p>Done Updating the Database</p>';
		exit ();
	}
	public function dropDatabase() {
		Q::loadCore ( 'db/manage/ManageDb' );
		$table = $this->params ['filename'];
		if (isset ( $table )) {
			Q::db ()->deleteAll ( $table );
			echo '删除表数据成功！';
		}
	}
}
?>