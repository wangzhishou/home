<?php

// register global/PHP functions to be used with your template files
// You can move this to common.conf.php $config['TEMPLATE_GLOBAL_TAGS'] = array('isset', 'empty');
// Every public static methods in TemplateTag class (or tag classes from modules) are available in templates without the need to define in TEMPLATE_GLOBAL_TAGS
Q::conf ()->TEMPLATE_GLOBAL_TAGS = array (
		'upper',
		'tofloat',
		'in_array',
		'implode',
		'sample_with_args',
		'debug',
		'url',
		'url2',
		'function_deny',
		'isset',
		'empty',
		'formatDate',
		'formatDate2',
		'shorten',
		'urlencode',
		'urldecode' 
);

/**
 * Define as class (optional)
 *
 * class TemplateTag {
 * public static test(){}
 * public static test2(){}
 * }
 */
function upper($str) {
	return strtoupper ( $str );
}
function tofloat($str) {
	return sprintf ( "%.2f", $str );
}
function sample_with_args($str, $prefix) {
	return $str . ' with args: ' . $prefix;
}
function debug($var) {
	if (! empty ( $var )) {
		echo '<pre>';
		print_r ( $var );
		echo '</pre>';
	}
}

// This will be called when a function NOT Registered is used in IF or ElseIF statment
function function_deny($var = null) {
	echo '<span style="color:#ff0000;">Function denied in IF or ElseIF statement!</span>';
	exit ();
}

// Build URL based on route id
function url2($id, $param = null, $addRootUrl = false) {
	Q::loadHelper ( 'UrlBuilder' );
	// param pass in as string with format
	// 'param1=>this_is_my_value, param2=>something_here'
	
	if ($param != null) {
		$param = explode ( ', ', $param );
		$param2 = null;
		foreach ( $param as $p ) {
			$splited = explode ( '=>', $p );
			$param2 [$splited [0]] = $splited [1];
		}
		return UrlBuilder::url ( $id, $param2, $addRootUrl );
	}
	
	return UrlBuilder::url ( $id, null, $addRootUrl );
}

// Build URL based on controller and method name
function url($controller, $method, $param = null, $addRootUrl = false) {
	Q::loadHelper ( 'UrlBuilder' );
	// param pass in as string with format
	// 'param1=>this_is_my_value, param2=>something_here'	
	if ($param != null) {
		$param = explode ( ', ', $param );
		$param2 = null;
		foreach ( $param as $p ) {
			$splited = explode ( '=>', $p );
			$param2 [$splited [0]] = $splited [1];
		}
		return UrlBuilder::url2 ( $controller, $method, $param2, $addRootUrl );
	}	
	return UrlBuilder::url2 ( $controller, $method, null, $addRootUrl );
}
function formatDate($date, $format = 'jS F, Y h:i:s A') {
	$date = strtotime ( $date );
	$result = '';
	$time = time () - $date;
	if ($time < 60) {
		$result = $time . '秒前';
	} else if ($time < 1800) {
		$result = floor ( $time / 60 ) . '分钟前';
	} else if ($time < 3600) {
		$result = '半小时前';
	} else if ($time < 86400) {
		$result = floor ( $time / 3600 ) . '小时前';
	} else {
		$zt = strtotime ( date ( 'Y-m-d 00:00:00' ) );
		$qt = strtotime ( date ( 'Y-m-d 00:00:00', strtotime ( "-1 day" ) ) );
		$st = strtotime ( date ( 'Y-m-d 00:00:00', strtotime ( "-2 day" ) ) );
		$bt = strtotime ( date ( 'Y-m-d 00:00:00', strtotime ( "-7 day" ) ) );
		if ($date < $bt) {
			$result = date ( 'Y-m-d H:i:s', $date );
		} else if ($date < $st) {
			$result = floor ( $time / 86400 ) . '天前';
		} else if ($date < $qt) {
			$result = "前天" . date ( 'H:i', $date );
		} else {
			$result = '昨天' . date ( 'H:i', $date );
		}
	}
	return $result;
}
function formatDate2($date, $format = 'Y年m月d日') {
	$date = strtotime ( $date );
	return date ( $format, $date );
}
function shorten($str, $limit = 120) {
	Q::loadHelper ( 'TextHelper' );
	return TextHelper::limitWord ( $str, $limit );
}
?>