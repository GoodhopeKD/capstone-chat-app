<?php

class Debug
{
    public static function form_autofill( $input ){
        return ( DEBUG_OVERALL ) ? $input : "";
    }
    
    public static function login_form_autofill( $input ){
        return ( DEBUG_LOGIN_FORM_AUTOFILL ) ? self::form_autofill($input) : "";
    }

    public static function registration_form_autofill( $input ){
        return ( DEBUG_REGISTRATION_FORM_AUTOFILL ) ? self::form_autofill($input) : "";
    }

    public static function message_form_autofill( $input ){
        return ( DEBUG_MESSAGE_FORM_AUTOFILL ) ? self::form_autofill($input) : "";
    }
}
