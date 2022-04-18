<?php
/**
 * 
 */
class Input
{
    // focus variable
    public $input;

    // boolean test stores
    private $is_valid_username,
            $is_unique_username;

    // constructor
    public function __construct( $input )
    {
        $this->input = $input;
    }

    // output
    public function __toString()
    {
        return $this->input;
    }

    /* sanitization method */
    public function sanitize() : void // changes value of variable
    {
        $this->input = substr( htmlspecialchars($this->input) , 0 , 4096 );
    }  

    /* Validation methods */
    public function is_valid_username() : bool
    {
        $this->is_valid_username = ( $this->is_valid_username != null ) ? $this->is_valid_username : ( strlen( $this->input ) >= 5 && strlen( $this->input ) <= 32 && preg_match("/^[a-zA-Z0-9_]+$/", $this->input) );
        return $this->is_valid_username;
    }

    public function is_unique_username() : bool
    {
        global $DB;
        $this->is_unique_username = ( $this->is_unique_username != null ) ? $this->is_unique_username : ( ! $DB->entry_field_value_exists('users','username',$this->input) );
        return $this->is_unique_username;
    }

    public function is_valid_password() : bool
    {
        $min_length = 8;
        $max_length = 72;
         
        $contains_uppercase = preg_match('@[A-Z]@', $this->input); // Contains at least 1 uppercase letter
        $contains_lowercase = preg_match('@[a-z]@', $this->input); // Contains at least 1 lowercase letter
        $contains_number    = preg_match('@[0-9]@', $this->input); // Contains at least 1 number
        $is_between_bounds  = ( strlen($this->input) >= $min_length && strlen($this->input) <= $max_length );
        return ( preg_match("/^[a-zA-Z0-9_]+$/", $this->input) && $contains_uppercase && $contains_lowercase && $contains_number && $is_between_bounds );
    }

    public function password_encrypt() : string // Return only
    {
        return Hash::make( $this->input );
    }

    public function matches_encrypted_password( string $hashed_password ) : bool
    {
        return Hash::check( $this->input, $hashed_password );
    }

    public function matches_password( string $test_password ) : bool
    {
        return ( $this->input == $test_password );
    }

    public function is_valid_message() : bool
    {
        return ( true );
    }

    /* static auxilliary methods */
	public static function exists( string $type = 'post') : bool
	{   
		switch ($type){
			case 'post':
				return (!empty($_POST)) ? true : false;
			break;
			case 'get':
				return (!empty($_GET)) ? true : false;
			break;
			default:
				return false;
			break;
		}
	}	
	
	public static function get( string $item )
	{
		if (isset($_POST[$item])){
			return $_POST[$item];
		} else if (isset($_GET[$item])){
			return $_GET[$item];
		}
		return '';
	}
}