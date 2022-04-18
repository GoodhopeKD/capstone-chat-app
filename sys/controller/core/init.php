<?php

/** path definitions */
define( 'SYS_PATH' , ABS_PATH . 'sys/' );
define( 'MODEL_PATH' , SYS_PATH . 'model/' );
define( 'VIEW_PATH' , SYS_PATH . 'view/' );
define( 'CONTROLLER_PATH' , SYS_PATH . 'controller/' );

/** Pull in configuration constants */
require( CONTROLLER_PATH . 'core/config.php' );
require( CONTROLLER_PATH . 'core/assets.php' );

/** Pull in all classes */
spl_autoload_register(function($class_name){
	if ( file_exists( MODEL_PATH . $class_name . '.php' ) )
		require_once ( MODEL_PATH . $class_name . '.php' );
	else if ( file_exists( CONTROLLER_PATH . 'class_aux/' . $class_name . '.php') )
		require_once ( CONTROLLER_PATH . 'class_aux/' . $class_name . '.php');
});

$DB = DB::getInstance();
Session::start();