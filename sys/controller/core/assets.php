<?php

$GLOBALS['src'] = array(

	// Bootstrap
	'bootstrap' => array(
		'css' 		=> array(
			'url' 		=> 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css',
			'version' 	=> '5.0.0',
			'sri' 		=> 'sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6',
		),
		'js' 			=> array(
			'url' 		=> 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js',
			'version' 	=> '5.0.0',
			'sri' 		=> 'sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf',
		),		
	),

	// System theme
	'theme' => array(
		'css' => array(
			'url' 		=> SITE_URL."src/ui.css",
			'version' => '1.0.0',
		),
		'js' => array(
			'url' 		=> SITE_URL."src/ui.js",
			'version' => '1.0.0',
		),
	),

);

if (LOCAL_SRC){
	$GLOBALS['src']['bootstrap']['css']['url'] = LOCAL_SRC_DIR . 'bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css';
	$GLOBALS['src']['bootstrap']['js']['url'] = LOCAL_SRC_DIR . 'bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js';
}

$GLOBALS['img'] = array(
	'logo' => array(
        '512x512' => array(
			'path' 	=> SITE_URL . 'src/img/logo-512x512.png',
		),
	),
);