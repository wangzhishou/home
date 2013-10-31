<?php
/**
 * Define your URI routes here.
 *
 * $route[Request Method][Uri] = array( Controller class, action method, other options, etc. )
 *
 * RESTful api support, *=any request method, GET PUT POST DELETE
 * POST 	Create
 * GET      Read
 * PUT      Update, Create
 * DELETE 	Delete
 *
 * Use lowercase for Request Method
 *
 * If you have your controller file name different from its class name, eg. home.php HomeController
 * $route['*']['/'] = array('home', 'index', 'className'=>'HomeController');
 * 
 * If you need to reverse generate URL based on route ID with UrlBuilder in template view, please defined the id along with the routes
 * $route['*']['/'] = array('HomeController', 'index', 'id'=>'home');
 *
 * If you need dynamic routes on root domain, such as http://facebook.com/username
 * Use the key 'root':  $route['*']['root']['/:username'] = array('UserController', 'showProfile');
 *
 * If you need to catch unlimited parameters at the end of the url, eg. http://localhost/paramA/paramB/param1/param2/param.../.../..
 * Use the key 'catchall': $route['*']['catchall']['/:first'] = array('TestController', 'showAllParams');
 * 
 * If you have placed your controllers in a sub folder, eg. /protected/admin/EditStuffController.php
 * $route['*']['/'] = array('admin/EditStuffController', 'action');
 * 
 * If you want a module to be publicly accessed (without using Q::app()->getModule() ) , use [module name] ,   eg. /protected/module/forum/PostController.php
 * $route['*']['/'] = array('[forum]PostController', 'action');
 * 
 * If you create subfolders in a module,  eg. /protected/module/forum/post/ListController.php, the module here is forum, subfolder is post
 * $route['*']['/'] = array('[forum]post/PostController', 'action');
 *
 * Aliasing give you an option to access the action method/controller through a different URL. This is useful when you need a different url than the controller class name.
 * For instance, you have a ClientController::new() . By default, you can access via http://localhost/client/new
 * 
 * $route['autoroute_alias']['/customer'] = 'ClientController';
 * $route['autoroute_alias']['/company/client'] = 'ClientController';
 * 
 * With the definition above, it allows user to access the same controller::method with the following URLs:
 * http://localhost/company/client/new
 *
 * To define alias for a Controller inside a module, you may use an array:
 * $route['autoroute_alias']['/customer'] = array('controller'=>'ClientController', 'module'=>'example');
 * $route['autoroute_alias']['/company/client'] = array('controller'=>'ClientController', 'module'=>'example');
 *
 * Auto routes can be accessed via URL pattern: http://domain.com/controller/method
 * If you have a camel case method listAllUser(), it can be accessed via http://domain.com/controller/listAllUser or http://domain.com/controller/list-all-user
 * In any case you want to control auto route to be accessed ONLY via dashed URL (list-all-user)
 *
 * $route['autoroute_force_dash'] = true;	//setting this to false or not defining it will keep auto routes accessible with the 2 URLs.
 *
 */

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

$route ['*'] ['/cat/:pinyin/page/:pindex'] = array (
		'BlogController',
		'getCat' 
);

$route ['*'] ['/clear'] = array (
		'MainController',
		'clearCache' 
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

$route ['*'] ['/post/create'] = array (
		'AdminController',
		'createPost' 
);

$route ['*'] ['/post/link'] = array (
		'AdminController',
		'createLink'
);

$route ['post'] ['/post/saveLink'] = array (
		'AdminController',
		'saveLink'
);

$route ['post'] ['/post/saveNew'] = array (
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
$route ['*'] ['/error'] = array (
		'ErrorController',
		'defaultError' 
);
$route ['*'] ['/error/loginFail'] = array (
		'ErrorController',
		'loginError' 
);
$route ['*'] ['/error/postNotFound/:pid'] = array (
		'ErrorController',
		'postError' 
);

?>