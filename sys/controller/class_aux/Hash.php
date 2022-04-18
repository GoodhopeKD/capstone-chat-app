<?php 

class Hash{
	public static function make( string $plain_text ) : string
    {
		return password_hash( $plain_text, PASSWORD_BCRYPT, ['cost'=>11] );
	}

    public static function check( $plain_text, $hashed_text ) : bool
    {
        return password_verify( $plain_text, $hashed_text );
    }
}