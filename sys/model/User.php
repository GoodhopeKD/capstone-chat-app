<?php

class User extends UserMin
{
    private $password,
            $join_datetime;

    public  $chats;

    public function __construct( int $id, string $username, string $password, string $join_datetime )
    {
        parent::__construct( $id, $username );
        $this->password = $password;
        $this->join_datetime = new NDateTime( $join_datetime );
    }

    public function load_chats() : void
    {
        if (!$this->chats)
        $this->chats = Chat::get_user_chats( $this->id );
        usort($this->chats, array($this,'fn_sort_chats'));
    }

    public function fn_sort_chats($a, $b)
    {
        return $a->last_message->get_sent_datetime() < $b->last_message->get_sent_datetime();
    }

    public function chat_with_correspondent( string $username ) : ?Chat 
    {
        $this->load_chats();
        foreach ($this->chats as $chat) {
            if ($chat->other_participant->get_username() == $username ){
                $chat->load_messages();
                return $chat;
            }
        }
        return null;
    }

    public static function get( int $id ) : ?User
    {
        global $DB;
        $user = $DB->get_entry( 'users', $id );
        return ( $user ) ? new User( $id, $user->username, $user->password, $user->join_datetime ) : null;
    }

    public static function find( $username ) : ?User
    {
        global $DB;
        $user = $DB->find_entry( 'users', 'username' , $username );
        return ( $user ) ? new User( $user->id, $username, $user->password, $user->join_datetime ) : null;
    }

    public function get_join_datetime() : NDateTime
    {
        return $this->join_datetime;
    }

    public static function login( string $username, string $plaintext_password ) : ?User
    {
        $username = new Input($username);
        $plaintext_password = new Input($plaintext_password);
        if ( $username->is_valid_username() && $plaintext_password->is_valid_password() ){
            $user = self::find( $username );
            if ( $user && $plaintext_password->matches_encrypted_password( $user->password ) ){
                return ( Session::log_user_in( $user->id ) ) ? $user : null;
            }
        }
        return null;
    }

    public function is_logged_in() : bool
    {
        return ( Session::has_logged_in_user() && Session::get_item( 'session_user_id' ) == $this->id );
    }

    public function logout() : void 
    {
        if ( $this->is_logged_in() )
            Session::log_user_out();
    }

    public static function register( string $username, string $plaintext_password ) : ?User
    {
        $username = new Input($username);
        $plaintext_password = new Input($plaintext_password);
        if ( $username->is_valid_username() && $plaintext_password->is_valid_password() && $username->is_unique_username() ){
            
            global $DB;
            $user = $DB->add_entry( 'users', 
                array(
                    'username'      => $username,
                    'password'      => $plaintext_password->password_encrypt(),
                    'join_datetime' => new NDateTime( 'now' )
                )
            );
            
            return ( $user && Session::log_user_in( $user->id ) ) ? new User( $user->id, $username, $user->password, $user->join_datetime ) : null;
        }
        return null;
    }

    public function send_message( string $message, UserMin $recepient ) : ?Message
    {
        return Message::send( $message, $recepient );
    }
}
