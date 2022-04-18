<?php

class NDate
{
    private $mysql_date,
            $date_in_sec,
            $year;

    public  $today;

    public function __construct( string $input_date )
    {
        $this->date_in_sec = strtotime( $input_date );
        $this->mysql_date = date( "Y-m-d", $this->date_in_sec );
        $this->year = date( "Y", $this->date_in_sec );

        $this->today = date('Y-m-d');
    }

    public function __toString()
    {
        return $this->mysql_date;
    }

    public function get_display_date() : string
    {
        $now = strtotime('now');

        if ( $now - $this->date_in_sec > 0 ){
        
            if ( $now - $this->date_in_sec < 60*60*24 && date( "j", $now ) == date( "j", $this->date_in_sec ) ) // Date is today
                return "Today";

            if ( $now - $this->date_in_sec < 60*60*24*2 && date( "j", $now ) == date( "j", $this->date_in_sec ) + 1 ) // Date is yesterday
                return "Yesterday";

            if ( $now - $this->date_in_sec < 60*60*24*7 ) // Date is less than a week
                return date( "N", $this->date_in_sec ) . ' days ago';

            if ( $now - $this->date_in_sec < 60*60*24*365 && date( "Y", $now ) == date( "Y", $this->date_in_sec ) ) // Date is this year
                return date( "l, j F", $this->date_in_sec ); // Thursday, 21 December

        } else {

            if ( ($now - $this->date_in_sec)*-1 < 60*60*24*2 && date( "j", $now ) == date( "j", $this->date_in_sec ) + 1 ) // Date is yesterday
                return "Tomorrow";

            if ( ($now - $this->date_in_sec)*-1 < 60*60*24*7 ) // Date is less than a week
                return date( "N", $this->date_in_sec ) . ' days to come';

            if ( ($now - $this->date_in_sec < 60*60*24*365)*-1 && date( "Y", $now ) == date( "Y", $this->date_in_sec ) ) // Date is this year
                return date( "l, j F", $this->date_in_sec ); // Thursday, 21 December

        }

        return date( "j F Y", $this->date_in_sec ); // 21 December 2016
    }

    public function get_year() : int
    {
        return $this->year;
    }
}
