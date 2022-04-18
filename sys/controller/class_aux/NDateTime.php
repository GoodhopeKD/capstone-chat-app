<?php

class NDateTime extends NDate
{
    private $mysql_datetime,
            $datetime_in_sec,
            $time;

    public function __construct( string $input_datetime )
    {
        parent::__construct( $input_datetime );

        $this->datetime_in_sec = strtotime( $input_datetime );

        $this->mysql_datetime = date( "Y-m-d H:i:s", $this->datetime_in_sec );
        $this->time = date( "H:i", $this->datetime_in_sec );
    }

    public function __toString() : string
    {
        return $this->mysql_datetime;
    }

    public function get_display_datetime() : string
    {
        $now = strtotime('now');

        $time_diff = $now - $this->datetime_in_sec;

        if ( $time_diff >= 0 ){

            if ( $time_diff == 0 ) // Just now
                return 'Just now';

            if ( $time_diff == 1 ) // Just now
                return 'A second ago';

            if ( $time_diff < 60 ) // Time is in a minute
                return ltrim( date( "s", $time_diff ) , '0' ) . ' seconds ago';

            if ( $time_diff < 60*2 ) // Time is in an hour
                return 'A minute ago';

            if ( $time_diff < 60*60 ) // Time is in an hour
                return ltrim( date( "i", $time_diff ) , '0' ) . ' minutes ago';
        
            if ( $time_diff < 60*60*24 && date( "j", $now ) == date( "j", $this->datetime_in_sec ) ) // Date is today
                return "Today at " . $this->time;

            if ( $time_diff < 60*60*24*2 && date( "j", $now ) == date( "j", $this->datetime_in_sec ) + 1 ) // Date is yesterday
                return "Yesterday at " . $this->time;

            if ( $time_diff < 60*60*24*7 ) // Date is less than a week
                return "Last " . date( "l", $this->datetime_in_sec ) . ' at ' .  $this->time; // Last Friday at 12:45

        } else {

            $time_diff = abs($time_diff);

            if ( $time_diff < 60 ) // Time is in a minute
                return ltrim( date( "s", $time_diff ) , '0' ) . ' seconds to come';

            if ( $time_diff < 60*60 ) // Time is in an hour
                return ltrim( date( "i", $time_diff ) , '0' ) . ' minute(s) to come';
        
            if ( $time_diff < 60*60*24 && date( "j", $now ) == date( "j", $this->datetime_in_sec ) ) // Date is today
                return "Today at " . $this->time;

            if ( $time_diff < 60*60*24*2 && date( "j", $now ) == date( "j", $this->datetime_in_sec ) + 1 ) // Date is yesterday
                return "Tomorrow at " . $this->time;

            if ( $time_diff < 60*60*24*7 ) // Date is less than a week
                return "Next " . date( "l", $this->datetime_in_sec ) . ' at ' .  $this->time; // Last Friday at 12:45

        }

        if ( abs($time_diff) < 60*60*24*28 && date( "n", $now ) == date( "n", $this->datetime_in_sec ) ) // Date is this month
            return date( "D, j M", $this->datetime_in_sec ) . ' at ' .  $this->time; // Fri, 21 Dec at 12:45

        if ( abs($time_diff) < 60*60*24*365 && date( "Y", $now ) == date( "Y", $this->datetime_in_sec ) ) // Date is this year
            return date( "j M", $this->datetime_in_sec ) . ' at ' .  $this->time; // 21 Dec at 12:45

        return date( "j M Y", $this->datetime_in_sec ) . ' at ' .  $this->time; // 21 Dec 2018 at 12:33
    }
}
