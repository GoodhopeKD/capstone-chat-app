<?php 

class Token {
	public static function generate(){
		return Session::put_item('input_token', md5(uniqid()));
	}
	public static function is_valid( string $token ){
		$tokenName = 'input_token';
		if (Session::item_exists($tokenName) && $token === Session::get_item($tokenName)){
			Session::delete_item($tokenName);
			return true;
		}
		return false;
	}
}