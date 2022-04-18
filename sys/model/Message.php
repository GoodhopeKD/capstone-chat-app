<?php

class Message
{
    private $id,
            $chat_id,
            $message_body,
            $sent_datetime,
            $belongs_to_user;

    public  $sender;

    public function __construct( int $id, int $chat_id, string $message_body, string $sent_datetime, int $sender_user_id )
    {
        if ( Session::has_logged_in_user() ){
            $this->id = $id;
            $this->chat_id = $chat_id;
            $this->message_body = $message_body;
            $this->sent_datetime = new NDateTime( $sent_datetime );
            $this->belongs_to_user = $sender_user_id == Session::$logged_in_user->get_id();
            $this->sender = ( $this->belongs_to_user ) ? new UserMin( Session::$logged_in_user->get_id(), 'You' ) : UserMin::get($sender_user_id); 
        }
    }

    public static function encrypt( $string ) : string {
        return $string;
    }

    public static function decrypt( $string ) : string {
        return $string;
    }

    public function belongs_to_user() : bool {
        return $this->belongs_to_user;
    }

    public function get_id() : int
    {
        return $this->id;
    }

    public function get_chat_id() : int
    {
        return $this->chat_id;
    }

    public function get_message_body() : string
    {
        return Message::decrypt( $this->message_body );
    }
    public function get_exerpt() : string
    {
        return ( strlen($this->message_body) > 75 ) ? substr( $this->message_body , 0, 70 ) . '...' : $this->message_body;
    }

    public function get_sent_datetime() : NDateTime
    {
        return $this->sent_datetime;
    }

    public static function get_chat_messages( int $chat_id ) : array
    {
        global $DB;
        $messages_raw = $DB->get_relational_entries( 'messages', 'chat_id', $chat_id );

        $messages = [];
        foreach ($messages_raw as $message_raw ) {
            array_push( $messages, new Message( $message_raw->id, $chat_id, $message_raw->message_body, $message_raw->sent_datetime, $message_raw->sender_user_id ) );
        }

        return $messages;
    }

    public static function send( string $message_body, UserMin $recepient ) : ?Message
    {
        global $DB;
        $chat = $DB->get_multikey_relational_entry( 'chats', [ 'participant_one_id', 'participant_two_id' ], [ Session::$logged_in_user->get_id(), $recepient->get_id() ] );
        if ( $chat ){
            $chat = new Chat( $chat->id, $chat->participant_one_id, $chat->participant_two_id );
        } else {
            $chat = Chat::create( Session::$logged_in_user->get_id(), $recepient->get_id() );
        }

        if ( $chat ){
            $message = $DB->add_entry( 'messages', array(
                'chat_id' => $chat->get_id(),
                'message_body' => Message::encrypt( $message_body ),
                'sent_datetime' => new NDateTime('now'),
                'sender_user_id' => Session::$logged_in_user->get_id()
            ) );

            return ( $message ) ? new Message( $message->id, $message->chat_id, $message->message_body, $message->sent_datetime, $message->sender_user_id ) : null;
        }
        return null;
    }
}
