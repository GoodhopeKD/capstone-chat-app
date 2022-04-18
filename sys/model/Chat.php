<?php

class Chat
{
    private $id;

    public  $other_participant,
            $last_message,
            $messages;

    public function __construct( int $id, int $participant_one_id, int $participant_two_id )
    {
        if ( Session::has_logged_in_user() ){
            $this->id = $id;
            $this->other_participant = ( $participant_one_id == Session::$logged_in_user->get_id() ) ? UserMin::get($participant_two_id) : UserMin::get($participant_one_id);
        }
    }

    public function get_id() : int 
    {
        return $this->id;
    }

    public static function get( int $id ) : ?Chat
    {
        global $DB;
        $chat_raw = $DB->get_entry( 'chats', $id );
        if ( $chat_raw ){
            $chat = new Chat( $id, $chat_raw->participant_one_id, $chat_raw->participant_two_id );
            $chat->load_messages();
            return $chat;
        }
        return null;
    }

    public function load_messages() : void
    {
        if ( !$this->messages )
        $this->messages = Message::get_chat_messages( $this->id );
        $this->last_message = end( $this->messages );
    }

    public static function get_user_chats( int $user_id ) : array
    {
        global $DB;
        $chats_raw = $DB->get_multikey_relational_entries( 'chats', [ 'participant_one_id', 'participant_two_id' ], $user_id );

        $chats = [];
        foreach ($chats_raw as $chat_raw ) {
            $chat = new Chat( $chat_raw->id, $chat_raw->participant_one_id, $chat_raw->participant_two_id );
            $chat->load_messages();
            array_push( $chats, $chat );
        }

        return $chats;
    }

    public static function create( int $user_id, int $other_participant_id ) : ?Chat
    {
        if ( Session::has_logged_in_user() && Session::$logged_in_user->get_id() == $user_id ){
            global $DB;
            if ( !$DB->multikey_entry_field_value_exists( 'chats', [ 'participant_one_id', 'participant_two_id' ], [ $user_id, $other_participant_id ] ) ){
                $chat = $DB->add_entry( 'chats', 
                    array(
                        'participant_one_id'      => $user_id,
                        'participant_two_id'      => $other_participant_id,
                    )
                );
                return ( $chat ) ? new Chat ( $chat->id, $chat->participant_one_id, $chat->participant_two_id ) : null;
            }
        }
        return null;
    }

}
