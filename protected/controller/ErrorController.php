<?php
Q::loadController ( 'CoreController' );
class ErrorController extends CoreController {
	public function index() {
		$this->data ['status'] = 'error';
		$this->data ['title'] = '访问错误：';
		$this->data ['content'] = '<p style="color:#ff0000;">网页没找到或暂无内容！</p>';
		$this->data ['content'] .= '<p><a href="' . $this->data ['baseurl'] . '">网站首页</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.back();">返回</a>.</p>';
		$this->render ( 'error', $this->data );
	}
}
?>