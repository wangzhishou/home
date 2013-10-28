<?php
include './protected/config/common.conf.php';
include './protected/config/routes.conf.php';
include './protected/config/db.conf.php';
include './protected/config/acl.conf.php';
include './protected/config/site.conf.php';

#Just include this for production mode
//include $config['BASE_PATH'].'deployment/deploy.php';
include $config['BASE_PATH'].'Q.php';
include $config['BASE_PATH'].'app/Config.php';

# Uncomment for auto loading the framework classes.
//spl_autoload_register('Q::autoload');

Q::conf()->set($config);

# remove this if you wish to see the normal PHP error view.
include $config['BASE_PATH'].'diagnostic/debug.php';

Q::acl()->rules = $acl;
Q::acl()->defaultFailedRoute = '/error';

# database usage
//Q::useDbReplicate();	#for db replication master-slave usage
Q::db()->setMap($dbmap);
Q::db()->setDb($dbconfig, $config['APP_MODE']);
Q::db()->sql_tracking = true;	#for debugging/profiling purpose

Q::app()->route = $route;

# Uncomment for DB profiling
Q::logger()->beginDbProfile('website');
Q::app()->run();
Q::logger()->endDbProfile('website');
Q::logger()->rotateFile(40);
Q::logger()->writeDbProfiles();
?>