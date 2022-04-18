<?php 

class Session {

	public static	$logged_in_user = null;
	public static	$logged_in_user_min = null;
	private static	$has_logged_in_user = null;

	public static function start() : void
	{
		session_start();
		if ( self::has_logged_in_user() ){
			self::$logged_in_user = User::get( self::get_item( 'session_user_id' ) );
			self::$logged_in_user_min = new UserMin( self::$logged_in_user->get_id(), self::$logged_in_user->get_username() );
			self::$logged_in_user->load_chats();
		}
	}

	public static function has_logged_in_user() : bool
	{
		if ( self::$has_logged_in_user == null ){
			global $DB;
			self::$has_logged_in_user = ( self::item_exists( 'session_user_id' ) && is_numeric( self::get_item( 'session_user_id' ) ) && $DB->entry_field_value_exists( 'users', 'id', self::get_item( 'session_user_id' ) ) ) ? true : false;
		}
		
		return  self::$has_logged_in_user;
	}

	public static function log_user_in( int $user_id )
	{
		return self::put_item( 'session_user_id', $user_id );
	}

	public static function log_user_out() : void
	{
		self::delete_item( 'session_user_id' );
		session_destroy();
	}

	public static function item_exists($name) : bool
    {
		return (isset($_SESSION[$name])) ? true : false;
	}
	
	public static function put_item( string $name, $value)
    {
		return $_SESSION[$name] = $value;
	}
	
	public static function get_item( string $name )
    {
		return $_SESSION[$name];
	}
	
	public static function delete_item( string $name ) : void
    {
		if(self::item_exists($name)){
			unset($_SESSION[$name]);
		}
	}
	
	public static function flash( string $name, string $string = '')
    {
		if (self::item_exists($name)){
			$session = self::get_item($name);
			self::delete_item($name);
			return $session;
		} else {
			return self::put_item($name, $string);
		}
	}
}