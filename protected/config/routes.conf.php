<?php
// main
$route ['*'] ['/'] = array (
		'MainController',
		'home' 
);
$route ['*'] ['/c/:pinyin'] = array (
		'BlogController',
		'getCat',
		'extension' => array (
				'.html' 
		) 
);

$route ['*'] ['/c/:pinyin/p/:pindex'] = array (
		'BlogController',
		'getCat' 
);

$route ['*'] ['/a/:postId'] = array (
		'BlogController',
		'getArticle',
		'extension' => array (
				'.html' 
		) 
);

$route ['*'] ['/debug/:filename'] = array (
		'MainController',
		'debug' 
);

$route ['*'] ['/drop/:filename'] = array (
		'DatabaseController',
		'dropDatabase' 
);

/**
 * blog
 */
$route ['*'] ['/comment/submit'] = array (
		'BlogController',
		'newComment' 
);

$route ['*'] ['/tag/:name'] = array (
		'BlogController',
		'getTag' 
);
$route ['*'] ['/tag/:name/page/:pindex'] = array (
		'BlogController',
		'getTag' 
);

$route ['*'] ['/post/like'] = array (
		'BlogController',
		'likePost'
);

$route ['*'] ['/post/fav'] = array (
		'BlogController',
		'favPost'
);

$route ['*'] ['/go/:pid'] = array (
		'BlogController',
		'gotoUrl'
);

/**
 * admin
 */
$route ['*'] ['/clear'] = array (
		'AdminController',
		'clearCache' 
);
$route ['*'] ['/post/create'] = array (
		'AdminController',
		'createPost' 
);

$route ['*'] ['/post/link'] = array (
		'AdminController',
		'createLink' 
);

$route ['*'] ['/post/saveLink'] = array (
		'AdminController',
		'saveLink' 
);

$route ['*'] ['/post/saveNew'] = array (
		'AdminController',
		'saveNewPost' 
);

$route ['post'] ['/post/save'] = array (
		'AdminController',
		'savePostChanges' 
);

$route ['*'] ['/post/edit/:pid'] = array (
		'AdminController',
		'editPost' 
);

$route ['post'] ['/post/imageUp'] = array (
		'AdminController',
		'imageUp' 
);

$route ['post'] ['/post/thumbUp'] = array (
		'AdminController',
		'thumbUp' 
);

$route ['*'] ['/post/saveSuccess'] = array (
		'AdminController',
		'saveSuccess' 
);

/**
 * User
 */
$route ['*'] ['/u/index'] = array (
		'UserController',
		'index'
);
$route ['*'] ['/user/login'] = array (
		'UserController',
		'login' 
);
$route ['*'] ['/user/reg'] = array (
		'UserController',
		'reg' 
);
$route ['*'] ['/user/logout'] = array (
		'UserController',
		'logout' 
);
$route ['*'] ['/user/check'] = array (
		'UserController',
		'check' 
);
$route ['*'] ['/user/regsuccess'] = array (
		'UserController',
		'regSuccess' 
);

/**
 * Error
 */
$route ['*'] ['/error'] = array (
		'ErrorController',
		'index' 
);

?>