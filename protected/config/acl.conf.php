<?php
$acl ['admin'] ['allow'] = '*';

$acl ['anonymous'] ['allow'] = array (
		'AdminController' => array (
				'imageUp',
				'thumbUp' 
		) 
);

// failRoute
$acl ['anonymous'] ['failRoute'] = array (
		'_default' => '/user/login' 
);
?>