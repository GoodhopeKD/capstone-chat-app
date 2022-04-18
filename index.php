<?php

// Extract site url from path to index file
$page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";    
$page_url.= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

/** SITE_URL **/
//define( 'SITE_URL' , "https://capstone-chat-app.000webhostapp.com/" );
define( 'SITE_URL' , "http://localhost/capstone-chat-app/" );

/** initial path definitions **/
define( 'ABS_PATH' , dirname(__FILE__).'/' );

/** Initialize application */
require_once( ABS_PATH . 'sys/controller/core/init.php' );

if ( Input::exists('get') ){
    $get_param_1 = Input::get('get_param_1');
    $get_param_2 = Input::get('get_param_2');
    $get_param_3 = Input::get('get_param_3');
}

if ( Session::has_logged_in_user() ){

    if ( !Input::exists('get') ){   
        Redirect::to('chats/');
    }

    $file = 'view/chats';
    $title = "Chats - Cybersecurity Capstone Chat App";

    switch ($get_param_1) {

        case 'chats': break;

        case 'chat':
            $get_param_2 = new Input($get_param_2);
            if ( $get_param_2 == "new" || ( $get_param_2->is_valid_username() && !$get_param_2->is_unique_username() ) ){
                $file = 'view/chat-{username}';
                if ( $get_param_3 == 'send_message' ){
                    if ( Input::exists('post') && Input::get('message') != '' ){
                        $file = 'controller/chat-{username}-send_message';
                    } else {
                        Redirect::to('chat/'.$get_param_2.'/');
                    }   
                }
            } else {
                Redirect::to('chats/');
            }
            break;
        
        case 'users':
            $file = 'view/users';
            break;
        
        case 'user':
            if ( $get_param_2 == 'logout' ){
                $file = 'controller/user-logout';
            } else {
                Redirect::to('chats/');
            }
            break;

        case 'dbdump':

        $dir = dirname(__FILE__) . '/capstone-chat-app.sql';

        echo "<h3>Dumping database to `<code>{$dir}</code>`</h3>";

        $host = DB_HOST;
        $user = DB_USER;
        $password = DB_PASSWORD;
        $name = DB_NAME;
        $mysqldump = MYSQLDUMP;

        exec("{$mysqldump} --user={$user} --password={$password} --host={$host} {$name} --result-file={$dir} 2>&1", $output);

        break;

        default : Redirect::to('chats/'); break;
    }

} else {
    if ( !Input::exists('get') ){ 
        Redirect::to('user/login/');
    }

    switch ($get_param_1) {
        case 'user':
            switch ($get_param_2) {
                case 'register':
                    $title = "Register - Cybersecurity Capstone Chat App";
                    $file = 'view/user-register';
                    break;
                
                default:
                    $file = 'view/user-login';
                    $title = "Login - Cybersecurity Capstone Chat App";
                    break;
            }
            break;

        case 'dbdump':

        $dir = dirname(__FILE__) . '/capstone-chat-app.sql';

        echo "<h3>Dumping database to `<code>{$dir}</code>`</h3>";

        $host = DB_HOST;
        $user = DB_USER;
        $password = DB_PASSWORD;
        $name = DB_NAME;
        $mysqldump = MYSQLDUMP;

        exec("{$mysqldump} --user={$user} --password={$password} --host={$host} {$name} --result-file={$dir} 2>&1", $output);

        break;

        default : Redirect::to('user/login/'); break;
    }

}

if (!in_array($get_param_1,['dbdump'])){

    require_once( ABS_PATH . 'sys/view/loader.php' );

    load_header($title);

    require_once( ABS_PATH . 'sys/' . $file . '.php' );

    load_footer();

}