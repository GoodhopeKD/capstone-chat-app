<?php

/** Set timezone **/
date_default_timezone_set( 'Africa/Algiers' );

/** MySQL database table name **/
define( 'DB_NAME' , 'capstone-chat-app' );
//define( 'DB_NAME' , 'id17778299_capstone_chat_app_db' );

/** MySQL database username **/
define( 'DB_USER' , 'root' );
//define( 'DB_USER' , 'id17778299_capstone_chat_app_user' );

/** MySQL database pwd **/
define( 'DB_PASSWORD' , '' );
//define( 'DB_PASSWORD' , 'o=bM)0/Ro@za]fOv' );

/** MySQL hostname **/
define( 'DB_HOST' , 'localhost' );

/** Set sources local dir **/
define( 'LOCAL_SRC_DIR' , 'http://localhost/cdn.emu/' );

/** Set sources to local or cdn served **/
define( 'LOCAL_SRC' , false );

/** Set location of mysqldump file
on XAMMP MacOS use '/Applications/XAMPP/xamppfiles/bin/mysqldump'
on XAMPP Windows use 'C:\xampp\mysql\bin\mysqldump'
on webhost server, use 'mysqldump'
use appropriate for your system **/
define( 'MYSQLDUMP' , '/Applications/XAMPP/xamppfiles/bin/mysqldump');

/** Set overall debugging status **/
define( 'DEBUG_OVERALL' , false );

/** Debug Items **/
define( 'DEBUG_LOGIN_FORM_AUTOFILL' , true );

define( 'DEBUG_REGISTRATION_FORM_AUTOFILL' , true );

define( 'DEBUG_MESSAGE_FORM_AUTOFILL' , true );
