<?php

function rand_color() { return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); }

/* Get the path of a resource defined in the assets.php file */
function asset($path = null){
	if($path){
		$config = array_merge( $GLOBALS['src'] , $GLOBALS['img'] );
		$path = explode('/', $path);
		
		foreach($path as $bit){
			if(isset($config[$bit])){ $config = $config[$bit]; }
		}
		return $config;
	}
}

function load_header( string $title)
{
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <title><?php echo $title ?></title>

        <!-- Bootstrap core CSS -->

        <link rel="stylesheet" href="<?php echo asset('bootstrap/css/url') ?>" version="<?php echo asset('bootstrap/css/version') ?>" <?php echo (!LOCAL_SRC) ? 'integrity="'.asset('bootstrap/css/sri').'" crossorigin="anonymous"' : ""; ?>>
        <link rel="stylesheet" href="<?php echo asset('theme/css/url') ?>" version="<?php echo asset('theme/css/version') ?>" >
        <link rel="icon" href="<?php echo asset('logo/512x512/path') ?>">

        <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        </style>
    </head>
    <body>
 <?php
}

function load_footer()
{
?>
    <script src="<?php echo asset('bootstrap/js/url') ?>" version="<?php echo asset('bootstrap/js/version') ?>" <?php echo (!LOCAL_SRC) ? 'integrity="'.asset('bootstrap/js/sri').'" crossorigin="anonymous"' : ""; ?>></script>
    <script src="<?php echo asset('theme/js/url') ?>" version="<?php echo asset('theme/js/version') ?>" ></script>
    </body>
</html>
<?php
}