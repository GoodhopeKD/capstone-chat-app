<?php

class UserMin
{
    protected $id,
            $username;

    public function __construct( int $id , string $username )
    {
        $this->id = $id;
        $this->username = $username;
    }

    public function get_id() : int
    {
        return $this->id;
    }

    public function get_username() : string
    {
        return $this->username;
    }

    public static function get( int $id ) : ?UserMin
    {
        global $DB;
        $username = $DB->get_entry_field( 'users', $id, 'username' );
        return ( $username ) ? new UserMin( $id, $username ) : null;
    }

    public static function get_all() : array
    {
        global $DB;
        $users_raw = $DB->get_entries( 'users' );

        $users = [];
        foreach ($users_raw as $user ) {
            array_push( $users,new UserMin( $user->id, $user->username ) );
        }

        return $users;
    }

    public static function find( $username ) : ?UserMin
    {
        global $DB;
        $user = $DB->find_entry( 'users', 'username' , $username );
        return ( $user ) ? new UserMin( $user->id, $username ) : null;
    }
}
