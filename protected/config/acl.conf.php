<?php
$acl ['admin'] ['allow'] = '*';
$acl ['anonymous'] ['allow'] = '*';

$acl ['anonymous'] ['deny'] = array (
		'AdminController' => array (
				'createPost',
				'saveNewPost' 
		) 
);

// failRoute
$acl ['anonymous'] ['failRoute'] = array (
		'_default' => '/user/login' 
);
?>