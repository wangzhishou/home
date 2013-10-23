<?php
// rules for create Post form
return array (
		'title' => array (
				array (
						'maxlength',
						145,
						'标题不能超过70个汉字。' 
				),
				array (
						'notnull' 
				),
				array (
						'notEmpty',
						'文章标题不能为空。' 
				) 
		),
		
		'summary' => array (
				array (
						'maxlength',
						300,
						'文章摘要不能超过150个汉字。' 
				),
				array (
						'notnull' 
				),
				array (
						'notEmpty',
						'摘要不能为空。' 
				) 
		),
		
		'thumbnails' => array (
				array (
						'notnull' 
				),
				array (
						'notEmpty',
						'文章主图不能为空。' 
				) 
		),
		
		'content' => array (
				array (
						'notnull' 
				),
				array (
						'notEmpty',
						'文章内容不能为空。' 
				) 
		),
		
		'cats' => array (
				array (
						'notnull' 
				),
				array (
						'notEmpty',
						'请选择文章分类。' 
				),
				array (
						'custom',
						'AdminController::checkCats' 
				) 
		),
		
		'tags' => array (
				array (
						'custom',
						'AdminController::checkTags' 
				),
				array (
						'optional' 
				) 
		) 
);
?>